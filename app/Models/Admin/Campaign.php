<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{

    // use SoftDeletes;

    use HasFactory;

    protected $table    =   'campaigns';

    protected $fillable =   ['name','location','description','logo','status','total_donor','donor_per_period','registration_status','i_societies', 'start_time', 'end_time',];

    protected $hidden   =   ['created_at', 'updated_at'];

    protected $dates    =   ['start_time', 'end_time'];

    protected $appends  =   ['logo_url'];

    // public function society()
    // {
    //     return $this->belongsTo('')
    // }

    public function scopeSociety($query, $scope_id)
    {
        return $query->where('i_societies', $scope_id);
    }

    public function getLogoUrlAttribute()
    {

        if ( $this->logo )
        {
            return asset('storage/' . $this->logo);
        }

        return null;

    }

}
