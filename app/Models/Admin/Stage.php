<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    // use SoftDeletes;

    use HasFactory;

    protected $table    =   'stages';

    protected $fillable =   ['name','description','type','prerequisite','i_campaigns',];

    protected $hidden   =   ['created_at', 'updated_at'];

    // public function society()
    // {
    //     return $this->belongsTo('')
    // }

    public function scopeCampaign($query, $scope_id)
    {
        return $query->where('i_campaigns', $scope_id);
    }

}
