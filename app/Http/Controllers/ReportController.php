<?php

namespace App\Http\Controllers;

use App\Models\Brifing;
use App\Models\CheckHazmat;
use App\Models\Deck;
use App\Models\DesignatedPersionShip;
use App\Models\DesignatedPerson;
use App\Models\Exam;
use App\Models\Hazmat;
use App\Models\Ship;
use App\Traits\PdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

ini_set("pcre.backtrack_limit", "1000000");
ini_set('exif.decode_jpeg', '0');

class ReportController extends Controller
{
    //
    use PdfGenerator;
    public function genrateReport(Request $request){
        $version = 1;
        $post = $request->input();
        $ship_id = $post['ship_id'];
        $logoPath = public_path('assets/images/logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logo = 'data:image/png;base64,' . $logoData;

        $date = date('y-m-d');
        $projectDetail = Ship::find($ship_id);
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
                <td width="10%"><img src='.$logo.' width="50" /></td>
                <td width="75%" align="center">' . $projectDetail['ship_name'] . '</td>
                <td width="15%" style="text-align: right;">Current Version :' . $version.'</td>
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
        $shipImagePath = asset('uploads/ship/'.$projectDetail['ship_image']);
      
        $shipImageData = base64_encode(file_get_contents($shipImagePath));
        $shipImage = 'data:image/png;base64,' . $shipImageData;

        $html = view('main-report.cover', compact('projectDetail','shipImage','shipImagePath'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $hazmats = Hazmat::get();
        $html = view('main-report.abbreviation',compact('hazmats'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        //ship particular
        $html = view('main-report.shipParticular',compact('projectDetail'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        //DesignatedPerson
        $designatedPerson = DesignatedPerson::where('ship_id',$ship_id)->get()->toArray();
        $designatedPersonShip = DesignatedPersionShip::with('designatedPersonDetail')->where('ship_id',$ship_id)->get()->toArray();
        $designatedPersonShipDetails = array_map(function ($item) {
            return $item['designated_person_detail'] ?? null;
        }, $designatedPersonShip);
        $mergedData = collect(array_merge($designatedPersonShipDetails,$designatedPerson))
        ->filter() // Remove null values
        ->unique('id') // Ensure unique records based on `id`
        ->values()
        ->toArray();
        $html = view('main-report.designatedPerson',compact('mergedData'))->render();
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

        $html = view('main-report.IHMPart',compact('filteredResults1','filteredResults2','filteredResults3'))->render();
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

        //shipstaff recored
        $exam = Exam::where('ship_id',$ship_id)->orderBy('id','desc')->get();
        $html = view('main-report.trainingRecored',compact('exam'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        $crewBrifing = Brifing::where('ship_id',$ship_id)->orderBy('id','desc')->get();
        $html = view('main-report.creBriefing',compact('crewBrifing'))->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // $sdresults = DB::select('SELECT p.po_order_item_id, p.doc2 AS sd_no, m.sdoc_date, m.issuer_name,m.sdoc_objects,m.sdoc_no, m.coumpany_name,po_order_items.description,GROUP_CONCAT(DISTINCT h.short_name) AS hazmat_names FROM po_order_items_hazmats p JOIN hazmats h ON p.hazmat_id = h.id JOIN make_models m ON p.model_make_part_id = m.id JOIN po_order_items po_order_items ON p.po_order_item_id = po_order_items.id where p.ship_id = '.$ship_id.' GROUP BY p.po_order_item_id, p.doc2, m.sdoc_date, m.coumpany_name, m.issuer_name, ,m.sdoc_objects,po_order_items.description,m.sdoc_no');
        // $html = view('main-report.sdResults',compact('sdresults'))->render();
        // $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
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


}
