<?php

namespace App\Http\Controllers;

use App\Exports\POHistoryExport;
use App\Models\CheckHazmat;
use App\Models\Deck;
use App\Models\DesignatedPersionShip;
use App\Models\Exam;
use App\Models\Hazmat;
use App\Models\partManuel;
use App\Models\poOrderItem;
use App\Models\PoOrderItemsHazmats;
use App\Models\PreviousAttachment;
use App\Models\Ship;
use App\Traits\PdfGenerator;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

ini_set("pcre.backtrack_limit", "1000000");
ini_set('exif.decode_jpeg', '0');

class ReportController extends Controller
{
    //
    use PdfGenerator;
    public function poOrderHistory($ship_id)
    {
        return Excel::download(new POHistoryExport, 'po_history.xlsx');
    }
    public function mdSDRecord($ship_id)
    {
        // e.g., 2025-06-20
        $mpdf = new Mpdf([
            'format'                 => 'A4',
            'margin_left'            => 10,
            'margin_right'           => 10,
            'margin_top'             => 15,
            'margin_bottom'          => 20,
            'margin_header'          => 0,
            'margin_footer'          => 10,
            'defaultPagebreakType'   => 'avoid',
            'imageProcessor'         => 'GD',
            'jpeg_quality'           => 75,
            'shrink_tables_to_fit'   => 1,
            'tempDir'                => __DIR__ . '/tmp',
            'default_font'           => 'dejavusans',
            'allow_output_buffering' => true,
        ]);
        $mpdf->SetCompression(true);
        $mpdf->use_kwt             = true;
        $mpdf->defaultPageNumStyle = '1';
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->h2toc       = ['H2' => 0, 'H3' => 1];
        $mpdf->h2bookmarks = ['H2' => 0, 'H3' => 1];
        $stylesheet        = file_get_contents('public/assets/mpdf.css');
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->TOCpagebreakByArray([
            'links'             => true,
            'toc-preHTML'       => '',
            'toc-bookmarkText'  => 'Table of Contents',
            'level'             => 0,
            'page-break-inside' => 'avoid',
            'suppress'          => false, // This should prevent a new page from being created before and after TOC
            'toc-resetpagenum'  => 1,
        ]);
        $sectionText = '1. MD Records Of Table Content';
        $html        = view('main-report.ihmpartMaintance1', compact('sectionText'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mdnoresults = PoOrderItemsHazmats::with(['makeModel.hazmat'])
            ->where('ship_id', $ship_id)
            ->whereNotNull('doc1')
            ->get();
        if (@$mdnoresults) {
            $html = view('mdReport.md-recoreds-report', compact('mdnoresults'))->render();
            $mpdf->AddPage('P');
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        }
        $sectionText = '2.SD Records Of Table Content';
        $mpdf->AddPage('P');
        $html = view('main-report.ihmpartMaintance1', compact('sectionText'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $sdocresults = PoOrderItemsHazmats::with(['makeModel.hazmat'])
            ->where('ship_id', $ship_id)
            ->whereNotNull('doc2')
            ->get();
        if (@$sdocresults) {
            $html = view('mdReport.sd-recoreds-report', compact('sdocresults'))->render();
            $mpdf->AddPage('P');
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        }
        if (@$mdnoresults) {
            $sectionText = '3. MD Attachments';
            $mpdf->AddPage('P');
            $html = view('main-report.ihmpartMaintance1', compact('sectionText'))->render();
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

            foreach ($mdnoresults as $mdvalue) {
                if (@$mdvalue['makeModel']['document1']['name']) {

                    $filePathsum = public_path('images/modelDocument/') . $mdvalue['makeModel']['document1']['name'];
                    if ($mdvalue['makeModel']['document1']) {
                        $titleHtml = '<h4 style="text-align:center;font-size:13px;font-weight:bold">' . $mdvalue['makeModel']['md_no'] . '</h4>';
                        $this->mergePdf($filePathsum, $titleHtml, $mpdf);
                    }
                }
            }
        }

        if (@$sdocresults) {
            $sectionText = '4. SD Attachments';
            $mpdf->AddPage('P');
            $html = view('main-report.ihmpartMaintance1', compact('sectionText'))->render();
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
            foreach ($sdocresults as $sdValue) {
                if (@$sdValue['makeModel']['document2']['name']) {
                    $filePathsum1 = public_path('images/modelDocument/') . $sdValue['makeModel']['document2']['name'];
                    if (file_exists($filePathsum1)) {
                        $titleHtml = '<h4 style="text-align:center;font-size:13px;font-weight:bold">SDoC No.' . $sdValue['makeModel']['sdoc_no'] . '</h4    >';
                        $this->mergePdfAttachment($filePathsum1, $titleHtml, $mpdf);
                    }
                }
            }
        }
        $mpdf->Output('IHM-Report.pdf', 'I');
    }
    public function genrateReport(Request $request)
    {
        $version = 1;
        $post    = $request->input();
        $ship_id = $post['ship_id'];
        $logo    = public_path('assets/images/logo.png');

        $date           = date('y-m-d');
        $from_date      = $post['from_date'];
        $to_date        = $post['to_date'];
        $projectDetail  = Ship::with('client.hazmatCompaniesId')->find($ship_id);
        $shipDetail     = $projectDetail;
        $is_report_logo = $projectDetail['client']['is_report_logo'];
        if ($is_report_logo == 0) {
            $image = $projectDetail['client']['hazmatCompaniesId']['logo'];
            $logo  = public_path('uploads/hazmatCompany/' . $image);
        } else {
            $image = $projectDetail['client']['client_image'];
            $logo  = public_path('uploads/clientcompany/' . $image);
        }

        $mpdf = new Mpdf([
            'format'                 => 'A4',
            'margin_left'            => 10,
            'margin_right'           => 10,
            'margin_top'             => 15,
            'margin_bottom'          => 20,
            'margin_header'          => 0,
            'margin_footer'          => 10,
            'defaultPagebreakType'   => 'avoid',
            'imageProcessor'         => 'GD',             // or 'imagick' if you have Imagick installed
            'jpeg_quality'           => 75,               // Set the JPEG quality (0-100)
            'shrink_tables_to_fit'   => 1,                // Shrink tables to fit the page width
            'tempDir'                => __DIR__ . '/tmp', // Set a temporary directory for mPDF
            'default_font'           => 'dejavusans',
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
                <td width="15%" style="text-align: right;">&nbsp;</td>
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
        $mpdf->h2toc       = ['H2' => 0, 'H3' => 1];
        $mpdf->h2bookmarks = ['H2' => 0, 'H3' => 1];
        // Set header and footer

        // Add Table of Contents
        $stylesheet = file_get_contents('public/assets/mpdf.css');

        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $shipImagePath = public_path('uploads/ship/orignal/' . $projectDetail['orignal_image']);

        $html = view('main-report.cover', compact('projectDetail', 'shipImagePath'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $mpdf->TOCpagebreakByArray([
            'links'             => true,
            'toc-preHTML'       => '<div class="toc_heading">Table of Contents</div>',
            'toc-bookmarkText'  => 'Table of Contents',
            'level'             => 0,
            'page-break-inside' => 'avoid',
            'suppress'          => false,
            'toc-resetpagenum'  => 1,
        ]);

        // //ship particular
        $html = view('main-report.shipParticular', compact('shipDetail'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $hazmats = Hazmat::get();
        $html    = view('main-report.abbreviation', compact('hazmats'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $sectionText = '3 Initial IHM Part1 Summary Report';
        $html        = view('main-report.ihmpart1', compact('sectionText', 'projectDetail'))->render();
        $mpdf->AddPage('P');
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $checkHazmatIHMPart = CheckHazmat::with(relations: 'hazmat')
            ->where('ship_id', $ship_id)
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })
            ->get();
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

        $decks = Deck::with(['checks' => function ($query) use ($from_date, $to_date) {
            $query->whereHas('hazmats', function ($query) {
                $query->where('hazmat_type', 'PCHM')
                    ->orWhere('hazmat_type', 'Contained');
            });

            if ($from_date && $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            }
        }])
            ->where('ship_id', $ship_id)
            ->get();
        foreach ($decks as $key => $value) {
            if (count($value['checks']) > 0) {
                $html            = $this->drawDigarm($value);
                $fileNameDiagram = $this->genrateDompdf($html['html'], $html['ori']);
                $mpdf->setSourceFile($fileNameDiagram);

                $pageCount = $mpdf->setSourceFile($fileNameDiagram);
                for ($i = 1; $i <= $pageCount; $i++) {

                    $mpdf->AddPage($html['ori']);
                    if ($key == 0) {
                        $mpdf->WriteHTML('<h5 style="font-size:14px">3.1 Location Diagram of Contained HazMat & PCHM.</h5>');
                    }
                    $mpdf->WriteHTML('<h5 style="font-size:14px;">Area: ' . $value['name'] . '</h5>');

                    $templateId = $mpdf->importPage($i);
                    $mpdf->useTemplate($templateId, null, null, $mpdf->w, null); // Use the template with appropriate dimensions

                }
                unlink($fileNameDiagram);
            }
        }
        $summary = partManuel::where('ship_id', $ship_id)
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })->get();
        $ga_plan_pdf = $ship_id . "/" . $projectDetail['ga_plan_pdf'];
        $gaplan      = public_path('uploads/shipsVscp/' . $ga_plan_pdf);
        $index       = 1;
        if (file_exists($gaplan)) {
            $titleHtml = '<h4 style="text-align:center;font-size:12pt;">' . $index . '. GA PLAN</h4>';
            $this->mergePdfAsImages($gaplan, $titleHtml, $mpdf);
            $index++;
        }
        if (@$summary) {
            foreach ($summary as $sumvalue) {
                $filePathsum = public_path('uploads/shipsVscp') . "/" . $ship_id . "/partmanual/" . basename($sumvalue['document']);
                if (file_exists($filePathsum) && @$sumvalue['document']) {
                    $titleHtml = '<h4 style="text-align:center;font-size:12pt">' . $index . '. ' . $sumvalue['title'] . '</h4>';
                    $this->mergePdfAttachment($filePathsum, $titleHtml, $mpdf);
                    $index++;
                }
            }
        }
        $sectionText = '4 IHM Maintance Report';
        $mpdf->AddPage('P');
        $html = view('main-report.ihmpartMaintance1', compact('sectionText'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // //Addended IHM Part
        $checkHazmatIHMAddendum = PoOrderItemsHazmats::with('hazmat')
            ->where('ship_id', $ship_id)
            ->whereNotNull('ihm_table_type')
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })->get();
        $filteredResultsAddendum1 = $checkHazmatIHMAddendum->filter(function ($item) {
            return $item->ihm_table_type == 'i-1';
        });

        $filteredResultsAddendum2 = $checkHazmatIHMAddendum->filter(function ($item) {
            return $item->ihm_table_type == 'i-2';
        });

        $filteredResultsAddendum3 = $checkHazmatIHMAddendum->filter(function ($item) {
            return $item->ihm_table_type == 'i-3';
        });

        $html = view('main-report.IHMPartAddendum', compact('filteredResultsAddendum1', 'filteredResultsAddendum2', 'filteredResultsAddendum3'))->render();
        $mpdf->AddPage('L'); // Set landscape mode for the inventory page
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $designatedPersonShip = DesignatedPersionShip::with('designatedPersonDetail')
            ->where('ship_id', $ship_id)
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })
            ->get();
        $mergedData    = $designatedPersonShip->pluck('designatedPersonDetail');
        $superDpResult = $mergedData->filter(function ($item) {
            return $item->position == 'SuperDp';
        });

        $responsibleResult = $mergedData->filter(function ($item) {
            return $item->position != 'SuperDp';
        });
        $previousAttachment = PreviousAttachment::where('ship_id', $ship_id)
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })
            ->get();

        $html = view('main-report.designatedPerson', compact('responsibleResult', 'superDpResult', 'previousAttachment'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // //shipstaff recored

        $exam = Exam::where('ship_id', $ship_id)
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })
            ->orderBy('id', 'desc')
            ->get();
        $html = view('main-report.trainingRecored', compact('exam'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mdnoresults = PoOrderItemsHazmats::with(['makeModel:id,md_no,document1'])
            ->where('ship_id', $ship_id)
            ->whereNotNull('doc1')
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })
            ->get();
        $html = view('main-report.md-recoreds', compact('mdnoresults'))->render();

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $sdocresults = PoOrderItemsHazmats::with(['makeModel:id,sdoc_no,document2,sdoc_date'])
            ->where('ship_id', $ship_id)
            ->whereNotNull('doc2')
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })
            ->get();
        $html = view('main-report.sdoc-recoreds', compact('sdocresults'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $counts = poOrderItem::select('type_category', DB::raw('COUNT(*) as total'))
            ->when($from_date && $to_date, function ($query) use ($from_date, $to_date) {
                $query->whereBetween('created_at', [
                    Carbon::parse($from_date)->startOfDay(),
                    Carbon::parse($to_date)->endOfDay(),
                ]);
            })
            ->groupBy('type_category')
            ->pluck('total', 'type_category');
        $html = view('main-report.POHistory', compact('counts'))->render();
       $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $safeProjectNo = str_replace('/', '_', $projectDetail['report_number']);

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

        $ship_id            = $user->shipClient->id;
        $ship               = Ship::find($ship_id);
        $partMenual         = partManuel::where('ship_id', operator: $ship_id)->get();
        $checkHazmatIHMPart = PoOrderItemsHazmats::with(relations: 'hazmat')->where('ship_id', $ship_id)->whereNotNull('ihm_table_type')->get();
        $previousAttachment = PreviousAttachment::where('ship_id', $ship_id)->get();
        return view('helpCenter.report', compact('ship_id', 'partMenual', 'ship', 'checkHazmatIHMPart', 'previousAttachment'));
    }

    public function generateIHMSticker($ship_id)
    {
        $ship   = Ship::select('ship_name')->where('id', $ship_id)->find($ship_id);
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
        .box {
            border: 1px solid #333;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .left {
            font-weight: bold;
        }
        .row {
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
             line-height: 1.6
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>';

        $html .= '<div><center><h3>Ship : ' . htmlspecialchars($ship['ship_name']) . '</h3></center></div>';

        foreach ($checks as $index => $check) {
            $html .= '<div class="box">';
            $html .= '<div class="row"><span class="left">Check Point ID:</span> <span>' . $check['check']['name'] . '</span></div>';
            $html .= '<div class="row"><span class="left">Check Point Type:</span> <span>' . $check['check']['type'] . '</span></div>';
            $html .= '<div class="row"><span class="left">Location:</span> <span>' . $check['location'] . '</span></div>';
            $html .= '<div class="row"><span class="left">Hazmat Status:</span> <span>' . $check['hazmat_type'] . '</span></div>';
            $html .= '<div class="row"><span class="left">Hazmat:</span> <span>' . $check['hazmat']['name'] . '</span></div>';
            $html .= '<div class="row"><span class="left">Hazmat Type:</span> <span>' . $check['hazmat']['table_type'] . '</span></div>';
            $html .= '</div>'; // Close box

            // Page break after every 4 checks
            if (($index + 1) % 4 == 0 && ($index + 1) < count($checks)) {
                $html .= '<div class="page-break"></div>';
            }
        }

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
        $mpdf->Image($imagePath, 0, 20, $mpdf->w, null, 'png', '', true, false);
    }
    protected function mergePdf($filePath, $title, $mpdf, $page = null)
    {
        $mpdf->setSourceFile($filePath);
        $pageCount = $mpdf->setSourceFile($filePath);
        for ($i = 1; $i <= $pageCount; $i++) {

            $mpdf->AddPage($page);
            $templateId = $mpdf->importPage($i);
            $size       = $mpdf->getTemplateSize($templateId);
            $scale      = min(
                ($mpdf->w - $mpdf->lMargin - $mpdf->rMargin) / $size['width'],
                ($mpdf->h - $mpdf->tMargin - $mpdf->bMargin) / $size['height']
            );
            if ($i === 1 && ! empty($title)) {
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
