<?php

namespace App\Http\Controllers;

use App\Models\AuditRecords;
use App\Models\ClientCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditRecordssController extends Controller
{
    //
    public function index($id = null)
    {
       
        if($id){
            $user = Auth::user()->load([
                'hazmatCompany:id,name',
            ]);
            $client = ClientCompany::find($id)->first();
            $auditRecords = AuditRecords::where('client_company_id',$id)->get();
            $auditiname = $client['name'];
            $client_company_id = "";

        }else{
            $user = Auth::user()->load([
                'clientCompany:user_id,name,id',
                'hazmatCompany:id,name',
            ]);
            $client_company_id = $user['clientCompany']['id'];
            $auditiname = $user['clientCompany']['name'];
          
            $auditRecords = AuditRecords::where('client_company_id',$client_company_id)->get();

        }
        $auditieename = $user['hazmatCompany']['name'];
       

        $hazmat_companies_id = $user['hazmat_companies_id'];
        
        return view('auditRecords.index', compact('auditiname', 'auditieename', 'hazmat_companies_id', 'client_company_id','auditRecords'));
    }
    public function store(Request $request)
    {
        $post = $request->input();
        $file = $request->file('attachment');

        AuditRecords::updateOrCreateWithFile(
            $request->input('id'), // or null for create
            [
                'client_company_id' => $post['client_company_id'],
                'hazmat_companies_id' => $post['hazmat_companies_id'],
                'date' => $post['date'],
                'auditor_person_name' => $post['auditor_person_name'],
                'auditee_person_name' => $post['auditor_person_name'],
                'auditor_designation' => $post['auditor_designation'],
                'auditee_designation'=>$post['auditee_designation'],
            ],
            $file
        );
        return response()->json(['isStatus' => true, 'message' => "Save Successfully"]);

    }
    public function destroy($id){
       $auditrecords = AuditRecords::deleteWithAttachment($id);
      
       return response()->json(['isStatus' => true, 'message' => "Remove Successfully"]);

    }
}
