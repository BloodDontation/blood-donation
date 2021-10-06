<?php

namespace App\Http\Controllers\Admin;

use App\Extra\MainTrait;
use App\Http\Controllers\Controller;
use App\Models\Admin\Plan_stages;
use App\Models\Admin\Plans;
use App\Services\PlanService;
use App\Services\StagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PlanController extends Controller
{

    use MainTrait;

    private $PlanService;
    private $StagesService;


    public function __construct(PlanService $PlanService, StagesService $StagesService)
    {
        $this->PlanService = $PlanService;
        $this->StagesService = $StagesService;

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


    public function create(Request $request)
    {

        $data = [

            "nav_items" => $this->params['nav_items'],

            "active_page" => "Create plans",

            "active_index" => $this->get_active_index('plans'),

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        return Inertia::render('Admin/Pages/Plan/Create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);
        $new_plan_name = $request->only(['name']);
//        return $new_plan_name;
        $new_plan_name['i_campaigns'] = 1;

        $new_plan = Plans::create($new_plan_name);

        $term = $request->input('term');


        $Stages = $this->StagesService->get_all_Stages(1, $term, ['*']);

        if ($Stages == 'error') {

            return Redirect::route('admin-plan-index');

        }
        $i=1;
        foreach ($Stages as $stage) {
            $stage_plan = new Plan_stages();
            $stage_plan->i_stages = $stage->id;
            $stage_plan->i_plans = $new_plan->id;
            $stage_plan->position = $i;
            $stage_plan->save();
            $i++;
        }


        return Redirect::route('admin-plan-edit', ['id' => $new_plan->id]);


    }

    public function edit(Request $request, $id)
    {

        // abort_unless(can_do('list-dictionaries'), 403);

        // $this->render_nav_items_permissions();

        $term = $request->input('term');

        $Stages = $this->PlanService->get_stage_of_plan($id, $term, ['*']);

        if ($Stages == 'error') {

            return Redirect::route('admin-plan-index');

        }

        $data = [

            "stages" => $Stages,

            "nav_items" => $this->params['nav_items'],

            "active_page" => "Edit plan stages",

            "active_index" => $this->get_active_index('stages'),

            "term" => $term,
            "id" => $id,

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        return Inertia::render('Admin/Pages/Plan/Edit', $data);

    }

    public function position(Request $request, $id){

        $Stages = $this->PlanService->get_stage_of_plan($id, "", ['*']);
//        return dd($Stages);


        foreach ($Stages as $Stage) {
            $Stage->timestamps = false;
            $id1 = $Stage->i_stages;
            foreach ($request->stages as $stages_order) {
                if ($stages_order['i_stages'] == $id1) {
//                    $Stage->update(['position' => $stages_order['position']]);
//                    $Stage->save();
                    Plan_stages::where('i_stages',$id1)
                        ->where('i_plans', $id)
                        ->update(['position' => $stages_order['position']]);
                }
            }
        }


        return response('Update Successful.', 200);

    }



}
