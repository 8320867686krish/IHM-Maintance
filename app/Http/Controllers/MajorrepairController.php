<?php

namespace App\Http\Controllers;

use App\Models\Majorrepair;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajorrepairController extends Controller
{
    use ImageUpload;
    
    public function index(Request $request){
        $user = Auth::user();
        $majorrepair = Majorrepair::where('ship_staff_id',$user->id)->orderBy('id','desc')->get();
        return view('majorRepair.list',compact('majorrepair'));
    }

    public function majorrepairSave(Request $request){
        $post = $request->input();
        unset($post['_token']);
        $user = Auth::user();
        if($post['id'] == 0){
            $post['hazmat_companies_id'] = $user['hazmat_companies_id'];
            $post['ship_staff_id'] = $user->id;
            $post['ship_id'] = $user->shipClient->id;
        }
        $majrrecoerds = Majorrepair::where('ship_staff_id',$post['id'])->first();
        if($request->has('document')){
            if($post['id'] !=0){
                if(@$majrrecoerds->document){
                    $imagePath = public_path("uploads/majorrepair/").$majrrecoerds->document;
    
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $image = $this->upload($request, 'document', 'uploads/majorrepair');
            $post['document'] = $image;
        }
        Majorrepair::updateOrCreate(['id' => $post['id']], $post);
        if($post['ship_id']){
            $majorrepair = Majorrepair::where('ship_id',$post['ship_id'])->orderBy('id','desc')->get();
        }else{
            $majorrepair = Majorrepair::where('ship_staff_id',$user->id)->orderBy('id','desc')->get();
        }
        $html =  view('components.majorrepair-list',compact('majorrepair'))->render();
        return response()->json(['isStatus' => true, 'message' => 'save successfully','html'=>$html ]);
    }
    public function majorrepairDelete($id){
        try {
            $user = Auth::user();
            $hazmat_companies_id = $user['hazmat_companies_id'];
            $majorrepairRecords = Majorrepair::findOrFail($id);
            if(@$majorrepairRecords->document){
                $imagePath = public_path("uploads/majorrepair/").$majorrepairRecords->document;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
           
            $majorrepairRecords->delete();
            $majorrepair = Majorrepair::where('ship_staff_id',$user->id)->orderBy('id','desc')->get();
            $html =  view('components.majorrepair-list',compact('majorrepair'))->render();
            return response()->json(['isStatus' => true, 'message' => 'save successfully','html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'credential not  deleted successfully']);
        }
    }
}
