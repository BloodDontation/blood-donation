<?php

namespace App\Services;

use App\Extra\MainTrait;
use App\Models\Admin\Campaign;
use Exception;

class CampaignService {

    use MainTrait;

    public function get_all_campaigns_with_search($society_id, $term = '', $columns = ['*'])
    {

        try
        {
            return Campaign::select($columns)->society($society_id)->paginate(10);
        }
        catch(Exception $ex)
        {
            return 'error';
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

                $logo_path                      = (new MediaUploadService())->upload_new_file($logo, 'campaigns');

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

                $logo_path                      = (new MediaUploadService())->upload_new_file($logo, 'campaigns');

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
