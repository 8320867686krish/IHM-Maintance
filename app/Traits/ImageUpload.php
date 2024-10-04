<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait ImageUpload {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function upload(Request $request, $fieldname, $directory ) {
        if( $request->hasFile( $fieldname ) ) {
            if (!$request->file($fieldname)->isValid()) {
                
               // return redirect()->back()->withInput();
            }
            $file = $request->file($fieldname);
            $imageName = time() . rand(10, 99) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($directory), $imageName);
            return $imageName;
        }

        return null;
    }

    public function deleteImage($directory,$filename){
        $oldImagePath = public_path($directory.$filename);

        if (file_exists($oldImagePath)) {
            unlink($oldImagePath); // Remove the old image
        }
    }
}