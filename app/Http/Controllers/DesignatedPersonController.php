<?php

namespace App\Http\Controllers;

use App\Http\Requests\designatedRequest;
use App\Models\DesignatedPersionShip;
use App\Models\DesignatedPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
                $inputData['ship_id'] = Session::get('ship_id');
            }
        }
        $inputData['ship_staff_id'] = Auth::user()->id;
        $insert = DesignatedPerson::updateOrCreate(['id' => $inputData['id']], $inputData);
        $id = $insert->id;
        if($inputData['position'] != 'SuperDp'){
            DesignatedPersionShip::updateOrCreate(
                [
                    'ship_id' => $inputData['ship_id'],
                    'designated_person_id' => $id, // Unique combination to check
                ],
                [
                    'ship_id' => $inputData['ship_id'],
                    'designated_person_id' => $id
                ]
            );
        }
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
    public function saveAdminDesignatedPerson(Request $request)
    {
        $post = $request->input();
        $inputData = $post;
        $inputData = $request->input();
        if(!@$inputData['type']){
            $ship_id = session::get('ship_id');
        }
      
        if ($inputData['id']) {
            unset($post['ship_staff_id']);
        } else {
           $inputData['position'] = $inputData['position'] ?? 'SuperDp';
        }
        $insert = DesignatedPerson::updateOrCreate(['id' => $inputData['id']], $inputData);
       
      
            if(!@$inputData['type']){
                DesignatedPersionShip::updateOrCreate(
                    [
                        'ship_id' => $ship_id,
                        'designated_person_id' =>  $inputData['id'] ?? $insert->id, // Unique combination to check
                    ],
                    [
                        'ship_id' => $ship_id,
                        'designated_person_id' =>  $inputData['id'] ?? $insert->id
                    ]
                );
            }else{
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
                                'designated_person_id' => $inputData['id'], // Use inputData['id'] if it's set, otherwise fall back to $insert->id
                            ],
                            [
                                'ship_id' => $shipId,
                                'designated_person_id' =>  $inputData['id'] ?? $insert->id
                            ]
                        );
                    }
                }
            }
            if(!@$inputData['type']){
                $trainingRecoreds = DesignatedPersionShip::with('designatedPersonDetail')
                ->where('ship_id', $ship_id)
                ->whereHas('designatedPersonDetail', function ($query) {
                    $query->where('position', '!=','SuperDP');
                })
                ->get();
        
                $html = view('components.trainning-record', compact('trainingRecoreds'))->render();
            }else{
                
                $dpsore = DesignatedPersionShip::with('designatedPersonDetail')
                ->where('ship_id',session::get('ship_id'))
                ->whereHas('designatedPersonDetail', function ($query) {
                    $query->where('position','=','SuperDp');
                })
                ->get();
                $html = view('components.soredp-list', compact('dpsore'))->render();
            }
       
                    
                    

        return response()->json(["isStatus" => true, "message" => "save successfully", 'html' => $html]);
    }
}
