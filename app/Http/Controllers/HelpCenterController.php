<?php

namespace App\Http\Controllers;

use App\Http\Requests\credentialRequest;
use App\Http\Requests\extractSmsRequest;
use App\Mail\CorrespondenceMail;
use App\Models\ClientCompany;
use App\Models\configration;
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
        $currentUserRoleLevel =$user->roles->first()->level;
        $correspondence = Correspondence::query();
        $configration = configration::first();

        if ($currentUserRoleLevel != 1) {
            $correspondence = Correspondence::query();
            if ($currentUserRoleLevel == 5) {
                $correspondence->where('client_company_id', $user->clientCompany->id);
            } else if ($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
                $correspondence->with(['shipDetail:id,ship_name', 'clientDetail:id,name']);
                $correspondence->where('hazmat_companies_id', $user['hazmat_companies_id']);
            } else {
                $correspondence->where('user_id', $user->id);
            }
            $correspondence->WhereNotNull('client_company_id');
            $correspondence = $correspondence->orderBy('id', 'desc')->get();
        } else {
            $correspondence = [];
        }
        if ($currentUserRoleLevel == 1 || $currentUserRoleLevel == 2) {
            $admincorrespondence = Correspondence::query();
            if ($currentUserRoleLevel == 2) {
                $admincorrespondence->with(['hmatCompanyDetail']);
                $admincorrespondence->where('hazmat_companies_id', $user['hazmat_companies_id']);
            }
            $admincorrespondence->WhereNull('client_company_id');
            $admincorrespondence = $admincorrespondence->orderBy('id', 'desc')->get();
        } else {
            $admincorrespondence = [];
        }


        $credentials = credential::query();
        if ($currentUserRoleLevel > 1) {
            $credentials->where('hazmat_companies_id', $user['hazmat_companies_id']);
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
        if ($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $clientCompany =  ClientCompany::select('id', 'name')->where('hazmat_companies_id', $user['hazmat_companies_id'])->get()->toArray();
        } else {
            $clientCompany = [];
        }
        $extractSsms = ExtractSms::query();
        if ($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $extractSsms->where('hazmat_companies_id', $user['hazmat_companies_id']);
        }
        if ($currentUserRoleLevel == 5) {
            $extractSsms->where('client_company_id', $user->clientCompany->id);
        }
        if ($currentUserRoleLevel == 6) {
            $extractSsms->where('client_company_id', $user->shipClient->client_company_id);
        }
        $extractSsms =  $extractSsms->get()->toArray();
        return view('helpCenter.index', compact('ships','correspondence', 'credentials', 'clientCompany', 'extractSsms', 'configration', 'admincorrespondence'));
    }
    public function avilabletemplateeSave(Request $request)
    {
        $post = $request->input();
        $configration = configration::find($post['id']);
        if ($request->hasFile('training_material')) {
            if (@$configration && @$configration->training_material) {
                $oldImagePath = $this->deleteImage('uploads/avilable/', $configration->training_material);
            }

            $image = $this->upload($request, 'training_material', 'uploads/avilable/');
            $post['training_material'] = $image;
        }

        if ($request->hasFile('briefing_material')) {
            if (@$configration && @$configration->briefing_material) {
                $oldImagePath = $this->deleteImage('uploads/avilable/', $configration->briefing_material);
            }
            $image = $this->upload($request, 'briefing_material', 'uploads/avilable/');
            $post['briefing_material'] = $image;
        }

        if ($request->hasFile('sms_extract')) {
            if (@$configration && @$configration->sms_extract) {
                $oldImagePath = $this->deleteImage('uploads/avilable/', $configration->sms_extract);
            }
            $image = $this->upload($request, 'sms_extract', 'uploads/avilable/');
            $post['sms_extract'] = $image;
        }

        if ($request->hasFile('operation_manual')) {
            if (@$configration && @$configration->operation_manual) {
                $oldImagePath = $this->deleteImage('uploads/avilable/', $configration->operation_manual);
            }
            $image = $this->upload($request, 'operation_manual', 'uploads/avilable/');
            $post['operation_manual'] = $image;
        }
        $configration = configration::updateOrCreate(['id' => $request->input('id')], $post);
        return response()->json(['isStatus' => true, 'message' => 'save successfully']);
    }
    public function correspondenceSave(Request $request)
    {
        $post = $request->input();
        $user = Auth::user();
        $currentUserRoleLevel =$user->roles->first()->level;
        $post['user_id'] =$user->id;
        if ($request->hasFile('attachment')) {
            $image = $this->upload($request, 'attachment', 'uploads/corospondance_attachment');
            $post['attachment'] = $image;
        }
        if ($currentUserRoleLevel == 2) {
            $post['hazmat_companies_id'] = $user->hazmat_companies_id;
            Correspondence::create($post);
            $admincorrespondence = Correspondence::query();
            $admincorrespondence->with(['hmatCompanyDetail']);
            $admincorrespondence->where('hazmat_companies_id', $user['hazmat_companies_id']);
            $admincorrespondence->WhereNull('client_company_id');
            $admincorrespondence = $admincorrespondence->orderBy('id', 'desc')->get();
            $html = view('components.super-admin-corospondance', compact('admincorrespondence'))->render();

            return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
        }
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

        Correspondence::create($post);
        $mailData = [
            'from' => $fromemail,
            'subject' => $post['subject'],
            'content' => $post['content'],
            'attachment' => $post['attachment'] ?? null, // Pass the attachment if exists
        ];
        Mail::to($toemail)->queue(new CorrespondenceMail($mailData));
        $correspondence = Correspondence::query();
        if ($currentUserRoleLevel == 5) {
            $correspondence->with(['shipDetail:id,ship_name', 'clientDetail:id,name']);

            $correspondence->where('client_company_id', $user->clientCompany->id);
        } else {
            $correspondence->where('user_id', $user->id);
        }
        $correspondence->WhereNotNull('client_company_id');
        $correspondence = $correspondence->orderBy('id', 'desc')->get();
       
        $html = view('components.correspondence-history', compact('correspondence'))->render();
        return response()->json(['isStatus' => true, 'message' => 'save successfully','html'=>$html]);
    }
    public function credentialSave(credentialRequest $request)
    {
        $post = $request->input();
        $user = Auth::user();
        $hazmat_companies_id = $user['hazmat_companies_id'];
        if ($request->has('document')) {
            $image = $this->upload($request, 'document', 'uploads/credentials');
            $post['document'] = $image;
        }
        $post['hazmat_companies_id'] =  $hazmat_companies_id;
        credential::create($post);
        $credentials = credential::where('hazmat_companies_id', $post['hazmat_companies_id'])->get();
        $currentUserRoleLevel = $user->roles->first()->level;


        $html = view('components.credential', compact('credentials'))->render();

        return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
    }
    public function smsSave(extractSmsRequest $request)
    {
        $post = $request->input();
        $user = Auth::user();
        $hazmat_companies_id = $user['hazmat_companies_id'];
        if ($request->has('document')) {
            $image = $this->upload($request, 'document', 'uploads/extractSms');
            $post['document'] = $image;
        }
        $post['hazmat_companies_id'] =  $hazmat_companies_id;
        ExtractSms::create($post);
        $extractSsms = ExtractSms::where('hazmat_companies_id', $post['hazmat_companies_id'])->get();
        $currentUserRoleLevel =$user->roles->first()->level;

        $html = view('components.extract-sms', compact('extractSsms'))->render();

        return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
    }
    public function deleteCredential($id)
    {
        try {
            $user = Auth::user();
            $hazmat_companies_id = $user['hazmat_companies_id'];
            $credential = credential::findOrFail($id);
            if (@$credential->document) {
                $imagePath = public_path("uploads/credentials/") . $credential->document;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $credential->delete();
            $credentials = credential::where('hazmat_companies_id', $hazmat_companies_id)->get();

            $html = view('components.credential', compact('credentials'))->render();
            return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'credential not  deleted successfully']);
        }
    }

    public function smsRemove($id)
    {
        try {
            $user = Auth::user();
            $hazmat_companies_id = $user['hazmat_companies_id'];
            $extractSms = ExtractSms::findOrFail($id);
            if (@$extractSms->document) {
                $imagePath = public_path("uploads/extractSms/") . $extractSms->document;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $extractSms->delete();
            $extractSsms = ExtractSms::where('hazmat_companies_id', $hazmat_companies_id)->get();
            $currentUserRoleLevel =$user->roles->first()->level;

            $html = view('components.extract-sms', compact('extractSsms'))->render();
            return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'credential not  deleted successfully']);
        }
    }
}
