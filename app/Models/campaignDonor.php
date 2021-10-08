<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campaignDonor extends Model
{

    use HasFactory;

    protected $table    =   'campaign_donors';

    protected $fillable =   ['i_campaigns', 'i_donors', 'status', 'time'];

    protected $hidden   =   ['created_at', 'updated_at'];

    public function getTimeAttribute($value)
    {
        return Carbon::parse($value)->toTimeString();
    }


}
