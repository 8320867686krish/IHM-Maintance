<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditRecordssController extends Controller
{
    //
    public function index(){
        return view('auditRecords.index');

    }
    public function store(Request $request){
        dd($request->input());
    }
}
