<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Campaign;
use App\Models\Disease;
use App\Models\Donor;
use App\Services\RegisterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class donorsController extends Controller
{

    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    //
    public function print_form(Request $request, $cpr)
    {


        $donor = Donor::where('cpr', $cpr)->first();
//        return dd($donor);

        echo "";

        {

            if (isset($donor)) {
                $thename = $donor->name;
                $mobile = $donor->phone;


                ?>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <style>
                    @media print {
                        .pagebreak {
                            page-break-before: always;
                        }

                        /* page-break-after works, as well */
                    }
                    @page {
                        size: auto;   /* auto is the initial value */
                        margin-top: 30px;  /* this affects the margin in the printer settings */
                        margin-bottom: 0;  /* this affects the margin in the printer settings */
                    }
                </style>
                <center>
                    <h1>حملة الرسول الأعظم (ص) للتبرع بالدم 14</h1>

                </center>

                <BR>

                <div class="container">
                    <table class="table" style="font-size:10px;">
                        <tbody>
                        <tr>
                            <td colspan=2>
                                <?php
                                echo "<div><span style=\"font-size:12px;\"><STRONG>CPR NUMBER: " . $cpr . "</STRONG></span></div>";
                                ?>
                            </td>
                            <td>Mobile Number: <?php echo $mobile; ?></td>
                        </tr>
                        <tr>
                            <td colspan=3>
                                <?php
                                echo "<div><span style=\"font-size:12px;\"><STRONG>NAME : " . $thename . "</STRONG></span></div>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Date of Birth: <?php echo $donor->birth_date; ?> </td>
                            <td></td>
                            <td>Gender: Male</td>
                        </tr>
                        </tbody>
                    </table>
                    <BR>
                    <STRONG style="font-size:12px;">Physical Examiation</STRONG>
                    <div class="well" style="background-color: white;">
                        <table class="table" style="font-size:10px;">
                            <tbody>
                            <tr>
                                <td style=" border: none;">Weight:</td>
                                <td style=" border: none;">BP:</td>
                                <td style=" border: none;text-align: center;">Pulse Rate:</td>
                            </tr>
                            <tr>
                                <td style=" border: none;text-align: right;">Fit to donate</td>
                                <td style=" border: none;text-align: center;">Yes</td>
                                <td style=" border: none;">No</td>
                            </tr>
                            <tr style="padding:0px;">
                                <td colspan=3 style="padding:0px;">
                                    <center>Staff intial:</center>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <STRONG style="font-size:12px;">Hb & BG</STRONG>
                    <div class="well" style="background-color: white;">
                        <table class="table" style="font-size:10px;">
                            <tbody>
                            <tr>
                                <td style=" border: none;">BG:</td>
                                <td style=" border: none;">Hb:</td>
                                <td style=" border: none;"></td>
                            </tr>
                            <tr>
                                <td style=" border: none;text-align: center;">Fit to donate</td>
                                <td style=" border: none;">Yes</td>
                                <td style=" border: none;">No</td>
                            </tr>
                            <tr>
                                <td style=" border: none;text-align: center;">Rapid Test</td>
                                <td style=" border: none;">Positive</td>
                                <td style=" border: none;">Negetive</td>
                            </tr>
                            <tr style="padding:0px;">
                                <td colspan=3 style="padding:0px;">
                                    <center>Staff intial:</center>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <STRONG style="font-size:12px;">BAG Preparation</STRONG>
                    <div class="well" style="background-color: white;">
                        <table class="table" style="font-size:10px;">
                            <tbody>
                            <tr>
                                <td style=" border: none;">Donor No.:</td>
                                <td style=" border: none;">Tag No.:</td>
                                <td style=" border: none;"></td>
                            </tr style="padding:0px;">
                            <td colspan=3 style="padding:0px;">
                                <center>Staff intial:</center>
                            </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <br/><br/>
                </div>
                <div class="pagebreak">
                    <div class="visible-print text-center">
                        <br>
                        <br>
                        <br>
                        <br>
                        <?php echo QrCode::size(250)->generate($cpr);
                        ?>
                        <br>
                        <center>
                            <h3>CPR:
                                <?php echo $cpr;
                                ?>
                            </h3>

                        </center>
                    </div>
                </div>


                <?php
                echo "";
                echo "<center><input type=\"submit\" onclick=\"window.print()\" class=\"btn-lg btn-success hidden-print\" value=\"طباعة البيانات\"><BR><BR>";
                echo "";
            } else {
                echo "error occured";
            }

        }

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

            // time must be in generated list & database
            if ( isset($timings['time']) )
            {

                $available = $total_donor_per_period - $donor_count->count();

                $timings[$time]['disabled'] = $available <= 0 ? true : false;

            }

        }

        $data = [

            'nationalities'     => config('nationalities'),

            'cities'            => config('cities'),

            'blood_groups'      => config('blood_groups'),

            'diseases'          => Disease::get(),

            'current_campaign'  => $current_campaign,

            'timings'           => $timings,

        ];

        return Inertia::render('Admin/Pages/Donors/Create', $data);
    }

    public function register(Request $request)
    {

        $request->validate([

            "name"              => ['required'],
            "phone"             => ['required'],
            "email"             => ['nullable', 'unique:donors,email'],
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
