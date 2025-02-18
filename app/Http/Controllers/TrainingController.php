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
            session()->flash('success','Plese start training');
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
        $designatedPerson = DesignatedPerson::select('id', 'name')->where('ship_staff_id', $user->id)->get()->toArray();
        $designated_people_id = Session::get('designated_people_id');
        if (!@$designated_people_id) {
            session()->flash('success','Plese start training');
            return redirect(url('training'));
        } 

        $designatedPersonDetail = DesignatedPerson::select('name')->where('id', $designated_people_id)->first();
        Session::put('designated_name',@$designatedPersonDetail['name']);

        $hazmat_companies_id =  $user->hazmat_companies_id;
        $training_material =   $user->hazmatCompany->training_material;

        $ship_id = $user->shipClient->id;
        $trainingRecoredHistory = Exam::where('ship_staff_id', $user->id)->orderBy('id','desc')->get();
        $material = asset('uploads/training_material/' . $training_material);
       $shipReport = $this->genrateSummeryReport($ship_id);



        return view('training.material', compact('designatedPerson', 'material', 'designatedPersonDetail','shipReport'));
    }
    public function Traininglist(Request $request)
    {
        Session::forget('designated_people_id');
        $user = Auth::user();
        $trainingRecoredHistory = Exam::where('ship_staff_id', $user->id)->orderBy('id','desc')->get();
        $brifingHistory = Brifing::with('DesignatedPersonDetail:id,name')
        ->where('ship_staff_id', $user->id)
        ->orderBy('id', 'desc') // Correct placement of orderBy
        ->get();
        $designatedPerson = DesignatedPerson::select('id', 'name')->where('ship_staff_id', $user->id)->whereNull('sign_off_date')->get()->toArray();
        return view('training.history', compact('trainingRecoredHistory', 'designatedPerson', 'brifingHistory'));
    }
    public function saveBrifing(BriefingRequest $request)
    {
        $post = $request->input();
        $hazmat_companies_id = Auth::user()->hazmat_companies_id;

        $user = Auth::user();
        $post['ship_id'] = $user->shipClient->id;

        $post['ship_staff_id'] = $user->id;
        $post['hazmat_companies_id'] = $hazmat_companies_id;
        Brifing::updateOrcreate(['id' => $post['id']], $post);

        $brifingHistory = Brifing::with('DesignatedPersonDetail:id,name')->where('ship_staff_id', $user->id)
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

        return response()->json(['isStatus' => true, 'message' => 'save successfully']);
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
                $mpdf->AddPage();
                $mpdf->UseTemplate($mpdf->ImportPage($i));
            }
        }
        $mpdf->SetSourceFile($filePath); // Add generated file
        $pageCount = $mpdf->SetSourceFile($filePath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $mpdf->AddPage();
            $mpdf->UseTemplate($mpdf->ImportPage($i));
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

            // Define header content with logo
            $header = '
            <table width="100%" style="border-bottom: 1px solid #000000; vertical-align: middle; font-family: serif; font-size: 9pt; color: #000088;">
                <tr>
                    <td width="10%"><img src="' . $logo . '" width="50" /></td>
                    <td width="80%" align="center">' . $shipDetail['ship_name'] . '</td>
                    <td width="10%" style="text-align: right;">' . $shipDetail['project_no'] . '<br/>' . $date . '</td>
                </tr>
            </table>';

            // Define footer content with page number
            $footer = '
            <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;">
                <tr>
                    <td width="33%" style="text-align: left;">' . $shipDetail['ihm_table'] . 'Summary</td>
                    <td width="33%" style="text-align: center;">Revision:' . $version . '</td>
                    <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
                </tr>
            </table>';  
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);

            $stylesheet = file_get_contents('public/assets/mpdf.css');
            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $shipImagePath = asset('uploads/ship/'.$shipDetail['ship_image']);
            $shipImageData = base64_encode(file_get_contents($shipImagePath));
            $shipImage = 'data:image/png;base64,' . $shipImageData;
            $html = view('report.cover', compact('shipDetail','shipImage'))->render();
            $mpdf->WriteHTML(view('report.shipParticular', compact('shipDetail','shipImage')));
            $mpdf->AddPage('L'); // Set landscape mode for the inventory page
            $mpdf->WriteHTML(view('report.Inventory', compact('filteredResults1', 'filteredResults2', 'filteredResults3')));
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
    public function saveResult(Request $request)
    {
        $post = $request->input();
        $user = Auth::user();
        $fileName = "summary_" . $user->shipClient->id . '.pdf';

        $filePath = public_path('training/' . $fileName); // Adjust the directory and file name as needed
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $inputData['ship_id'] = $user->shipClient->id;
        $inputData['ship_staff_id'] = $user->id;
        $inputData['correct_ans'] = $post['correct_ans'];
        $inputData['wrong_ans'] = $post['wrong_ans'];
        $inputData['total_ans'] = $post['total_ans'];
        $inputData['designated_person_id']= Session::get('designated_people_id');
        $inputData['designated_name']=Session::get('designated_name');
        Exam::create($inputData);
        return response()->json(['isStatus' => true, 'message' => 'submit successfully!!']);
    }
}
