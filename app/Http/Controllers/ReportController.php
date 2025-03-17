<?php

namespace App\Http\Controllers;

use App\Models\Brifing;
use App\Models\CheckHazmat;
use App\Models\Deck;
use App\Models\DesignatedPersionShip;
use App\Models\DesignatedPerson;
use App\Models\Exam;
use App\Models\Hazmat;
use App\Models\partManuel;
use App\Models\PoOrderItemsHazmats;
use App\Models\PreviousAttachment;
use App\Models\Ship;
use App\Models\Summary;
use App\Traits\PdfGenerator;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

ini_set("pcre.backtrack_limit", "1000000");
ini_set('exif.decode_jpeg', '0');

class ReportController extends Controller
{
    //
    use PdfGenerator;
    public function genrateReport(Request $request)
    {
        $version = 1;
        $post = $request->input();
        $ship_id = $post['ship_id'];
        $logoPath = public_path('assets/images/logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logo = 'data:image/png;base64,' . $logoData;

        $date = date('y-m-d');
        $projectDetail = Ship::with('client.hazmatCompaniesId')->find($ship_id);
        $is_report_logo = $projectDetail['client']['is_report_logo'];
        if ($is_report_logo == 0) {
            $image = $projectDetail['client']['hazmatCompaniesId']['logo'];
            $logoPath = public_path('uploads/hazmatCompany/' . $image);
        } else {
            $image = $projectDetail['client']['client_image'];
            $logoPath = public_path('uploads/clientcompany/' . $image);
        }
        $logoData = base64_encode(file_get_contents($logoPath));
        $logo = 'data:image/png;base64,' . $logoData;

        $mpdf = new Mpdf([
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 20,
            'margin_header' => 0,
            'margin_footer' => 10,
            'defaultPagebreakType' => 'avoid',
            'imageProcessor' => 'GD', // or 'imagick' if you have Imagick installed
            'jpeg_quality' => 75, // Set the JPEG quality (0-100)
            'shrink_tables_to_fit' => 1, // Shrink tables to fit the page width
            'tempDir' => __DIR__ . '/tmp', // Set a temporary directory for mPDF
            'default_font' => 'dejavusans',


            'allow_output_buffering' => true,
        ]);
        $mpdf->SetCompression(true);

        $mpdf->use_kwt = true;

        $mpdf->defaultPageNumStyle = '1';
        $mpdf->SetDisplayMode('fullpage');

        // Define header content with logo
        $header = '
        <table width="100%" style="vertical-align: middle; font-family: serif; font-size: 9pt; color: #000088;">
            <tr>
                <td width="10%"><img src=' . $logo . ' width="50" /></td>
                <td width="75%" align="center">' . $projectDetail['ship_name'] . '</td>
                <td width="15%" style="text-align: right;">Current Version :' . $version . '</td>
        </tr>
        
        </table>';

        // Define footer content with page number
        $footer = '
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;">
            <tr>
                <td width="33%" style="text-align: left;">' . $projectDetail['ihm_table'] . '</td>
                <td width="33%" style="text-align: center;">Revision:' . $version . '</td>
                <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
            </tr>
        </table>';

        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);

        // Load main HTML content
        $mpdf->h2toc = ['H2' => 0, 'H3' => 1];
        $mpdf->h2bookmarks = ['H2' => 0, 'H3' => 1];
        // Set header and footer

        // Add Table of Contents
        $stylesheet = file_get_contents('public/assets/mpdf.css');

        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $shipImagePath = asset('uploads/ship/' . $projectDetail['ship_image']);

        $shipImageData = base64_encode(file_get_contents($shipImagePath));
        $shipImage = 'data:image/png;base64,' . $shipImageData;

        $html = view('main-report.cover', compact('projectDetail', 'shipImage', 'shipImagePath'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $hazmats = Hazmat::get();
        $html = view('main-report.abbreviation', compact('hazmats'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        //ship particular
        $html = view('main-report.shipParticular', compact('projectDetail'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        //DesignatedPerson
        $designatedPersonShip = DesignatedPersionShip::with('designatedPersonDetail')->where('ship_id', $ship_id)->get();
        $mergedData = $designatedPersonShip->pluck('designatedPersonDetail');

        $html = view('main-report.designatedPerson', compact('mergedData'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $checkHazmatIHMPart = CheckHazmat::with(relations: 'hazmat')->where('ship_id', $ship_id)->get();
        $filteredResults1 = $checkHazmatIHMPart->filter(function ($item) {
            return $item->ihm_part_table == 'i-1';
        });

        $filteredResults2 = $checkHazmatIHMPart->filter(function ($item) {
            return $item->ihm_part_table == 'i-2';
        });

        $filteredResults3 = $checkHazmatIHMPart->filter(function ($item) {
            return $item->ihm_part_table == 'i-3';
        });

        $html = view('main-report.IHMPart', compact('filteredResults1', 'filteredResults2', 'filteredResults3'))->render();
        $mpdf->AddPage('L'); // Set landscape mode for the inventory page

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $decks = Deck::with(['checks' => function ($query) {
            $query->whereHas('hazmats', function ($query) {
                $query->where('hazmat_type', 'PCHM')->orWhere('hazmat_type', 'Contained');
            });
        }])->where('ship_id', $ship_id)->get();
        foreach ($decks as $key => $value) {
            if (count($value['checks']) > 0) {
                $html = $this->drawDigarm($value);
                $fileNameDiagram = $this->genrateDompdf($html['html'], $html['ori']);
                //    $mpdf = new Mpdf(['orientation' => 'L']); // Ensure landscape mode
                $mpdf->setSourceFile($fileNameDiagram);

                $pageCount = $mpdf->setSourceFile($fileNameDiagram);
                for ($i = 1; $i <= $pageCount; $i++) {

                    $mpdf->AddPage($html['ori']);
                    if ($key == 0) {
                        $mpdf->WriteHTML('<h3 style="font-size:14px">2.1 Location Diagram of Contained HazMat & PCHM.</h3>');
                    }
                    $mpdf->WriteHTML('<h5 style="font-size:14px;">Area: ' . $value['name'] . '</h5>');

                    $templateId = $mpdf->importPage($i);
                    $mpdf->useTemplate($templateId, null, null, $mpdf->w, null); // Use the template with appropriate dimensions

                }
                unlink($fileNameDiagram);
            }
        }
        //Addended IHM Part
        $checkHazmatIHMAddendum = PoOrderItemsHazmats::with(relations: 'hazmat')->where('ship_id', $ship_id)->whereNotNull('ihm_table_type')->get();
        $filteredResultsAddendum1 = $checkHazmatIHMAddendum->filter(function ($item) {
            return $item->ihm_table_type == 'i-1';
        });

        $filteredResultsAddendum2 = $checkHazmatIHMAddendum->filter(function ($item) {
            return $item->ihm_table_type == 'i-2';
        });

        $filteredResultsAddendum3 = $checkHazmatIHMAddendum->filter(function ($item) {
            return $item->ihm_table_type == 'i-3';
        });
        $path = 'uploads/shipsVscp/' . $ship_id. '/summary' . "/";
        $summary = Summary::where('ship_id',$ship_id)->get();
        if (@$summary) {
            foreach ($summary as $value) {
                $filePath = public_path('uploads/shipsVscp') . "/" . $ship_id."/summary/".$value['document'];
                $mpdf->WriteHTML($filePath, \Mpdf\HTMLParserMode::HTML_BODY);

                if (file_exists($filePath) && @$value['document']) {
                    $titleHtml = '<h2 style="text-align:center;font-size:13px;font-weight:bold">Summary Attachment ' . $value['document'] . '</h2>';
                    $this->mergePdf($filePath, $titleHtml, $mpdf);
                }
            }
        }

        $html = view('main-report.IHMPartAddendum', compact('filteredResultsAddendum1', 'filteredResultsAddendum2', 'filteredResultsAddendum3'))->render();
        $mpdf->AddPage('L'); // Set landscape mode for the inventory page
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        //shipstaff recored
        $exam = Exam::where('ship_id', $ship_id)->orderBy('id', 'desc')->get();
        $html = view('main-report.trainingRecored', compact('exam'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $crewBrifing = Brifing::where('ship_id', $ship_id)->orderBy('id', 'desc')->get();
        $html = view('main-report.crew-briefing', compact('crewBrifing'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);


        $mdnoresults = DB::table('po_order_items_hazmats as p')
            ->join('make_models as m', 'm.id', '=', 'p.model_make_part_id')
            ->join('hazmats as h', 'h.id', '=', 'p.hazmat_id')
            ->select([
                'm.id',
                'm.md_date',
                'm.md_no',
                'm.coumpany_name',
                DB::raw('GROUP_CONCAT(DISTINCT h.short_name ORDER BY h.short_name ASC) AS hazmat_names')
            ])
            ->where('ship_id', $ship_id)
            ->whereNotNull('p.doc1')
            ->groupBy('m.id', 'm.md_date', 'm.md_no', 'm.coumpany_name')
            ->get();
        $html = view('main-report.md-recoreds', compact('mdnoresults'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $sdocresults = DB::table('po_order_items_hazmats as p')
            ->join('make_models as m', 'm.id', '=', 'p.model_make_part_id')
            ->join('hazmats as h', 'h.id', '=', 'p.hazmat_id')
            ->select([
                'm.id',
                'm.sdoc_date',
                'm.sdoc_no',
                'm.issuer_name',
                'm.sdoc_objects',
                DB::raw('GROUP_CONCAT(DISTINCT h.short_name ORDER BY h.short_name ASC) AS hazmat_names')
            ])
            ->where('p.ship_id', $ship_id)
            ->whereNotNull('p.doc2')
            ->groupBy('m.id', 'm.sdoc_date', 'm.sdoc_no', 'm.issuer_name', 'm.sdoc_objects')
            ->get();
        $html = view('main-report.sdoc-recoreds', compact('sdocresults'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $previousAttachment = PreviousAttachment::where('ship_id', $ship_id)->get();
        if (@$previousAttachment) {
            foreach ($previousAttachment as $value) {
                $filePath = public_path('uploads/previousattachment') . "/" . $value['attachment'];
                if (file_exists($filePath) && @$value['attachment']) {
                    $titleHtml = '<h2 style="text-align:center;font-size:13px;font-weight:bold">Previous Attachment ' . $value['attachment_name'] . '</h2>';
                    $this->mergePdf($filePath, $titleHtml, $mpdf);
                }
            }
        }



        // return response()->streamDownload(function () use ($mpdf) {
        //     echo $mpdf->Output('', 'S'); // S = return as string
        // }, 'report.pdf', ['Content-Type' => 'application/pdf']);
        // return response()->make($mpdf->Output('', 'I'), 200, [
        //     'Content-Type' => 'application/pdf',
        // ]);
        $safeProjectNo = str_replace('/', '_', $projectDetail['project_no']);

        $fileName = $safeProjectNo . '.pdf';
        $filePath = public_path('pdf/' . $fileName); // Adjust the directory and file name as needed
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
        $response = response()->download($filePath, $fileName)->deleteFileAfterSend(true);
        $response->headers->set('X-File-Name', $fileName);
        return $response;
    }
    public function reportCenter(Request $request)
    {
        $user = Auth::user();

        $ship_id = $user->shipClient->id;
        $ship = Ship::find($ship_id);
        $partMenual = partManuel::where('ship_id', operator: $ship_id)->get();
        $checkHazmatIHMPart = PoOrderItemsHazmats::with(relations: 'hazmat')->where('ship_id', $ship_id)->whereNotNull('ihm_table_type')->get();
        $previousAttachment = PreviousAttachment::where('ship_id', $ship_id)->get();
        return view('helpCenter.report', compact('ship_id', 'partMenual', 'ship', 'checkHazmatIHMPart', 'previousAttachment'));
    }


    public function generateIHMSticker($ship_id)
    {
        $ship = Ship::select('ship_name')->where('id',$ship_id)->find($ship_id);
        $checks = CheckHazmat::with(['check', 'hazmat'])
            ->where('ship_id', $ship_id)
            ->whereNotNull('hazmat_type')
            ->get();
    
        if ($checks->count() <= 0) {
            return redirect()->back()->with('message', 'This deck check not found.');
        }
    
        // Initialize Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);
    
        // HTML content for PDF
        $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>QR Codes</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        padding: 10px;
                        text-align: left;
                        border: 1px solid #ddd;
                        font-size:14px;
                    }
                    .left { text-align: left; font-weight: bold; }
                    .right { text-align: right; font-weight: normal; }
                </style>
            </head>
            <body>';
    
            $html .= '<div><center><h3>Ship : ' . htmlspecialchars($ship['ship_name']) . '</h3></center></div>';
            $html .= '<table>';
    
        // Track columns per row
        $colspan = 2;
        $counter = 0;
        
        foreach ($checks as $key => $check) {
            if ($counter % $colspan == 0) {
                $html .= '<tr>'; // Open new row
            }
    
            $html .= '<td width="50%">'; // Each column is 50% width
    
            $html .= '<div><span class="left">Check Name:</span> <span class="right">' . $check['check']['name'] . '</span></div>';
            $html .= '<div style="margin-top: 5px;"><span class="left">Location:</span> <span class="right">' . $check['location'] . '</span></div>';
            
            // Hazmat Type (Left) & Hazmat (Right)
            $html .= '<div style="margin-top: 5px;"><span class="left">Hazmat Type:</span> <span class="right">' . $check['hazmat_type'] . '</span></div>';
            $html .= '<div style="margin-top: 5px;"><span class="left">Hazmat:</span> <span class="right">' . $check['hazmat']['name'] . '</span></div>';
    
            $html .= '</td>'; // Close column
    
            if (($counter + 1) % $colspan == 0 || $key == $checks->count() - 1) {
                $html .= '</tr>'; // Close row
            }
    
            $counter++;
        }
    
        $html .= '</table>';
        $html .= '</body></html>';
    
        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);
    
        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
    
        // Render PDF
        $dompdf->render();
    
        // Output PDF as attachment
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="qr_codes_' . $ship["ship_name"] . '.pdf"');

    }

    protected function mergeImageToPdf($imagePath, $title, $mpdf, $page = null)
    {
        $mpdf->AddPage($page);
        $mpdf->WriteHTML('<h1>' . $title . '</h1>');
        $mpdf->Image($imagePath, 0, 20,  $mpdf->w, null, 'png', '', true, false);
    }
    protected function mergePdf($filePath, $title, $mpdf, $page = null)
    {
        $mpdf->setSourceFile($filePath);
        $pageCount = $mpdf->setSourceFile($filePath);
        for ($i = 1; $i <= $pageCount; $i++) {

            $mpdf->AddPage($page);
            $templateId = $mpdf->importPage($i);
            $size = $mpdf->getTemplateSize($templateId);
            $scale = min(
                ($mpdf->w - $mpdf->lMargin - $mpdf->rMargin) / $size['width'],
                ($mpdf->h - $mpdf->tMargin - $mpdf->bMargin) / $size['height']
            );
            if ($i === 1 && !empty($title)) {
                $mpdf->WriteHTML($title, \Mpdf\HTMLParserMode::HTML_BODY);

                $lmargin = 10;
                $tMargin = 20;
            } else {
                $lmargin = $mpdf->lMargin;
                $tMargin = $mpdf->tMargin;
            }
            $mpdf->useTemplate($templateId, $lmargin, $tMargin, $size['width'] * $scale, $size['height'] * $scale);
        }
    }
}
