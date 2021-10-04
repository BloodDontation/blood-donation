<?php

namespace App\Services;

use App\Extra\MainTrait;
use App\Models\Admin\Plan_stages;
use App\Models\Admin\Plans;
use App\Models\Admin\Stage;
use Exception;

class PlanService {

    use MainTrait;


    public function get_all_Plans_with_search($campaigns_id, $term = '', $columns = ['*'])
    {

        try
        {
            return Plans::select($columns)->Campaign($campaigns_id)->paginate(10);
        }
        catch(Exception $ex)
        {
            return 'error';
        }

    }


    public function get_stage_of_plan($plan_id, $term = '', $columns = ['*'])
    {

        try
        {
            return Plan_stages::select($columns)->Plan($plan_id)->orderBy('position')->paginate(10);
        }
        catch(Exception $ex)
        {
            return 'error';
        }

    }

}
