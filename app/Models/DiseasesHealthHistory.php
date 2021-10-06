<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseasesHealthHistory extends Model
{

    use HasFactory;

    protected $table    =   'diseases_health_histories';

    protected $fillable =   ['i_health_histories', 'i_diseases'];

    protected $hidden   =   ['created_at', 'updated_at'];

}
