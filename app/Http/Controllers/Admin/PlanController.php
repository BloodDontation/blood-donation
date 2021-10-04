<?php

namespace App\Http\Controllers\Admin;

use App\Extra\MainTrait;
use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PlanController extends Controller
{

    use MainTrait;

    private $PlanService;

    public function __construct(PlanService $PlanService)
    {
        $this->PlanService = $PlanService;
    }

    public function index(Request $request)
    {

        $term = $request->input('term');

        $plans = $this->PlanService->get_all_Plans_with_search(1, $term, ['*']);

        if ($plans == 'error') {

            return Redirect::route('admin-plan-index');

        }

        $data = [

            "plans" => $plans,

            "nav_items" => $this->params['nav_items'],

            "active_page" => "plans",

            "active_index" => $this->get_active_index('plans'),

            "term" => $term,

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        return Inertia::render('Admin/Pages/Plan/Index', $data);


    }


}
