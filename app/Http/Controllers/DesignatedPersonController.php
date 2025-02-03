<?php

namespace App\Http\Controllers;

use App\Http\Requests\designatedRequest;
use App\Models\DesignatedPersionShip;
use App\Models\DesignatedPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Helper\DescriptorHelper;

class DesignatedPersonController extends Controller
{
    //
    public function store(designatedRequest $request)
    {
        $post = $request->input();
        $inputData = $post;
        $user = Auth::user();

        if (@$post['ship_id']) {
            unset($inputData['ship_id']);
        } else {
            if ($post['currentUserRoleLevel'] == 6) {
                $inputData['ship_id'] = $user->shipClient->id;
            }
        }
        $inputData['ship_staff_id'] = Auth::user()->id;
        $insert = DesignatedPerson::updateOrCreate(['id' => $inputData['id']], $inputData);
        $id = $insert->id;
        if (@$post['ship_id']) {
            $currentShipIds = DesignatedPersionShip::where('designated_person_id', $id)->pluck('ship_id')->toArray();
            $shipIdsToRemove = array_diff($currentShipIds, $post['ship_id']);
            DesignatedPersionShip::whereIn('ship_id', $shipIdsToRemove)
                ->where('designated_person_id', $id)
                ->delete();
            foreach ($post['ship_id'] as $shipId) {
                DesignatedPersionShip::updateOrCreate(
                    [
                        'ship_id' => $shipId,
                        'designated_person_id' => $id, // Unique combination to check
                    ],
                    [
                        'ship_id' => $shipId,
                        'designated_person_id' => $id
                    ]
                );
            }
        }

        return response()->json(["isStatus" => true, "message" => "Attachment  save successfully", 'url' => url('dashboard')]);
    }
    public function designatedPersonShip($designated_person_id)
    {
        $designatedPersonShip = DesignatedPerson::with('designatedPersionShips')->find($designated_person_id);
        $shipIds = $designatedPersonShip->designatedPersionShips->pluck('ship_id');
        return response()->json(["isStatus" => true, 'shipIds' => $shipIds]);
    }
    public function saveAdminDesignatedPerson(Request $request){
        $post = $request->input();
        $inputData = $post;
        $inputData = $request->input();
        if(@$inputData['type']){
            unset($inputData['ship_id']);
        }
        if(@$inputData['main_ship_id']){
            $ship_id = $inputData['main_ship_id'];
        }else{
            $ship_id = $inputData['ship_id'];
            unset($post['ship_id']);
        }
        $insert = DesignatedPerson::updateOrCreate(['id' => $inputData['id']], $inputData);
        if (@$post['ship_id']) {
            $currentShipIds = DesignatedPersionShip::where('designated_person_id', $inputData['id'])->pluck('ship_id')->toArray();
            $shipIdsToRemove = array_diff($currentShipIds, $post['ship_id']);
            DesignatedPersionShip::whereIn('ship_id', $shipIdsToRemove)
                ->where('designated_person_id', $inputData['id'])
                ->delete();
            foreach ($post['ship_id'] as $shipId) {
                DesignatedPersionShip::updateOrCreate(
                    [
                        'ship_id' => $shipId,
                        'designated_person_id' => $inputData['id'], // Unique combination to check
                    ],
                    [
                        'ship_id' => $shipId,
                        'designated_person_id' => $inputData['id']
                    ]
                );
            }
        }
     
        if(@$inputData['main_ship_id']){
            $dpsore = DesignatedPersionShip::with('designatedPersonDetail')->where('ship_id',$ship_id)->get();
            $html = view('components.soredp-list', compact('dpsore'))->render();

        }else{
         
            $trainingRecoreds = DesignatedPerson::where('ship_id',$ship_id)->get();
            $html = view('components.trainning-record', compact('trainingRecoreds'))->render();
        }

        return response()->json(["isStatus" => true, "message" => "save successfully",'html'=>$html]);

    }
}
