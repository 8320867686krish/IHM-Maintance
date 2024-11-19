<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\CheckHazmat;
use App\Models\Deck;
use App\Models\Hazmat;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class VscpController extends Controller
{
    //
    public function index($ship_id)
    {
        $ship = Ship::with('decks')->find($ship_id);

        return view('ships.vscp.index', compact('ship', 'ship_id'));
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
    public function check($deck_id){
        $deck = Deck::with('checks')->find($deck_id);
        $hazmats = Hazmat::get(['id', 'name', 'table_type']);
        return view('ships.vscp.check.check', ['deck' => $deck, 'hazmats' => $hazmats]);
    }
    public function checkSave(Request $request){
        $inputData = $request->input();
        $id = $request->input('id');
        
        $data = Check::updateOrCreate(['id' => $id], $inputData);
        $updatedData = $data->getAttributes();
        $saveid = $updatedData['id'];
        $name = $updatedData['name'];
      
        if(@$inputData['check_hazmats']){
            foreach ($inputData['check_hazmats'] as $key => $value){
                $value['check_id'] = $saveid;
                $value['ship_id'] = $inputData['ship_id'];
                $value['deck_id'] = $inputData['deck_id'];
                CheckHazmat::updateOrCreate(['id' => $key], $value);

            }
        }
        if (!empty($inputData['deck_id'])) {
            $checks = Check::where('deck_id', $inputData['deck_id'])->get();

            //$project = Deck::with('checks')->find($inputData['deck_id']);
        //    $trtd = view('projects.allcheckList', compact('project'))->render();

            $htmllist = view('components.check-list', compact('checks'))->render();

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

    public function checkHazmat($check_id){
        $check = Check::with('hazmats')->find($check_id);
        $checkhazmat = $check->hazmats ?? [];
        $hazmats = Hazmat::get(['id', 'name', 'table_type']);
        $htmllist = view('ships.vscp.check.checkAddModal', compact('checkhazmat','hazmats'))->render();

        return response()->json(['html' => $htmllist,"check" => $check]);
    }
}
