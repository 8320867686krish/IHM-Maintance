<?php

namespace App\Http\Controllers;

use App\Http\Requests\assignTraining;
use App\Http\Requests\BriefingRequest;
use App\Http\Requests\TrainingRequest;
use App\Http\Requests\TrainingSet;
use App\Models\AssignTarainingSets;
use App\Models\Brifing;
use App\Models\CheckHazmat;
use App\Models\Deck;
use App\Models\DesignatedPerson;
use App\Models\Exam;
use App\Models\hazmatCompany;
use App\Models\partManuel;
use App\Models\QuestionSets;
use App\Models\Ship;
use App\Models\Training;
use App\Models\TrainingSets;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\PdfGenerator;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mpdf\Mpdf;

ini_set("pcre.backtrack_limit", "1000000");
ini_set('exif.decode_jpeg', '0');
class TrainingController extends Controller
{
    //
    use PdfGenerator, ImageUpload;
    public function index(Request $requet)
    {
        try {
            $role_id = Auth::user()->roles->first()->level;
            $user =  Auth::user();
            $training = TrainingSets::get();
            $hazmatCompany = hazmatCompany::get();
            return view('training.list', ['training' => $training, 'hazmatCompany' => $hazmatCompany]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
    public function add(Request $request)
    {
        return view('training.add');
    }
    public function editTraining($id)
    {
        $training = TrainingSets::with(['questions', 'assignsethzmatCompany.hazmatCompaniesName'])->find($id);
        return view('training.add', compact('training'));
    }
    public function trainingSave(TrainingSet $request)
    {
        $post = $request->input();
        $training = TrainingSets::updateOrCreate(
            ['id' => $post['id']], // The condition to check (match by 'id')
            ['name' => $post['name']] // The fields to update or create
        );
        if (@$post['deleted_questions_id']) {
            $deletedIds = explode(',', $post['deleted_questions_id']);

            foreach ($deletedIds as $value) {
                QuestionSets::where('id', $value)->delete();
            }
        }
        if (@$post['questions']) {
            $imagePath = 'uploads/trainingRecored/';

            foreach ($post['questions'] as $key => $value) {
                if ($value['answer_type'] == 'file') {
                    if ($request->hasFile("questions.$key.option_a")) {
                        $value['option_a'] = $request->file("questions.$key.option_a");
                    }
                    if ($request->hasFile("questions.$key.option_b")) {
                        $value['option_b'] = $request->file("questions.$key.option_b");
                    }
                    if ($request->hasFile("questions.$key.option_c")) {
                        $value['option_c'] = $request->file("questions.$key.option_c");
                    }
                    if ($request->hasFile("questions.$key.option_d")) {
                        $value['option_d'] = $request->file("questions.$key.option_d");
                    }
                }
                $value['training_sets_id'] = $training->id;
                QuestionSets::updateOrCreate(['id' => $key], $value);
            }
        }
        return response()->json(['isStatus' => true, 'message' => 'Questions save successfully!!']);
    }

    public function assigntraining(TrainingRequest $request)
    {
        $post = $request->input();
        if (@$post['training_sets_id']) {
            $explode = explode(',', $post['training_sets_id']);
            foreach ($explode as $value) {
                $fetchData = AssignTarainingSets::where('training_sets_id', $value)->where('hazmat_companies_id', $post['hazmat_companies_id'])->first();
                $data_add['training_sets_id'] = $value;
                $data_add['hazmat_companies_id'] = $post['hazmat_companies_id'];
                if ($fetchData) {
                    AssignTarainingSets::where('id', $fetchData['id'])->update($data_add);
                } else {
                    AssignTarainingSets::create($data_add);
                }
            }
        }
        return response()->json(['isStatus' => true, 'message' => 'Assign successfully!!']);
    }
    public function savedesignated(Request $request)
    {
        $post = $request->input();
        Session::put('designated_people_id', $post['designated_people_id']);
        return redirect(url('training/start'));
    }
    public function startExam()
    {
        $designated_people_id = Session::get('designated_people_id');

        if (!@$designated_people_id) {
            session()->flash('success', 'Plese start training');
            return redirect(url('training'));
        }
        $user =  Auth::user();
        $hazmat_companies_id =  $user->hazmat_companies_id;
        $training_sets_id = AssignTarainingSets::where('hazmat_companies_id', $hazmat_companies_id)
            ->inRandomOrder()
            ->limit(2)
            ->pluck('training_sets_id')
            ->toArray();
        shuffle($training_sets_id);
        $questionSets = QuestionSets::whereIn('training_sets_id', $training_sets_id)->get();
        $quizData = $questionSets->map(function ($question) {
            return [
                'question' => $question->question_name,
                'answer_type' => $question->answer_type,
                'options' => [
                    $question->option_a,
                    $question->option_b,
                    $question->option_c,
                    $question->option_d,
                ],
                'correct' => match ($question->correct_answer) {
                    'A' => 0,
                    'B' => 1,
                    'C' => 2,
                    'D' => 3,
                    default => null, // Handle unexpected values
                },
            ];
        });
        return view('training.exam', ['quizData' => $quizData]);
    }
    public function startTraining(Request $request)
    {
        $user =  Auth::user();
        $ship_id = Session::get('ship_id');
        $designated_people_id = Session::get('designated_people_id');
        if (!@$designated_people_id) {
            session()->flash('success', 'Plese start training');
            return redirect(url('training'));
        }

        $designatedPersonDetail = DesignatedPerson::select('name')->where('id', $designated_people_id)->first();
        Session::put('designated_name', @$designatedPersonDetail['name']);

        $training_material =   $user->hazmatCompany->training_material;

        $trainingRecoredHistory = Exam::where('ship_id', $ship_id)->orderBy('id', 'desc')->get();
        $material = asset('uploads/training_material/' . $training_material);
        $shipReport = $this->genrateSummeryReport($ship_id);

        return view('training.material', compact('material', 'designatedPersonDetail', 'shipReport'));
    }
    public function Traininglist(Request $request)
    {
        Session::forget('designated_people_id');
        $ship_id = Session::get('ship_id');
        $user = Auth::user();
        $trainingRecoredHistory = Exam::where('ship_id', $ship_id)->orderBy('id', 'desc')->get();
        $brifingHistory = Brifing::with('DesignatedPersonDetail:id,name')
            ->where('ship_id', $ship_id)
            ->orderBy('id', 'desc') // Correct placement of orderBy
            ->get();
        $designatedPerson = DesignatedPerson::select('id', 'name')->where('ship_staff_id', $user->id)->whereNull('sign_off_date')->get()->toArray();
        return view('training.history', compact('trainingRecoredHistory', 'designatedPerson', 'brifingHistory'));
    }
    public function saveBrifing(BriefingRequest $request)
    {
        $post = $request->input();

        $post['ship_id'] = Session::get('ship_id');

        Brifing::updateOrcreate(['id' => $post['id']], $post);

        $brifingHistory = Brifing::with('DesignatedPersonDetail:id,name')->where('ship_id', $post['ship_id'])
            ->orderBy('id', 'desc')->get();


        $html = view('components.brifing-history', compact('brifingHistory'))->render();
        return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
    }
    public function brifingDoc(Request $request)
    {
        $post = $request->input();
        $Brifing = Brifing::find($post['brief_id']);
        if ($Brifing && $Brifing->brifing_document) {
            $oldImagePath = $this->deleteImage('uploads/brifing_document/', $Brifing->brifing_document);
        }

        if ($request->hasFile('brifing_document')) {
            $image = $this->upload($request, 'brifing_document', 'uploads/brifing_document');
            $Brifing->brifing_document = $image;
        }
        $Brifing->save();
        $brifingHistory = Brifing::with('DesignatedPersonDetail:id,name')->where('ship_id', Session::get('ship_id'))
        ->orderBy('id', 'desc')->get();
        $html = view('components.brifing-history', compact('brifingHistory'))->render();
        return response()->json(['isStatus' => true, 'message' => 'save successfully','html'=>$html]);
    }
    public function briefingDownload($id)
    {
        $brifingPlan = Auth::user()->hazmatCompany->briefing_plan;
        $briefingPdfPath = public_path('uploads/briefing_plan/' . $brifingPlan); // Make sure to adjust the path

        $briefing =  Brifing::with('DesignatedPersonDetail:id,name')->find($id);
        $template = view('training.briefingTemplate', compact('briefing'));
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Load HTML content
        $dompdf->loadHtml($template);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $briefingPdfContent = $dompdf->output();
        $filename = "project" . uniqid() . "ab.pdf";
        $filePath = storage_path('app/briefingPlan') . "/" . $filename;

        file_put_contents($filePath, $briefingPdfContent);
        $mpdf = new \Mpdf\Mpdf();

        // Add the existing briefing plan PDF (briefing_plan)
        if (file_exists($briefingPdfPath)) {

            $mpdf->SetSourceFile($briefingPdfPath);
            $pageCount = $mpdf->SetSourceFile($briefingPdfPath);

            // Import all pages from the briefing plan PDF
            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $mpdf->ImportPage($i);
                $size = $mpdf->GetTemplateSize($templateId);

                // Check orientation
                if ($size['width'] > $size['height']) {
                    $mpdf->AddPage('L'); // Landscape
                } else {
                    $mpdf->AddPage('P'); // Portrait
                }

                $mpdf->UseTemplate($templateId);
            }
        }
        $mpdf->SetSourceFile($filePath); // Add generated file
        $pageCount = $mpdf->SetSourceFile($filePath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $mpdf->ImportPage($i);
            $size = $mpdf->GetTemplateSize($templateId);
        
            if ($size['width'] > $size['height']) {
                $mpdf->AddPage('L'); // Landscape
            } else {
                $mpdf->AddPage('P'); // Portrait
            }
        
            $mpdf->UseTemplate($templateId);
        }
        unlink($filePath);

        $pdfOutput = $mpdf->Output('', 'S');

        return response($pdfOutput, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="merged_briefing_report_' . $briefing['brifing_date'] . '.pdf"',
        ]);
    }
    public function genrateSummeryReport($ship_id)
    {
        $shipDetail = Ship::with('client')->find($ship_id);
        if (!$shipDetail) {
            die('Project details not found');
        }
        $version  =  $shipDetail['current_ihm_version'];
        $date = $shipDetail['ihm_version_updated_date'];
        $html = '';
        $logoPath = public_path('assets/images/logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logo = 'data:image/png;base64,' . $logoData;

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


        $decks = Deck::with(['checks' => function ($query) {
            $query->whereHas('hazmats', function ($query) {
                $query->where('hazmat_type', 'PCHM')->orWhere('hazmat_type', 'Contained');
            });
        }])->where('ship_id', $ship_id)->get();

        try {
            // Create an instance of mPDF with specified margins
            $mpdf =  new Mpdf([
                'mode' => 'c',
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 20,
                'margin_header' => 0,
                'margin_footer' => 10,
                'defaultPagebreakType' => 'avoid',
                'imageProcessor' => 'GD', // or 'imagick' if you have Imagick installed
                'jpeg_quality' => 75, // Set the JPEG quality (0-100)
                'shrink_tables_to_fit' => 1, // Shrink tables to fit the page width
                'tempDir' => __DIR__ . '/tmp', // Set a temporary directory for mPDF


                'allow_output_buffering' => true,
            ]);
            $mpdf->defaultPageNumStyle = '1';
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetCompression(true);

            // Add each page of the Dompdf-generated PDF to the mPDF document

            $mpdf->use_kwt = true;
            $mpdf->defaultPageNumStyle = '1';
            $mpdf->SetDisplayMode('fullpage');
            $version = $shipDetail['current_ihm_version'];
            // Define header content with logo
             $header = '
            <table width="100%" style="border-bottom: 1px solid #000000; vertical-align: middle; font-family: serif; font-size: 9pt; color: #000088;">
                <tr>
                    <td width="15%" style="fot-weight:bold">' . $shipDetail['ship_name'] . '</td>
                   
                    <td width="70%" style="text-align: right;">Report Number: ' . $shipDetail['report_number'] . '<br/>Version: ' . $shipDetail['current_ihm_version'] . '</td>
                </tr>
            </table>';

            // Define footer content with page number
            $footer = '
            <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;">
                <tr>
                    <td width="33%" style="text-align: left;">&nbsp;</td>
                    <td width="33%" style="text-align: center;"></td>
                    <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
                </tr>
            </table>';
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);

            $stylesheet = file_get_contents('public/assets/mpdf.css');
            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $shipImagePath = asset('uploads/ship/orignal/' . $shipDetail['orignal_image']);

            $mpdf->WriteHTML(view('report.cover', compact('shipDetail', 'shipImagePath')));
            $mpdf->WriteHTML(view('report.shipParticular', compact('shipDetail')));
            $mpdf->AddPage('L'); // Set landscape mode for the inventory page
            $mpdf->WriteHTML(view('report.Inventory', compact('filteredResults1', 'filteredResults2', 'filteredResults3')));
             if (count($decks) > 0) {
                foreach ($decks as $key => $value) {
                    if (count($value['checks']) > 0) {
                         $html = $this->drawDigarm($value);
                        $fileNameDiagram = $this->genrateDompdf($html['html'], $html['ori']);
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
                        $deck_id = $value['id'];
                       
                        $filterDecks = $checkHazmatIHMPart->filter(function ($item) use ($deck_id) {
                            return $item->deck_id == (int) $deck_id;
                        });
                        foreach($filterDecks as $indexhazmat=>$hazmatcheck){
                             $mpdf->AddPage('P');
                            $mpdf->writeHTML(view('report.vscpPrepration', ['check' => $hazmatcheck, 'name' => $value['name'],'indexhazmat'=>$indexhazmat]));
                        }
                       
                        unlink($fileNameDiagram);
                    }
                }
            }
             $summary = partManuel::where('ship_id', $ship_id)->get();
            $ga_plan_pdf = $ship_id . "/" . $shipDetail['ga_plan_pdf'];
            $gaplan =  public_path('shipsVscp/' . $ga_plan_pdf);
            $index = 1;
            if (file_exists($gaplan)) {
                $titleHtml = '<h3 style="text-align:center;font-size:12pt;">'.$index.'. GA PLAN</h3>';
                $this->mergePdfAsImages($gaplan, $titleHtml, $mpdf);
                 $index++;
            }
            if (@$summary) {
                foreach ($summary as $sumvalue) {
                    $filePathsum = public_path('uploads/shipsVscp') . "/" . $ship_id . "/partmanual/" . basename($sumvalue['document']);
                    if (file_exists($filePathsum) && @$sumvalue['document']) {
                        $titleHtml = '<h3 style="text-align:center;font-size:12pt">'.$index.'. '. $sumvalue['title'] . '</h3>';
                        $this->mergePdfAttachment($filePathsum, $titleHtml, $mpdf);
                         $index++;
                    }
                }
            }

            $safeProjectNo = str_replace('/', '_', $shipDetail['project_no']);
            $fileName = "summary_" . $ship_id . '.pdf';

            $filePath = public_path('training/' . $fileName); // Adjust the directory and file name as needed
            $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
            $genrate_name = url('public/training/' . $fileName);
            return $genrate_name;
        } catch (\Mpdf\MpdfException $e) {
            // Handle mPDF exception
            echo $e->getMessage();
        }
    }
     protected function mergePdfAttachment($filePath, $title, $mpdf, $page = null)
    {
        Log::info("Starting merge for: {$filePath}");

        // Validate input file
        if (!file_exists($filePath)) {
            Log::error("PDF file not found: {$filePath}");
            throw new \Exception("PDF file not found: {$filePath}");
        }
        if (!is_readable($filePath)) {

            throw new \Exception("PDF file is not readable: {$filePath}");
        }
        $fileContent = @file_get_contents($filePath, false, null, 0, 4);
        if ($fileContent === false || $fileContent !== '%PDF') {
            throw new \Exception("File is not a valid PDF: {$filePath}");
        }

        $mergedPdfPath = storage_path('app/merged_output_' . uniqid() . '.pdf');

        // Process with Fpdi
        $fpdi = new \setasign\Fpdi\Fpdi(); // Explicitly create new instance
        try {
            $pageCount = $fpdi->setSourceFile($filePath);
            if ($pageCount === false || $pageCount === 0) {
                Log::error("Failed to load PDF: {$filePath}");
                throw new \Exception("Invalid PDF file: {$filePath}");
            }

            for ($i = 1; $i <= $pageCount; $i++) {

                $template = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($template);
                if (!is_array($size)) {
                    Log::error("Invalid template size for page {$i}");
                    continue;
                }
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($template);
            }
            $fpdi->Output('F', $mergedPdfPath);
            if (!file_exists($mergedPdfPath) || filesize($mergedPdfPath) === 0) {
                Log::error("Failed to create merged PDF or file is empty: {$mergedPdfPath}");
                throw new \Exception("Merged PDF not created or empty");
            }
            Log::info("Generated merged PDF: {$mergedPdfPath}, Size: " . filesize($mergedPdfPath));
        } catch (\Exception $e) {
            unset($fpdi); // Ensure FPDI object is destroyed
            $this->mergePdfAsImages($filePath, $title, $mpdf, $page);
            return;
        } finally {
            unset($fpdi); // Explicitly destroy FPDI object
        }

        // Process with mPDF
        try {
            if (!is_readable($mergedPdfPath)) {
                Log::error("Merged PDF is not readable: {$mergedPdfPath}");
                throw new \Exception("Merged PDF is not readable: {$mergedPdfPath}");
            }
            Log::info("Opening merged PDF for mPDF: {$mergedPdfPath}");
            $pageCount = $mpdf->setSourceFile($mergedPdfPath);
            Log::info("Merged PDF page count: {$pageCount}");

            for ($i = 1; $i <= $pageCount; $i++) {
                Log::info("Processing mpdf page {$i}");
                $templateId = $mpdf->importPage($i);
                if (!$templateId) {
                    Log::error("Failed to import page {$i} from merged PDF");
                    continue;
                }

                $size = $mpdf->getTemplateSize($templateId);
                if (!is_array($size)) {
                    Log::error("Invalid template size for page {$i} in merged PDF");
                    continue;
                }

                $mpdf->AddPage($page);
                if ($i === 1 && !empty($title)) {
                    $mpdf->WriteHTML($title);
                    $lmargin = 10;
                    $tMargin = 20;
                } else {
                    $lmargin = $mpdf->lMargin;
                    $tMargin = $mpdf->tMargin;
                }

                $scale = min(
                    ($mpdf->w - $mpdf->lMargin - $mpdf->rMargin) / $size['width'],
                    ($mpdf->h - $mpdf->tMargin - $mpdf->bMargin) / $size['height']
                );

                $mpdf->useTemplate($templateId, $lmargin, $tMargin, $size['width'] * $scale, $size['height'] * $scale);
            }
        } catch (\Exception $e) {

            $this->mergePdfAsImages($filePath, $title, $mpdf, $page);
        } finally {
            // Clean up temporary file
            if (file_exists($mergedPdfPath)) {
                if (@unlink($mergedPdfPath)) {
                } else {
                }
            }
        }
    }

    protected function mergePdfAsImages($filePath, $title, $mpdf, $page = null)
    {
        try {
            $pdf = new \Spatie\PdfToImage\Pdf($filePath);
            $pageCount = $pdf->getNumberOfPages();

            if ($pageCount > 0) {
                for ($i = 1; $i <= $pageCount; $i++) {
                    $imagePath = storage_path("app/temp_pdf_page_{$i}.jpg");

                    $pdf->setPage($i)
                        ->setOutputFormat('jpg')
                        ->saveImage($imagePath);

                    $mpdf->AddPage($page);

                    if ($i === 1 && !empty($title)) {
                        $mpdf->WriteHTML($title);
                    }

                    // Option 1: Image below title (not full page)
                    $mpdf->Image($imagePath, 0, ($i === 1 && !empty($title) ? 15 : 0), 210, 277, 'jpg', '', true, false);

                    // Clean up
                    @unlink($imagePath);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("PDF to Image conversion failed: " . $e->getMessage());
        }
    }
    public function saveResult(Request $request)
    {
        $post = $request->input();
        $user = Auth::user();
        $fileName = "summary_" . $user->shipClient->id . '.pdf';

        $filePath = public_path('training/' . $fileName); // Adjust the directory and file name as needed
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $inputData['ship_id'] = Session::get('ship_id');
        $inputData['correct_ans'] = $post['correct_ans'];
        $inputData['wrong_ans'] = $post['wrong_ans'];
        $inputData['total_ans'] = $post['total_ans'];
        $inputData['designated_person_id'] = Session::get('designated_people_id');
        $inputData['designated_name'] = Session::get('designated_name');
        Exam::create($inputData);
        return response()->json(['isStatus' => true, 'message' => 'submit successfully!!']);
    }
}
