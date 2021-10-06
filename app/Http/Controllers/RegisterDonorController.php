<?php

namespace App\Http\Controllers;

use App\Models\Admin\Campaign;
use App\Models\Disease;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegisterDonorController extends Controller
{

    public function register_form()
    {

        $data = [

            'nationalities' => config('nationalities'),

            'cities'        => config('cities'),

            'blood_groups'  => config('blood_groups'),

            'diseases'      => Disease::get(),

            'current_campaign' => Campaign::first(),

        ];

        return Inertia::render('Donor/Register', $data);

    }

    public function register(Request $request)
    {

        /*
            check the age (below 55) {calculate from the date of birth}

        */

        // all fields are required
        // cpr unique

        // diases not required

        $request->validate([



        ]);

        // $reg

        return $request;

    }

}
