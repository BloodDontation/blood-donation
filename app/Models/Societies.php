<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societies extends Model
{
    use HasFactory;

    protected $table    =   'societies';

    protected $fillable =   ["name", "logo", "city", "sms_config", "email_config", "email_template", "phone"];

    protected $hidden   =   ['created_at', 'updated_at'];

}
