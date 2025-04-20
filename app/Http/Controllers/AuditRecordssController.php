<?php

namespace App\Http\Controllers;

use App\Models\AuditRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditRecordssController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->load([
            'clientCompany:user_id,name',
            'hazmatCompany:id,name',
        ]);
        $user_id = $user['id'];
        $auditRecords = AuditRecords::where('user_id',$user_id)->get();

        $hazmat_companies_id = $user['hazmat_companies_id'];
        $auditiname = $user['clientCompany']['name'];
        $auditieename = $user['hazmatCompany']['name'];
        return view('auditRecords.index', compact('auditiname', 'auditieename', 'hazmat_companies_id', 'user_id','auditRecords'));
    }
    public function store(Request $request)
    {
        $post = $request->input();
        if(@$post['deleted_id']){
            $ids = explode(',',$post['deleted_id']);
            foreach($ids as $id){
                AuditRecords::deleteWithAttachment($id);

            }
        }
        if (@$post['items']) {
            foreach ($post['items'] as $index => $value) {
                $file = $request->file("items.$index.attachment") ?? null;

                AuditRecords::updateOrCreateWithFile(
                    $index,
                    [
                        'user_id' => $request->input('user_id'),
                        'hazmat_companies_id' => $request->input('hazmat_companies_id'),
                        'date' => $value['date'],
                    ],
                    $file
                );
            }
        }
        return response()->json(['isStatus' => true, 'message' => "Save Successfully"]);

    }
}
