<?php

namespace App\Http\Controllers;

use App\Models\Majorrepair;
use App\Models\PreviousAttachment;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MajorrepairController extends Controller
{
    use ImageUpload;

    public function index(Request $request)
    {
        $ship_id = Session::get('ship_id');
        $majorrepair = Majorrepair::where('ship_id',$ship_id )->orderBy('id', 'desc')->get();
       
        return view('majorRepair.list', compact('majorrepair'));
    }

    public function majorrepairSave(Request $request)
    {
        $post = $request->input();
        unset($post['_token']);
        if ($post['id'] == 0) {
            if (!@$post['ship_id']) {

                $post['ship_id'] = Session::get('ship_id');
            }
        }
        $majrrecoerds = Majorrepair::where('ship_id', $post['ship_id'])->first();
        if ($request->has('document')) {
            if ($post['id'] != 0) {
                if (@$majrrecoerds->document) {
                    $imagePath = public_path("uploads/majorrepair/") . $majrrecoerds->document;

                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $image = $this->upload($request, 'document', 'uploads/majorrepair');
            $post['document'] = $image;
        }
        if ($request->has('before_image')) {
            if ($post['id'] != 0) {
                if (@$majrrecoerds->before_image) {
                    $imagePath = public_path("uploads/majorrepair/") . $majrrecoerds->before_image;

                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $image = $this->upload($request, 'before_image', 'uploads/majorrepair');
            $post['before_image'] = $image;
        }
        if ($request->has('after_image')) {
            if ($post['id'] != 0) {
                if (@$majrrecoerds->after_image) {
                    $imagePath = public_path("uploads/majorrepair/") . $majrrecoerds->after_image;

                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $image = $this->upload($request, 'after_image', 'uploads/majorrepair');
            $post['after_image'] = $image;
        }
        Majorrepair::updateOrCreate(['id' => $post['id']], $post);
        $majorrepair = Majorrepair::where('ship_id', $post['ship_id'])->orderBy('id','asc')->get();
        $html =  view('components.majorrepair-list', compact('majorrepair'))->render();
        return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
    }
    public function previousAttachmentSave(Request $request){
        $post = $request->input();
        unset($post['_token']);
        $post['ship_id'] = Session::get('ship_id');

        $previousRecords = PreviousAttachment::where('ship_id', $post['ship_id'])->first();
        if ($request->has('attachment')) {
            if ($post['id'] != 0) {
                if (@$previousRecords->attachment) {
                    $imagePath = public_path("uploads/previousattachment/") . $previousRecords->attachment;

                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $image = $this->upload($request, 'attachment', 'uploads/previousattachment');
            $post['attachment'] = $image;
        }
        
        PreviousAttachment::updateOrCreate(['id' => $post['id']], $post);
        $previousAttachment = PreviousAttachment::where('ship_id', $post['ship_id'])->orderBy('id','asc')->get();
        $html =  view('components.previous-attachment-list', compact('previousAttachment'))->render();
        return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
    }
    public function majorrepairDelete($id)
    {
        try {
            $ship_id= Session::get('ship_id');


            $majorrepairRecords = Majorrepair::findOrFail($id);
            $ship_id = $majorrepairRecords->ship_id;
            if (@$majorrepairRecords->document) {
                $imagePath = public_path("uploads/majorrepair/") . $majorrepairRecords->document;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $majorrepairRecords->delete();
            $majorrepair = Majorrepair::where('ship_id', $ship_id)->orderBy('id', 'desc')->get();
            $html =  view('components.majorrepair-list', compact('majorrepair'))->render();
            return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'credential not  deleted successfully']);
        }
    }
}
