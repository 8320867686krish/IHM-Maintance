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
        $designatePerson = $user->designatedPerson;
        $ships = Ship::where('client_user_id', $user->id)->get();
        
        return view('shipdesignated.list', compact('designatePerson','ships'));

    }
    public function responsibleperson(){
        $user = Auth::user();
        $designatePerson = $user->designatedPerson;
        $ships = Ship::where('client_user_id', $user->id)->get();
        
        return view('shipdesignated.responsible', compact('designatePerson','ships'));

    }
}
