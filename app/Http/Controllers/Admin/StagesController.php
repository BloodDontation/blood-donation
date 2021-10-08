<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Extra\MainTrait;
use App\Models\Admin\Donor_stages;
use App\Models\Admin\Stage;
use App\Models\Donor;
use App\Services\PlanService;
use App\Services\smsService;
use App\Services\StagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StagesController extends Controller
{

    use MainTrait;

    private $StagesService;
    private $PlanService;
    private $smsService;

    public function __construct(StagesService $StagesService, PlanService $PlanService, smsService $smsService)
    {
        $this->StagesService = $StagesService;
        $this->PlanService = $PlanService;
        $this->smsService = $smsService;
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

        $stage = Stage::find($stage_id);
        $donor = Donor::where('cpr', $cpr)->first();
        $plans = $this->PlanService->get_all_Plans_with_search(1);
        $donor_stage = $this->StagesService->get_stage_of_donor($donor->id)->where('type', 'Required')->toArray();
        $donor_stage = array_values($donor_stage);

        foreach ($plans as $plan) {
            $plan_stage = $this->PlanService->get_stage_of_plan($plan->id)->where('type', 'Required')->toArray();
            $plan_stage = array_values($plan_stage);
//            return dd($donor_stage);
            $length = count($donor_stage);
            $match = true;
            for ($i = 0; $i <= $length; $i++) {
                $check_exist = Donor_stages::where("i_donors", $donor->id)->where("i_stages", $stage_id)->get()->toArray();
                if (count($check_exist) != 0) {
                    break 2;
                }

                if ($i < $length) {
                    if ($plan_stage[$i]['id'] != $donor_stage[$i]['id']) {
                        break;
                    }
                } elseif (isset($stage->type) && $i == $length) {
                    if (isset($stage->type) && $stage->type == "Optioninal") {
                        if (count($check_exist) == 0) {
                            if ($length != 0) {
                                $last = Donor_stages::where('i_donors', $donor->id)->orderBy('created_at', 'desc')->first();
                                $last->end_time = date('Y-m-d H:i:s', strtotime("now"));
                                $last->save();
                            }

                            Donor_stages::create([
                                'i_donors' => $donor->id,
                                'i_stages' => $stage_id,
                                'start_time' => date('Y-m-d H:i:s', strtotime("now"))
                            ]);
                            return "Inserted";
                        }

                    } else {
                        if (count($plan_stage) >= count($donor_stage)) {
                            if ($plan_stage[$i]['id'] != $stage_id) {
                                break;
                            } else {
                                if ($length != 0) {
                                    $last = Donor_stages::where('i_donors', $donor->id)->orderBy('created_at', 'desc')->first();
                                    $last->end_time = date('Y-m-d H:i:s', strtotime("now"));
                                    $last->save();
                                }

                                Donor_stages::create([
                                    'i_donors' => $donor->id,
                                    'i_stages' => $stage_id,
                                    'start_time' => date('Y-m-d H:i:s', strtotime("now"))
                                ]);

                                if ($stage->is_exit) {
                                    $this->smsService->send_sms($donor, 'exit_message', [
                                        'name' => $donor->name
                                    ]);

                                    $this->smsService->send_sms($donor, 'quality_form', [
                                        'name' => $donor->name
                                    ]);
                                    return "Completed";
                                }
                                return "Inserted";
                            }
                        }

                    }


                }

            }

        }
        return "Exit";
    }


}
