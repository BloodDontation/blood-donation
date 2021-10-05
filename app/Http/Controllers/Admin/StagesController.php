<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Extra\MainTrait;
use App\Models\Admin\Stage;
use App\Models\Donor;
use App\Services\PlanService;
use App\Services\StagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StagesController extends Controller
{

    use MainTrait;

    private $StagesService;
    private $PlanService;

    public function __construct(StagesService $StagesService, PlanService $PlanService)
    {
        $this->StagesService = $StagesService;
        $this->PlanService = $PlanService;
    }

    public function index(Request $request)
    {

        // abort_unless(can_do('list-dictionaries'), 403);

        // $this->render_nav_items_permissions();

        $term = $request->input('term');

        $Stages = $this->StagesService->get_all_Stages_with_search(1, $term, ['*']);

        if ($Stages == 'error') {

            return Redirect::route('admin-Stages-index');

        }

        $data = [

            "stages" => $Stages,

            "nav_items" => $this->params['nav_items'],

            "active_page" => "stages",

            "active_index" => $this->get_active_index('stages'),

            "term" => $term,

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        return Inertia::render('Admin/Pages/Stages/Index', $data);

    }

    public function create()
    {

        // abort_unless(can_do('list-dictionaries'), 403);

        // $this->render_nav_items_permissions();
        $stages = $this->StagesService->get_all_Stages(1, '', ['id', 'name']);

        $data = [

            "nav_items" => $this->params['nav_items'],

            "active_page" => "stages",

            "active_index" => $this->get_active_index('campaigns'),

            "stages1" => $stages,

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        return Inertia::render('Admin/Pages/Stages/Create', $data);

    }


    public function store(Request $request)
    {

        // if ( !can_do('create-account') )
        // {

        //     return Redirect::back()->with('toast', $this->return_toast_result(false, 'warning', 'no-permission'));

        // }

        $request->validate([

            'name' => ['required'],
            'type' => ['required'],
            'description' => ['required'],


        ]);

        $new_stage = $request->only(['name', 'prerequisite', 'description', 'type']);


        $result = $this->StagesService->add_new_stage($new_stage);

        if ($result['stage_id'] != -1) {

            return Redirect::route('admin-stages-index')->with('toast', $result['toast']);

        }

        return Redirect::back()->with('toast', $result['toast']);

    }


    public function interStage(Request $request)
    {
        $request->validate([
            'cpr' => ['required'],
            'stage_id' => ['required'],
        ]);

        $cpr = $request->input("cpr");
        $stage_id = $request->input("stage_id");

        $stage=Stage::find($stage_id);
        $donor = Donor::where('cpr', $cpr)->first();
        $plans = $this->PlanService->get_all_Plans_with_search(1);
        $donor_stage = (array)$this->StagesService->get_stage_of_donor($donor->id);
        foreach ($plans as $plan) {
            $plan_stage = $this->PlanService->get_stage_of_plan($plan->id);
//            return dd($plan_stage);
            $length = count($donor_stage);
            $match = true;
            for ($i = 1; $i <= $length; $i++) {
                if ($i < $length) {
                    if ($plan_stage[$i]->id != $donor_stage[$i]->id) {
                        break;
                    }
                } elseif (isset($stage->type) && $i == $length) {
                    if(isset($stage->type) &&$stage->type=="Optioninal"){

                        return "direct insert";
                    }else{
                        if ($plan_stage[0]->id != $stage_id) {
                            break;
                            $match = false;
                        } else {
                            return "match ";
                        }
                    }



                }

            }

        }
        return "exit";
    }


}
