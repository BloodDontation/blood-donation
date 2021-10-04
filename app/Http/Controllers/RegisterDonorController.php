<?php

namespace App\Http\Controllers;

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

        ];

        return Inertia::render('Donor/Register', $data);

    }

    public function register(Request $request)
    {

        return $request;

    }

}
