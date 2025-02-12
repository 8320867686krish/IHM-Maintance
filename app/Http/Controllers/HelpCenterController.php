<?php

namespace App\Http\Controllers;

use App\Http\Requests\credentialRequest;
use App\Http\Requests\extractSmsRequest;
use App\Mail\CorrespondenceMail;
use App\Models\ClientCompany;
use App\Models\Correspondence;
use App\Models\credential;
use App\Models\ExtractSms;
use App\Models\Ship;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HelpCenterController extends Controller
{
    use ImageUpload;
    public function index()
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $correspondence = Correspondence::query();

       
        if ($currentUserRoleLevel <= 4) {
            $correspondence = Correspondence::query();
            if($currentUserRoleLevel == 1){
                $correspondence->with(['shipDetail:id,ship_name','clientDetail:id,name','hmatCompanyDetail']);
            }
            else if ($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
                $correspondence->with(['shipDetail:id,ship_name','clientDetail:id,name']);

                $correspondence->where('hazmat_companies_id', $user['hazmat_companies_id']);
            }
            $correspondence = $correspondence->orderBy('id','desc')->get();
        }else{
            $correspondence = [];
        }
        $credentials = credential::query();
        if ($currentUserRoleLevel > 1){
            $credentials->where('hazmat_companies_id',$user['hazmat_companies_id']);
        }
        $credentials = $credentials->get();

        if ($currentUserRoleLevel == 5) {
            $shipsQuery = Ship::select('id', 'ship_name')->with('pOOrderItems');

            $shipsQuery->when($currentUserRoleLevel == 2, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id']);
            });

            $shipsQuery->when($currentUserRoleLevel == 5, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                    ->where('client_user_id', $user['id']);
            });

            $shipsQuery->when($currentUserRoleLevel == 6, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                    ->where('user_id', $user['id']);
            });

            // Execute the query and get the ships
            $ships = $shipsQuery->get();
        } else {
            $ships = [];
        }
        if($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4){
            $clientCompany =  ClientCompany::select('id','name')->where('hazmat_companies_id',$user['hazmat_companies_id'])->get()->toArray();
        }else{
            $clientCompany = [];
        }
        $extractSsms = ExtractSms::query();
        if($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4){
            $extractSsms->where('hazmat_companies_id',$user['hazmat_companies_id']);
        }
        if($currentUserRoleLevel == 5){
            $extractSsms->where('client_company_id',$user->clientCompany->id);
        }
        if($currentUserRoleLevel == 6){
            $extractSsms->where('client_company_id',$user->shipClient->client_company_id);

        }
        $extractSsms =  $extractSsms->get()->toArray();
       
        return view('helpCenter.index', compact('ships', 'currentUserRoleLevel', 'correspondence','credentials','clientCompany','extractSsms'));
    }
    public function correspondenceSave(Request $request)
    {
        $post = $request->input();
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $toemail = $user->hazmatCompany->email;
        if ($currentUserRoleLevel == 5) {
            $post['client_company_id'] = $user->clientCompany->id;
            $fromemail = $user->email;
        } else {
            $fromemail = $user->shipClient->shipStaff->email;
            $post['client_company_id'] = $user->shipClient->client_company_id;
            $post['ship_id'] = $user->shipClient->id;
        }
        $post['hazmat_companies_id'] = $user->hazmat_companies_id;
        if ($request->hasFile('attachment')) {
            $image = $this->upload($request, 'attachment', 'uploads/corospondance_attachment');
            $post['attachment'] = $image;
        }
        Correspondence::create($post);
        $mailData = [
            'from' => $fromemail,
            'subject' => $post['subject'],
            'content' => $post['content'],
            'attachment' => $post['attachment'] ?? null, // Pass the attachment if exists
        ];
        Mail::to($toemail)->queue(new CorrespondenceMail($mailData));
        return response()->json(['isStatus' => true, 'message' => 'save successfully']);
    }
    public function credentialSave(credentialRequest $request){
        $post = $request->input();
        $user = Auth::user();
        $hazmat_companies_id = $user['hazmat_companies_id'];
        if($request->has('document')){
            $image = $this->upload($request, 'document', 'uploads/credentials');
            $post['document'] = $image;
        }
        $post['hazmat_companies_id'] =  $hazmat_companies_id;
        credential::create($post);
        $credentials = credential::where('hazmat_companies_id',$post['hazmat_companies_id'])->get();
        $currentUserRoleLevel = $user->roles->first()->level;

        $html = view('components.credential', compact('credentials','currentUserRoleLevel'))->render();

        return response()->json(['isStatus' => true, 'message' => 'save successfully','html' => $html]);

    }
    public function smsSave(extractSmsRequest $request){
        $post = $request->input();
        $user = Auth::user();
        $hazmat_companies_id = $user['hazmat_companies_id'];
        if($request->has('document')){
            $image = $this->upload($request, 'document', 'uploads/extractSms');
            $post['document'] = $image;
        }
        $post['hazmat_companies_id'] =  $hazmat_companies_id;
        ExtractSms::create($post);
        $extractSsms = ExtractSms::where('hazmat_companies_id',$post['hazmat_companies_id'])->get();
        $currentUserRoleLevel = $user->roles->first()->level;

        $html = view('components.extract-sms', compact('extractSsms','currentUserRoleLevel'))->render();

        return response()->json(['isStatus' => true, 'message' => 'save successfully','html' => $html]);

    }
    public function deleteCredential($id){
        try {
            $user = Auth::user();
            $hazmat_companies_id = $user['hazmat_companies_id'];
            $credential = credential::findOrFail($id);
            if(@$credential->document){
                $imagePath = public_path("uploads/credentials/").$credential->document;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
           
            $credential->delete();
            $credentials = credential::where('hazmat_companies_id',$hazmat_companies_id)->get();

            $html = view('components.credential', compact('credentials'))->render();
            return response()->json(['isStatus' => true, 'message' => 'save successfully','html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'credential not  deleted successfully']);
        }
    }
    
    public function smsRemove($id){
        try {
            $user = Auth::user();
            $hazmat_companies_id = $user['hazmat_companies_id'];
            $extractSms = ExtractSms::findOrFail($id);
            if(@$extractSms->document){
                $imagePath = public_path("uploads/extractSms/").$extractSms->document;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
           
            $extractSms->delete();
            $extractSsms = ExtractSms::where('hazmat_companies_id',$hazmat_companies_id)->get();
            $currentUserRoleLevel = $user->roles->first()->level;

            $html = view('components.extract-sms', compact('extractSsms','currentUserRoleLevel'))->render();
            return response()->json(['isStatus' => true, 'message' => 'save successfully','html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'credential not  deleted successfully']);
        }
    }
}
