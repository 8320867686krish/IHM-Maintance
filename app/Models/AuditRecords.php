<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AuditRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'attachment',
        'client_company_id',
        'hazmat_companies_id'
    ];
    public static function updateOrCreateWithFile($id, array $data, UploadedFile $file = null)
    {
        $record = self::find($id) ?? new self();

        $record->fill($data);

        if ($file) {
            $record->handleFileUpload($file);
        }

        $record->save();

        return $record;
    }

    public function handleFileUpload(UploadedFile $file)
    {
        // Delete old file if exists
        if ($this->attachment) {
            $oldPath = "uploads/auditrecords/{$this->client_company_id}/{$this->attachment}";
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Save new file
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = "uploads/auditrecords/{$this->client_company_id}";
        Storage::disk('public')->putFileAs($path, $file, $filename);
        $this->attachment = $filename;
    }
    public static function deleteWithAttachment($id)
    {
        $record = self::find($id);

        if ($record) {
            $record->deleteAttachmentFile();
            $record->delete();
        }
    }

    public function deleteAttachmentFile()
    {
        if ($this->attachment) {
            $path = "uploads/auditrecords/{$this->client_company_id}/{$this->attachment}";
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
