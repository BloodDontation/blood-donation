<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    use HasFactory;

    protected $table    =   'plans';

    protected $fillable =   ['name','i_campaigns',];

    protected $hidden   =   ['created_at', 'updated_at'];


    public function scopeCampaign($query, $scope_id)
    {
        return $query->where('i_campaigns', $scope_id);
    }

}
