<?php

namespace App\Services;

use App\Extra\MainTrait;
use App\Models\Admin\Campaign;
use App\Models\Disease;
use App\Models\DiseasesHealthHistory;
use App\Models\Donor;
use App\Models\HealthHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class RegisterService {

    use MainTrait;

    public function register_donor($donor, $selected_time, $donor_history, $diseases)
    {

        try
        {

            $result = DB::transaction(function () use ($donor, $selected_time, $donor_history, $diseases) {


                $current_campaign = Campaign::first();

                $status = 0;
                $reason_to_reject = [];

                $donor['username']      = $donor['cpr'];
                $donor['birth_date']    = Carbon::parse($donor['birth_date'])->toDateTimeLocalString();

                $donor_age = Carbon::parse($donor['birth_date'])->age;

                // calc the age -> if the age more than 55, register donor then in the history make the status rejected

                if ( $donor_age > 55 )
                {
                    $reason_to_reject[] = trans('donor-age-more-than-55');
                    $status = 2;
                }

                // last travel > 1 month
                $last_travel_period = Carbon::now()->diffInMonths($donor_history['last_travel_date']);

                if ( $last_travel_period <= 1 )
                {
                    $reason_to_reject[] = trans('donor-last-travel-less-than-1-month');
                    $status = 2;
                }

                if ( $donor['gender'] != 'male' )
                {
                    $reason_to_reject[] = trans('only-male-allowed-to-donate');
                    $status = 2;
                }

                $donor['status'] = 1;

                $new_donor = Donor::create($donor);

                // add donor to capmiagn
                $date_of_campaign = Carbon::parse($current_campaign->start_time)->toDateString();
                $time = Carbon::parse("{$date_of_campaign} {$selected_time}");

                DB::table('campaign_donors')->insert([

                    "i_campaigns"   =>  1,
                    "i_donors"      =>  $new_donor->id,
                    "status"        =>  $status,
                    "time"          =>  $selected_time == 'waiting-time' ? null : $time,

                ]);

                $donor_history['i_donors'] = $new_donor->id;

                $donor_history = HealthHistory::create($donor_history);

                foreach ( $diseases as $index => $disease )
                {

                    $diseases_to_insert = [

                        'i_health_histories'    =>  $donor_history->id,
                        'i_diseases'            =>  $disease,
                    ];

                    DiseasesHealthHistory::create($diseases_to_insert);

                }

                return [

                    'status' => $status,
                    'reason_to_reject'  => $reason_to_reject,

                ];

            });

            // rejected
            if ( $result['status'] == 2 )
            {

                $reason_to_reject_string = implode(', ', $result['reason_to_reject']);

                return $this->return_toast_result(false, 'warning', $reason_to_reject_string);

            }

            return $this->return_toast_result(false, 'success', trans('added-successfully', ['type' => trans('donor')]));

        }
        catch(Exception $ex)
        {

            dd($ex);
            return $this->return_toast_result(false, 'danger', 'something error');
        }
        /**
         * calc the age -> if the age more than 55, register donor then in the history make the status rejected
         * last travel > 1 month
         * last donation > 3 month
         * male only, if female register and make the status rejected
         *
         * if accepted, the status will be 'accepted'

        */


    }

}
