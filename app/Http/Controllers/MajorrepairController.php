<?php

namespace App\Http\Controllers;

use App\Models\Majorrepair;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajorrepairController extends Controller
{
    use ImageUpload;

    public function index(Request $request)
    {
        $user = Auth::user();
        $majorrepair = Majorrepair::where('ship_staff_id', $user->id)->orderBy('id', 'desc')->get();
        if ($request->ajax()) {
            $majorrepair = Majorrepair::where('ship_staff_id', $user->id)
                ->orderBy('id', 'desc')
                ->get(); // ✅ Use pagination
            return response()->json([
                "draw" => intval($request->input('draw')), // Needed for DataTables
                "recordsTotal" => $majorrepair->count(),
                "recordsFiltered" => $majorrepair->count(),
                "data" => $majorrepair // ✅ Send paginated data
            ]);
        }
        return view('majorRepair.list', compact('majorrepair'));
    }

    public function majorrepairSave(Request $request)
    {
        $post = $request->input();
        unset($post['_token']);
        $user = Auth::user();
        if ($post['id'] == 0) {
            if (!@$post['ship_id']) {

                $post['hazmat_companies_id'] = $user['hazmat_companies_id'];
                $post['ship_staff_id'] = $user->id;
                $post['ship_id'] = $user->shipClient->id;
            }
        }
        $majrrecoerds = Majorrepair::where('ship_staff_id', $post['id'])->first();
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
        if ($post['ship_id']) {
            $majorrepair = Majorrepair::where('ship_id', $post['ship_id'])->orderBy('id', 'desc')->get();
        } else {
            $majorrepair = Majorrepair::where('ship_staff_id', $user->id)->orderBy('id', 'desc')->get();
        }
        $html =  view('components.majorrepair-list', compact('majorrepair'))->render();
        return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
    }
    public function majorrepairDelete($id)
    {
        try {
            $user = Auth::user();

            $currentUserRoleLevel = $user->roles->first()->level;


            $hazmat_companies_id = $user['hazmat_companies_id'];
            $majorrepairRecords = Majorrepair::findOrFail($id);
            $ship_id = $majorrepairRecords->ship_id;
            if (@$majorrepairRecords->document) {
                $imagePath = public_path("uploads/majorrepair/") . $majorrepairRecords->document;

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $majorrepairRecords->delete();
            if ($currentUserRoleLevel != 6) {
                $majorrepair = Majorrepair::where('ship_id', $ship_id)->orderBy('id', 'desc')->get();
            } else {
                $majorrepair = Majorrepair::where('ship_staff_id', $user->id)->orderBy('id', 'desc')->get();
            }
            $html =  view('components.majorrepair-list', compact('majorrepair'))->render();
            return response()->json(['isStatus' => true, 'message' => 'save successfully', 'html' => $html]);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'credential not  deleted successfully']);
        }
    }
}
