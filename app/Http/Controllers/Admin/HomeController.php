<?php

namespace App\Http\Controllers\Admin;

use App\Extra\MainTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{

    use MainTrait;

    public function index()
    {

        $data = [

            "nav_items"         =>   $this->params['nav_items'],
            "active_index"      =>   $this->get_active_index('dashbaord'),
            "active_page"       =>  'session',

        ];

        return Inertia::render('Admin/Pages/Home', $data);

    }

    public function sessions()
    {
        return trans('general.updated-successfully', ['type' => 'Home']);
    }

}
