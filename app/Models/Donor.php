<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table    =   'donors';

    protected $fillable =   ['name','phone','cpr','birth_day','city','gender','nationality','religion','blod_group', 'status',];

    protected $hidden   =   ['created_at', 'updated_at'];

}
