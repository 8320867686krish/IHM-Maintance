<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\CheckHazmat;
use App\Models\Deck;
use App\Models\Hazmat;
use App\Models\partManuel;
use App\Models\partmanuelModel;
use App\Models\Ship;
use App\Models\Summary;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Traits\ImageUpload;

class VscpController extends Controller
{
    use ImageUpload;

    //
    public function index($ship_id)
    {
        $ship = Ship::with('decks')->find($ship_id);
        $checks = Check::with('hazmats.hazmat')->where('ship_id', $ship_id)->get();

        $hazmats = Hazmat::get(['id', 'name', 'table_type']);

        return view('ships.vscp.index', compact('ship', 'ship_id', 'checks', 'hazmats'));
    }
    public function uploadGaPlan(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'ship_id' => 'required|exists:ships,id',
            ]);

            $project = Ship::findOrFail($request->input('ship_id'));
            $projectName = Str::slug($project->ship_name);
            $projectId = $request->input('ship_id');
            $file = $request->file('image');

            if (!$file->isValid()) {
                throw new \Exception('Uploaded image is not valid.');
            }

            $mainFileName = "{$projectName}_" . rand(10, 99) . "_" . time() . ".png";
            $imagePath = public_path(env('IMAGE_COMMON_PATH', 'shipsVscp/') . $projectId . '/');
            $file->move($imagePath, $mainFileName);

            $updateProjectData = ['ga_plan_image' => $mainFileName];

            if ($request->hasFile('ga_plan') && $request->file('ga_plan')->isValid()) {
                $pdfName = time() . "_gaplan." . $request->ga_plan->extension();
                $request->ga_plan->move($imagePath, $pdfName);

                $oldGaPlanPath = $imagePath . $project->ga_plan;
                if (@$project->ga_plan && file_exists($oldGaPlanPath)) {
                    unlink($oldGaPlanPath);
                }

                $updateProjectData['ga_plan_pdf'] = $pdfName;
            }

            Ship::where('id', $projectId)->update($updateProjectData);

            $areas = $request->input('areas');
            $areasArray = json_decode($areas, true);

            foreach ($areasArray as $area) {
                $x = $area['x'];
                $y = $area['y'];
                $width = $area['width'];
                $height = $area['height'];
                $text = $area['text'] ?? ' ';

                $croppedImageName = Str::slug($text) . "_{$width}_{$height}_" . time() . ".png";

                $image = imagecreatefrompng($imagePath . $mainFileName);
                if (!$image) {
                    throw new \Exception("Failed to create image resource from {$mainFileName}");
                }

                $croppedImage = imagecrop($image, ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
                if ($croppedImage === FALSE) {
                    imagedestroy($image); // Clean up the image resource
                    throw new \Exception("Failed to crop the image at [x: $x, y: $y, width: $width, height: $height]");
                }

                if (imagepng($croppedImage, $imagePath . $croppedImageName) === FALSE) {
                    imagedestroy($croppedImage); // Clean up the cropped image resource
                    throw new \Exception("Failed to save the cropped image as {$croppedImageName}");
                }

                Deck::create([
                    'ship_id' => $projectId,
                    'name' => $text,
                    'image' => $croppedImageName,
                ]);

                // Clean up the image resources
                imagedestroy($croppedImage);
                imagedestroy($image);
            }

            $decks = Deck::where('ship_id', $projectId)->orderByDesc('id')->get();
            $html = view('components.deck-list', compact('decks'))->render();

            return response()->json(['status' => true, 'message' => 'Image saved successfully', 'html' => $html]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function updateDeckDetails(Request $request)
    {
        try {
            $updated = Deck::where('id', $request->input('id'))->update(['name' => $request->input('name')]);
            if ($updated) {
                $deck = Deck::select('id', 'name')->find($request->input('id'));

                if ($deck) {
                    return response()->json(["isStatus" => true, "message" => "Deck updated successfully", 'deck' => $deck]);
                } else {
                    return response()->json(["isStatus" => false, "message" => "Deck not found"]);
                }
            } else {
                return response()->json(["isStatus" => false, "message" => "Failed to update deck"]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function deleteDeck($id)
    {
        try {
            // Find the deck by ID
            $deck = Deck::find($id);
            $shipId = $deck->ship_id;
            if (!$deck) {
                return response()->json(["isStatus" => false, 'error' => 'Deck not found'], 404);
            }
            $imagePath = public_path(env('IMAGE_COMMON_PATH', "uploads/shipsVscp/") . $shipId . "/") . $deck->getOriginal('image');

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $deck->delete();
            $decks = Deck::where('ship_id', $shipId)->orderByDesc('id')->get();
            $html = view('components.deck-list', compact('decks'))->render();

            return response()->json(["isStatus" => true, "message" => "Deck deleted successfully", 'html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(["isStatus" => false, 'error' => $th->getMessage()], 500);
        }
    }
    public function check($deck_id)
    {
        $deck = Deck::with('checks')->find($deck_id);
        $hazmats = Hazmat::get(['id', 'name', 'table_type']);
        return view('ships.vscp.check.check', ['deck' => $deck, 'hazmats' => $hazmats]);
    }
    public function checkSave(Request $request)
    {
        $inputData = $request->input();
        $id = $request->input('id');
        $existingData = $id ? Check::find($id)->toArray() : [];

        // Filter out null or empty values
        $filteredInputData = array_filter($inputData, function ($value) {
            return $value !== null || $value !== 'NaN'; // You can modify this to include more conditions if needed
        });

        // Merge with existing data to preserve non-updated fields
        $finalData = array_merge($existingData, $filteredInputData);
        if ($inputData['id'] != 0) {
            $checkData = Check::find($inputData['id']);
        }
        $path = 'uploads/shipsVscp/' . $inputData['ship_id'] . '/check' . "/";

        if ($request->hasFile('close_image')) {
            if ($inputData['id'] != 0) {
                if ($checkData && $checkData->close_image) {
                    $oldImagePath = $this->deleteImage($path, basename($checkData->close_image));
                }
            }
            $image = $this->upload($request, 'closeUpImage', 'uploads/shipsVscp/' . $inputData['ship_id'] . '/check');
            $finalData['close_image'] = $image;
        }
        if ($request->hasFile('away_image')) {
            if ($inputData['id'] != 0) {
                if ($checkData && $checkData->away_image) {
                    $oldImagePath = $this->deleteImage($path, basename($checkData->away_image));
                }
            }
            $image = $this->upload($request, 'away_image', 'uploads/shipsVscp/' . $inputData['ship_id'] . '/check');

            $finalData['away_image'] = $image;
        }
        $data = Check::updateOrCreate(['id' => $id], $finalData);
        $updatedData = $data->getAttributes();
        $saveid = $updatedData['id'];
        $name = $updatedData['name'];

        $imagePath = public_path(env('IMAGE_COMMON_PATH', 'shipsVscp/') . $inputData['ship_id'] . '/check' . '/');

        if (@$inputData['check_hazmats']) {

            foreach ($inputData['check_hazmats'] as $key => $value) {
                $value['isStrike'] = $value['isStrike'] ?? 0;
                $value['check_id'] = $saveid;
                $value['ship_id'] = $inputData['ship_id'];
                $value['deck_id'] = $inputData['deck_id'];

                if ($request->hasFile("check_hazmats.$key.strike_document")) {
                    $checkHazmatData =  CheckHazmat::find($key);
                    if (@$checkHazmatData['strike_document']) {
                        $oldImagePath = $this->deleteImage($path, basename($checkHazmatData->strike_document));
                    }
                    $file = $request->file("check_hazmats.$key.strike_document"); // Access the file properly
                    $strike_document = time() . "_strike_document_" . $key . "." . $file->getClientOriginalExtension();
                    $file->move($imagePath, $strike_document);
                    $value['strike_document'] = $strike_document;
                }
                CheckHazmat::updateOrCreate(['id' => $key], $value);
            }
        }
        if (@$inputData['check_deleted_id']) {
            $deletedIds = explode(',', $inputData['check_deleted_id']); // This splits the string into an array
            CheckHazmat::whereIn('id', $deletedIds)->delete();
        }
        if (!empty($inputData['deck_id'])) {
            if ($inputData['allCheck'] == 1) {
                $checks = Check::with('hazmats.hazmat')->where('ship_id', $inputData['ship_id'])->get();
                $trtd = view('components.all-check-list', compact('checks'))->render();
            } else {
                $checks = Check::where('deck_id', $inputData['deck_id'])->get();
                $htmllist = view('components.check-list', compact('checks'))->render();
            }
        }

        $message = empty($id) ? "Check added successfully" : "Check updated successfully";

        return response()->json(['isStatus' => true, 'message' => $message, "id" => $data->id, 'name' => $name, 'htmllist' => $htmllist ?? " ", "trtd" => $trtd ?? " "]);
    }
    public function deleteCheck($id)
    {
        try {
            $check = Check::find($id);
            if (!$check) {
                return response()->json(["status" => false, 'message' => 'Check not found'], 404);
            }
            $deckId = $check->deck_id;
            $check->delete();
            $checks = Check::where('deck_id', $deckId)->get();
            $htmldot = view('ships.vscp.check.dot', compact('checks'))->render();
            $htmllist = view('components.check-list', compact('checks'))->render();

            return response()->json([
                "isStatus" => true,
                "message" => "Check deleted successfully",
                'htmldot' => $htmldot,
                'htmllist' => $htmllist
            ]);
        } catch (\Throwable $th) {
            return response()->json(["isStatus" => true, 'error' => $th->getMessage()], 500);
        }
    }

    public function checkHazmat($check_id)
    {
        $check = Check::with('hazmats')->find($check_id);
        $checkhazmat = $check->hazmats ?? [];
        $hazmats = Hazmat::get(['id', 'name', 'table_type']);
        $htmllist = view('components.check-add-model', compact('checkhazmat', 'hazmats'))->render();
        $response = [
            'html' => $htmllist,
            'check' => [
                'data' => $check, // Include the original Check object
                'original_close_image' => $check->getAttributes()['close_image'], // Raw value
                'original_away_image' => $check->getAttributes()['away_image'], // Raw value
            ],
        ];


        return response()->json($response);
    }
    public function partManual(Request $request)
    {
        $inputData =  $request->input();
        $path = 'uploads/shipsVscp/' . $inputData['ship_id']  . '/partmanual' . "/";
        if ($request->hasFile('document')) {
            if (@$inputData['id'] != 0) {
                $partmanul = partManuel::find($inputData['id']);
                if ($partmanul && $partmanul->document) {
                    $oldImagePath = $this->deleteImage($path, basename($partmanul->document));
                }
            }
            $image = $this->upload($request, 'document', 'uploads/shipsVscp/'.$inputData['ship_id'].'/partmanual');
            $inputData['document'] = $image;
        }
        $insert = partManuel::updateOrCreate(['id' => $inputData['id']], $inputData);

        $partMenual = partManuel::where('ship_id',$inputData['ship_id'])->where('hazmat_companies_id',$inputData['hazmat_companies_id'])->get();

        $htmllist = view('components.part-manual-list', compact('partMenual'))->render();

        return response()->json(["isStatus" => true, "message" => "Attachment  save successfully","html"=>$htmllist]);
    }
    public function partManualDelete($id){
        try {
            $partMenualData = partManuel::find($id);
            $shipId = $partMenualData->ship_id;
            $path = 'uploads/shipsVscp/' . $shipId  . '/partmanual' . "/";

            if (!$partMenualData) {
                return response()->json(["isStatus" => false, 'error' => 'Deck not found'], 404);
            }
            $oldImagePath = $this->deleteImage($path, basename($partMenualData->document));
            $partMenualData->delete();
            return response()->json(["isStatus" => true, "message" => "Deck deleted successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["isStatus" => false, 'error' => $th->getMessage()], 500);
        }
    }

    public function summary(Request $request){
        $inputData =  $request->input();
        $path = 'uploads/shipsVscp/' . $inputData['ship_id']  . '/summary' . "/";
        if ($request->hasFile('document')) {
            if (@$inputData['id'] != 0) {
                $partmanul = Summary::find($inputData['id']);
                if ($partmanul && $partmanul->document) {
                    $oldImagePath = $this->deleteImage($path, basename($partmanul->document));
                }
            }
            $image = $this->upload($request, 'document', 'uploads/shipsVscp/'.$inputData['ship_id'].'/summary');
            $inputData['document'] = $image;
        }
        $insert = Summary::updateOrCreate(['id' => $inputData['id']], $inputData);

        $summary = Summary::where('ship_id',$inputData['ship_id'])->where('hazmat_companies_id',$inputData['hazmat_companies_id'])->get();

        $htmllist = view('components.summary-list', compact('summary'))->render();

        return response()->json(["isStatus" => true, "message" => "Attachment  save successfully","html"=>$htmllist]);
    }
    public function summaryDelete($id){
        try {
            $summaryData = Summary::find($id);
            $shipId = $summaryData->ship_id;
            $path = 'uploads/shipsVscp/' . $shipId  . '/summary' . "/";

            if (!$summaryData) {
                return response()->json(["isStatus" => false, 'error' => 'summary not found'], 404);
            }
            $oldImagePath = $this->deleteImage($path, basename($summaryData->document));
            $summaryData->delete();
            return response()->json(["isStatus" => true, "message" => "Deck deleted successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["isStatus" => false, 'error' => $th->getMessage()], 500);
        }
    }
    public function unlockVscp(Request $request){
        $post = $request->input();
        Ship::where('id',$post['ship_id'])->update(['is_unlock'=>$post['is_unlock']]);

    }
    public function startamended(Request $request){
        $post = $request->input();
        $updateData = [];
        if(@$post['new_ihm_version']){
            $updateData['current_ihm_version'] = $post['new_ihm_version'];
        }
        if(@$post['new_version_date']){
            $updateData['ihm_version_updated_date'] = $post['new_version_date'];
        }
        Ship::where('id',$post['ship_id'])->update($updateData);
        $redirecctUrl = url('ship/vscp/'.$post['ship_id']);
        return response()->json(data: ["isStatus" => true, "message" => "Save successfully",'redirectUrl'=>$redirecctUrl]);
    }
    public function summeryReport($post)
    {
        $project_id = $post['project_id'];
        $version = $post['version'];
        $date = date('d-m-Y', strtotime($post['date']));

        $projectDetail = Ship::with('client')->find($project_id);
        if (!$projectDetail) {
            die('Project details not found');
        }
        $options = new Options();
        $dompdf = new Dompdf($options);
        $html = '';
        $logo = 'https://sosindi.com/IHM/public/assets/images/logo.png';
        $checkHazmatIHMPart = CheckHazmat::with(relations: 'hazmat')->where('ship_id',$ship_id)->get();

        $lebResult = LabResult::with(['check', 'hazmat'])->where('project_id', $project_id)->where('type', 'Contained')->orwhere('type', 'PCHM')->get();
        $filteredResults1 = $lebResult->filter(function ($item) {
            return $item->IHM_part == 'IHMPart1-1';
        });

        $filteredResults2 = $lebResult->filter(function ($item) {
            return $item->IHM_part == 'IHMPart1-2';
        });
        $filteredResults3 = $lebResult->filter(function ($item) {
            return $item->IHM_part == 'IHMPart1-3';
        });
        $decks = Deck::with(['checks' => function ($query) {
            $query->whereHas('labResults', function ($query) {
                $query->where('type', 'PCHM')->orWhere('type', 'Contained');
            });
        }])->where('project_id', $project_id)->get();

        try {
            // Create an instance of mPDF with specified margins
            $mpdf = new Mpdf([
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
                    <td width="80%" align="center">' . $projectDetail['ship_name'] . '</td>
                    <td width="10%" style="text-align: right;">' . $projectDetail['project_no'] . '<br/>' . $date . '</td>
                </tr>
            </table>';

            // Define footer content with page number
            $footer = '
            <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000;">
                <tr>
                    <td width="33%" style="text-align: left;">' . $projectDetail['ihm_table'] . 'Summary</td>
                    <td width="33%" style="text-align: center;">Revision:' . $version . '</td>
                    <td width="33%" style="text-align: right;">{PAGENO}/{nbpg}</td>
                </tr>
            </table>';
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);

            $stylesheet = file_get_contents('public/assets/mpdf.css');
            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $summery = 'Summary';
            $mpdf->WriteHTML(view('report.cover', compact('projectDetail', 'summery')));
            $mpdf->WriteHTML(view('report.shipParticular', compact('projectDetail')));
            $mpdf->AddPage('L'); // Set landscape mode for the inventory page

            $mpdf->WriteHTML(view('report.Inventory', compact('filteredResults1', 'filteredResults2', 'filteredResults3', 'decks')));
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

                        //  $mpdf->useTemplate($templateId, 0, 5, null, null);
                    }
                }
            }
            $safeProjectNo = str_replace('/', '_', $projectDetail['project_no']);
            $fileName = "summary_" . $safeProjectNo . '.pdf';

            $filePath = public_path('pdfs1/' . $fileName); // Adjust the directory and file name as needed
            $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
            $response = response()->download($filePath, $fileName)->deleteFileAfterSend(true);
            $response->headers->set('X-File-Name', $fileName);
            return $response;
        } catch (\Mpdf\MpdfException $e) {
            // Handle mPDF exception
            echo $e->getMessage();
        }
    }
}
