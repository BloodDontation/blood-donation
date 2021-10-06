<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthHistory extends Model
{

    use HasFactory;

    protected $table    =   'health_histories';

    protected $fillable =   ['last_travel', 'last_donate', 'i_donors'];

    protected $hidden   =   ['created_at', 'updated_at'];

}
