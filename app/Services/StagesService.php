<?php

namespace App\Services;

use App\Extra\MainTrait;
use App\Models\Admin\Donor_stages;
use App\Models\Admin\Plan_stages;
use App\Models\Admin\Stage;
use Exception;

class StagesService {

    use MainTrait;

    public function get_all_Stages_with_search($campaigns_id, $term = '', $columns = ['*'])
    {

        try
        {
            return Stage::select($columns)->Campaign($campaigns_id)->paginate(10);
        }
        catch(Exception $ex)
        {
            return 'error';
        }

    }

    public function get_all_Stages($campaigns_id, $term = '', $columns = ['*'])
    {

        try
        {
            return Stage::select($columns)->Campaign($campaigns_id)->get();
        }
        catch(Exception $ex)
        {
            return 'error';
        }

    }

    public function add_new_stage($new_stage)
    {

        try
        {

            $new_stage['i_campaigns']    = 1;
            $new_stage                   = Stage::create($new_stage);

            return [

                'stage_id'   => $new_stage->id,

                'toast'         => $this->return_toast_result(true,  'success', trans('general.added-successfully', ['type' => 'campaign'])),

            ];

        }
        catch(Exception $ex)
        {

            return [

                'stage_id'   => -1,

                'toast'         => $this->return_toast_result(false,  'danger', trans('general.something-error')),

            ];

        }

    }

    public function get_stage_of_donor($plan_id, $term = '', $columns = ['*'])
    {

        try
        {
            return Donor_stages::select($columns)->Donor($plan_id)->orderBy('position')->get();
        }
        catch(Exception $ex)
        {
            return 'error';
        }

    }



}
