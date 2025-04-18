<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'audit_name', 
        'auditee_name',
        'date',
        'attachment',
        'client_id',
        'hazmat_company_id'
    ];
}
