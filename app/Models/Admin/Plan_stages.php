<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan_stages extends Model
{
    use HasFactory;

    protected $table    =   'plan_stages';

    protected $fillable =   ['i_stages','i_plans','position'];

    protected $hidden   =   ['created_at', 'updated_at'];

    public function scopePlan($query, $scope_id)
    {
//        return $query->where('i_plans', $scope_id);
        return $query->where('i_plans',$scope_id)->join('stages', 'plan_stages.i_stages', '=', 'stages.id');
    }

    public function stages()
    {
        return $this->hasOne(Plans::class, 'i_stages');
    }
}
