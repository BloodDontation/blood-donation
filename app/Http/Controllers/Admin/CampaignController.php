<?php

namespace App\Http\Controllers\Admin;

use App\Extra\MainTrait;
use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CampaignController extends Controller
{

    use MainTrait;

    private $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index(Request $request)
    {

        // abort_unless(can_do('list-dictionaries'), 403);

        // $this->render_nav_items_permissions();

        $term = $request->input('term');

        $campaigns = $this->campaignService->get_all_campaigns_with_search(1, $term, ['*']);

        if ( $campaigns == 'error' )
        {

            return Redirect::route('admin-campaign-index');

        }

        $data = [

            "campaigns"             =>  $campaigns,

            "nav_items"             =>  $this->params['nav_items'],

            "active_page"           =>  "campaigns",

            "active_index"          =>  $this->get_active_index('campaigns'),

            "term"                  =>  $term,

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        return Inertia::render('Admin/Pages/Campaigns/Index', $data);

    }

    public function create()
    {

        // abort_unless(can_do('list-dictionaries'), 403);

        // $this->render_nav_items_permissions();

        $data = [

            "nav_items"             =>  $this->params['nav_items'],

            "active_page"           =>  "campaigns",

            "active_index"          =>  $this->get_active_index('campaigns'),

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        return Inertia::render('Admin/Pages/Campaigns/Create', $data);

    }

    public function edit($id)
    {

        // abort_unless(can_do('list-dictionaries'), 403);

        // $this->render_nav_items_permissions();

        $campaign = $this->campaignService->get_campaign_by_id_for_edit($id);

        if ( !$campaign )
        {

            return Redirect::back()->with('toast', $this->return_toast_result(false, 'warning', 'not-found'));

        }

        $data = [

            "nav_items"             =>  $this->params['nav_items'],

            "active_page"           =>  "campaigns",

            "active_index"          =>  $this->get_active_index('campaigns'),

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

            "campaign"              =>  $campaign,

        ];

        return Inertia::render('Admin/Pages/Campaigns/Edit', $data);

    }

    public function store(Request $request)
    {

        // if ( !can_do('create-account') )
        // {

        //     return Redirect::back()->with('toast', $this->return_toast_result(false, 'warning', 'no-permission'));

        // }

        $request->validate([

            'name'                  =>  ['required'],
            'location'              =>  ['required'],
            'start_time'            =>  ['required'],
            'end_time'              =>  ['required'],
            'total_donor'           =>  ['required', 'numeric', 'min:1'],
            'donor_per_period'      =>  ['required', 'numeric',],
            'logo'                  =>  ['mimes:jpeg,png,jpg','max:1024'],

        ]);

        $new_campaign   = $request->only(['name', 'location', 'start_time', 'end_time', 'total_donor', 'donor_per_period', 'status', 'registration_status']);

        $logo           = $request->logo;

        $result         = $this->campaignService->add_new_campaign($new_campaign, $logo);

        if ( $result['campaign_id'] != -1 )
        {

            return Redirect::route('admin-campaigns-index',)->with('toast', $result['toast']);

        }

        return Redirect::back()->with('toast',$result['toast']);

    }

    public function update(Request $request)
    {

        $validation_array = [

            'name'                  =>  ['required'],
            'location'              =>  ['required'],
            'start_time'            =>  ['required'],
            'end_time'              =>  ['required'],
            'total_donor'           =>  ['required', 'numeric', 'min:1'],
            'donor_per_period'        =>  ['required', 'numeric',],

        ];

        if ( $request->logo instanceof \Illuminate\Http\UploadedFile )
        {

            $validation_array['logo'] = ['mimes:jpeg,png,jpg','max:1024'];

        }

        $request->validate($validation_array);

        $campaign   = $request->only(['id', 'name', 'location', 'start_time', 'end_time', 'total_donor', 'donor_per_period', 'status', 'registration_status']);

        $logo       = $request->logo;

        $result     = $this->campaignService->update_campaign($campaign, $logo);

        return Redirect::back()->with('toast', $result);

    }

}
