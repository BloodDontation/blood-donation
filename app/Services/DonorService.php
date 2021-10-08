<?php

namespace App\Services;

use App\Extra\MainTrait;
use App\Models\Admin\Campaign;
use App\Models\Donor;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class DonorService {

    use MainTrait;

    public function get_all_donors_with_search($term = '', $columns = ['*'])
    {

        try
        {

            return Donor::select($columns)->when($term != null, function($query) use ($term) {

                return $query->where('name', 'like', "%{$term}%")
                ->orWhere('cpr', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");

            })
            ->with([
                'campaign_donor' => function($query) {

                    return $query->select(['campaign_donors.time', 'campaign_donors.status']);

                },
            ])
            ->orderBy('id', 'desc')
            ->get();

        }
        catch(Exception $ex)
        {
            return 'error';
        }

    }

    public function update_campaign_donor_status($donor_id, $status)
    {

        try
        {

            DB::table('campaign_donors')->where('i_campaigns', 1)->where('i_donors', $donor_id)->update([
                'status' => $status
            ]);

            return $this->return_toast_result(true,  'success', trans('updated-successfully', ['type' => trans('status')]));

        }
        catch(Exception $ex)
        {
            return $this->return_toast_result(false,  'danger', trans('general.something-error'));
        }


    }

    public function get_campaign_by_id_for_edit($id, $columns = ['*'])
    {
        return Campaign::select($columns)->find($id);
    }

    public function add_new_campaign($new_campaign, $logo = null)
    {

        try
        {

            $new_campaign['i_societies']    = 1;

            if ( $logo )
            {

                $logo_path                      = (new MediaUploadService())->upload_new_file($logo, 'donors');

                $new_campaign['logo']           = $logo_path;

            }

            $new_campaign                       = Campaign::create($new_campaign);

            return [

                'campaign_id'   => $new_campaign->id,

                'toast'         => $this->return_toast_result(true,  'success', trans('general.added-successfully', ['type' => 'campaign'])),

            ];

        }
        catch(Exception $ex)
        {

            return [

                'campaign_id'   => -1,

                'toast'         => $this->return_toast_result(false,  'danger', trans('general.something-error')),

            ];

        }

    }

    public function update_campaign($campaign, $logo = null)
    {

        try
        {

            $campaign['i_societies']    = 1;

            if ( $logo instanceof \Illuminate\Http\UploadedFile )
            {

                // todo: delete old logo

                $logo_path                      = (new MediaUploadService())->upload_new_file($logo, 'donors');

                $campaign['logo']               = $logo_path;

            }

            Campaign::find($campaign['id'])->update($campaign);

            return $this->return_toast_result(true,  'success', trans('general.updated-successfully', ['type' => 'campaign']));

        }
        catch(Exception $ex)
        {

            return $this->return_toast_result(false, 'danger', trans('general.something-error'));

        }

    }



}
