<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms_email_templates extends Model
{
    use HasFactory;

    protected $table    =   'sms_email_templates';

    protected $fillable =   ["name", "action", "subject", "email_body", "sms_body", "short_codes", "email_status", "sms_status", "i_societies"];

    protected $hidden   =   ['created_at', 'updated_at'];
}
