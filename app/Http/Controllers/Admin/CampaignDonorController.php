<?php

namespace App\Http\Controllers\Admin;

use App\Extra\MainTrait;
use App\Http\Controllers\Controller;
use App\Services\DonorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CampaignDonorController extends Controller
{

    use MainTrait;

    private $donorService;

    public function __construct(DonorService $donorService)
    {
        $this->donorService = $donorService;
    }

    public function index(Request $request)
    {

        // abort_unless(can_do('list-dictionaries'), 403);

        // $this->render_nav_items_permissions();

        $term = $request->input('term');

        $donors = $this->donorService->get_all_donors_with_search($term, ['*']);

        if ( $donors == 'error' )
        {

            return Redirect::route('admin-donors-index');

        }

        $data = [

            "donors"             =>  $donors,

            "nav_items"             =>  $this->params['nav_items'],

            "active_page"           =>  "donors",

            "active_index"          =>  $this->get_active_index('donors'),

            "term"                  =>  $term,

            // "needed_permissions"    =>  $this->generate_needed_permissions(['create-dictionary', 'update-dictionary', 'delete-dictionary', 'enable-dictionary']),

            // "breadcrumb"            =>  $this->generate_breadcrumb('dictionaries-index'),

        ];

        // return $donors;

        return Inertia::render('Admin/Pages/Donors/Index', $data);


    }

    public function update_status(Request $request)
    {

        $result     = $this->donorService->update_campaign_donor_status($request->donor_id, $request->status);

        return Redirect::back()->with('toast', $result);

    }

}
