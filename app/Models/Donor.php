<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{

    // use SoftDeletes;

    use HasFactory;

    protected $table    =   'donors';

    protected $fillable =   ["username", "password", "name", "phone", "email", "cpr", "birth_date", "city", "gender", "nationality", "religion", "blod_group", "status"];

    protected $hidden   =   ['created_at', 'updated_at'];

    public function campaign_donor()
    {
        return $this->belongsToMany('\App\Models\Admin\Campaign', 'campaign_donors', 'i_donors', 'i_campaigns');
    }

}
