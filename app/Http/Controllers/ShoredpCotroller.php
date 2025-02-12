<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoredpCotroller extends Controller
{
    //
    public function shoredp(){
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $designatePerson = $user->designatedPerson;
        $ships = Ship::where('client_user_id', $user->id)->get();
        
        return view('shipdesignated.list', compact('designatePerson','currentUserRoleLevel','ships'));

    }
    public function responsibleperson(){
        
    }
}
