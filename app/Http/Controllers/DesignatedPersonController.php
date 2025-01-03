<?php

namespace App\Http\Controllers;

use App\Models\DesignatedPersionShip;
use App\Models\DesignatedPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Helper\DescriptorHelper;

class DesignatedPersonController extends Controller
{
    //
    public function store(Request $request){
        $post = $request->input();
        $inputData = $post;
        $user = Auth::user();

        if(@$post['ship_id']){
           unset($inputData['ship_id']);
        }else{
            if($post['currentUserRoleLevel'] == 6){
                $inputData['ship_id'] = $user->shipClient->id;
            }
        }
       
     
        $inputData['ship_staff_id'] = Auth::user()->id;
        $insert = DesignatedPerson::updateOrCreate(['id' => $inputData['id']], $inputData);
        $id = $insert->id;
        if(@$post['ship_id']){
            $currentShipIds = DesignatedPersionShip::where('designated_person_id',$id)->pluck('ship_id')->toArray();
            $shipIdsToRemove = array_diff($currentShipIds,$post['ship_id']);
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

        return response()->json(["isStatus" => true, "message" => "Attachment  save successfully",'url'=>url('dashboard')]);
    }
    public function designatedPersonShip($designated_person_id){
        $designatedPersonShip = DesignatedPerson::with('designatedPersionShips')->find($designated_person_id);
        $shipIds = $designatedPersonShip->designatedPersionShips->pluck('ship_id');
        return response()->json(["isStatus" => true,'shipIds'=>$shipIds]);

    }
}
