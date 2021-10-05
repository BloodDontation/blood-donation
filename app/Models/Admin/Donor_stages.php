<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor_stages extends Model
{
    use HasFactory;

    protected $table    =   'donor_stages';

    protected $fillable =   ['i_donors','i_plans','information','start_time','end_time'];

    protected $hidden   =   ['created_at', 'updated_at'];


    public function scopeDonor($query, $scope_id)
    {
        return $query->where('i_donors',$scope_id)->join('stages', 'plan_stages.i_stages', '=', 'stages.id');
    }

    public function stages()
    {
        return $this->hasOne(Plans::class, 'i_stages');
    }
}
