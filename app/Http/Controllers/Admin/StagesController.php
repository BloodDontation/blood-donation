<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Extra\MainTrait;
use App\Services\StagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StagesController extends Controller
{

    use MainTrait;

    private $StagesService;

    public function __construct(StagesService $StagesService)
    {
        $this->StagesService = $StagesService;
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
}
