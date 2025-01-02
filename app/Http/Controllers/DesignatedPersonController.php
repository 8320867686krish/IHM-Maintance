<?php

namespace App\Http\Controllers;

use App\Models\DesignatedPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignatedPersonController extends Controller
{
    //
    public function store(Request $request){
        $inputData = $request->input();
        $user = Auth::user();
        if($inputData['currentUserRoleLevel'] == 6){
            $inputData['ship_id'] = $user->shipClient->id;
        }
     
        $inputData['ship_staff_id'] = Auth::user()->id;
        $insert = DesignatedPerson::updateOrCreate(['id' => $inputData['id']], $inputData);
        return response()->json(["isStatus" => true, "message" => "Attachment  save successfully",'url'=>url('dashboard')]);
    }
}
