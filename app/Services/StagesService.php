<?php

namespace App\Services;

use App\Extra\MainTrait;
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


}
