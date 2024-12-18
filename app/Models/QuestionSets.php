<?php

namespace App\Models;
use Illuminate\Support\Facades\File;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSets extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_name',
        'training_sets_id',
        'answer_type',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer'
    ];
    protected static function boot()
    {
        parent::boot();

        // Attach an event listener for the "updating" event
        static::updating(function ($model) {
            // Check if files are being updated and delete old files
            $model->removeOldFiles($model);
        });

        static::creating(function ($model) {
            // Handle file uploads during record creation
            $model->handleFileUploads($model);
        });

        static::deleting(function ($model) {
            $model->deleteImages();
        });
    }
    
    public function removeOldFiles($model)
    {
        $fields = ['option_a', 'option_b', 'option_c', 'option_d'];

        foreach ($fields as $field) {
            // Check if the field has changed
            if ($model->isDirty($field)) {
                // Get the old file name
                $oldFile = $model->getOriginal($field);

                // If an old file exists, delete it
                if ($oldFile && File::exists(public_path('uploads/trainingRecored/' . $oldFile))) {
                    File::delete(public_path('uploads/trainingRecored/' . $oldFile));
                }
                if ($model->{$field} instanceof \Illuminate\Http\UploadedFile) {
                    $model->{$field} = $this->uploadFile($model->{$field}, $field, $model->id);
                }
            
            }
        }
    }
    private function uploadFile($file, $prefix, $id)
    {
        $filename = time() . "_{$prefix}_" . $id . "." . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/trainingRecored/'), $filename);
        return $filename;
    }
    public function handleFileUploads($model)
    {
        $fields = ['option_a', 'option_b', 'option_c', 'option_d'];

        foreach ($fields as $field) {
            // If the field contains a file, upload it
            if ($model->{$field} instanceof \Illuminate\Http\UploadedFile) {
                $model->{$field} = $this->uploadFile($model->{$field}, $field, $model->id);
            }
        }
    }
    public function deleteImages()
    {
        $fields = ['option_a', 'option_b', 'option_c', 'option_d'];

        foreach ($fields as $field) {
            // Check if the file exists and delete it
            if ($this->{$field} && File::exists(public_path('uploads/trainingRecored/' . $this->{$field}))) {
                File::delete(public_path('uploads/trainingRecored/' . $this->{$field}));
            }
        }
    }   


}
