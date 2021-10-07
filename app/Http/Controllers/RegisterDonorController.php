<?php

namespace App\Http\Controllers;

use App\Models\Admin\Campaign;
use App\Models\Disease;
use App\Services\RegisterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RegisterDonorController extends Controller
{

    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register_form()
    {

        $current_campaign = Campaign::first();

        $different = Carbon::parse($current_campaign->start_time)->diffInMinutes($current_campaign->end_time);

        $current_time = 0;

        $timings = [];

        for ( $current_time = 0; $current_time <= $different; $current_time += 30 )
        {

            $timings[Carbon::parse($current_campaign->start_time)->addMinutes($current_time)->toTimeString()] = [

                'time'              =>  Carbon::parse($current_campaign->start_time)->addMinutes($current_time)->toTimeString(),
                'disabled'      =>  false,

            ];

        }

        $timings['waiting-time'] = [

            'time'              =>  trans('waiting-time'),
            'disabled'   =>  false,

        ];

        // get available times
        $all_donors_in_campaign = DB::table('campaign_donors')
        ->where('i_campaigns', $current_campaign->id)
        ->where('status', '!=', 2)
        ->get()
        ->transform(function($time) {

            $time->time = Carbon::parse($time->time)->toTimeString();

            return $time;

        })
        ->groupBy('time')
        ;

        $total_donor_per_period = $current_campaign->donor_per_period;

        foreach ( $all_donors_in_campaign as $time => $donor_count )
        {

            $available = $total_donor_per_period - $donor_count->count();

            $timings[$time]['disabled'] = $available <= 0 ? true : false;


        }

        // dd($timings);

        $data = [

            'nationalities'     => config('nationalities'),

            'cities'            => config('cities'),

            'blood_groups'      => config('blood_groups'),

            'diseases'          => Disease::get(),

            'current_campaign'  => $current_campaign,

            'timings'           => $timings,

        ];

        return Inertia::render('Donor/Register', $data);

    }

    public function register(Request $request)
    {

        $request->validate([

            "name"              => ['required'],
            "phone"             => ['required'],
            "email"             => ['required', 'unique:donors,email'],
            "cpr"               => ['required', 'unique:donors,cpr'],
            "birth_date"        => ['required'],
            "city"              => ['required'],
            "gender"            => ['required'],
            "nationality"       => ['required'],
            "blod_group"        => ['required'],

            'last_travel_date'  => ['required', 'date'],
            'has_green_shield'  => ['required', ],

            'selected_time'     => ['required'],


        ]);

        $donor          = $request->only(['username','password','name','phone','email','cpr','birth_date','city','gender','nationality','religion','blod_group','status']);

        $selected_time  = $request->selected_time;

        $donor_history  = $request->only(['last_travel_date']);

        $diseases       = $request->diseases;

        // $reg
        $result = $this->registerService->register_donor($donor, $selected_time, $donor_history, $diseases);

        return Redirect::back()->with('toast', $result);

    }

}
