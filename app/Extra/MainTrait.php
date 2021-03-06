<?php

namespace App\Extra;

trait MainTrait {

    public $params = [

        "nav_items" =>
        [

            "dashboard" => [
                "title"             =>  "Dashboard",
                "icon"              =>  "fas fa-home",
                "route"             =>  "admin-dashboard",
                "is_active"         =>  false,
                "permission"        =>  "dashboard",
                "childs"            =>  [],
            ],

            "campaign" => [
                "title"             =>  "Dashboard",
                "icon"              =>  "fas fa-building",
                "route"             =>  "admin-campaigns-index",
                "is_active"         =>  false,
                "permission"        =>  "dashboard",
                "childs"            =>  [],
            ],

            "stages" => [
                "title"             =>  "stages",
                "icon"              =>  "fas fa-building",
                "route"             =>  "admin-stages-index",
                "is_active"         =>  false,
                "permission"        =>  "dashboard",
                "childs"            =>  [],
            ],

            "plans" => [
                "title"             =>  "plans",
                "icon"              =>  "fas fa-building",
                "route"             =>  "admin-plan-index",
                "is_active"         =>  false,
                "permission"        =>  "dashboard",
                "childs"            =>  [],
            ],

            "donors" => [
                "title"             =>  "plans",
                "icon"              =>  "fas fa-building",
                "route"             =>  "admin-donors-index",
                "is_active"         =>  false,
                "permission"        =>  "dashboard",
                "childs"            =>  [],
            ],



        ]
    ];

    public function get_active_index($key)
    {

        return match($key)
        {

            'dashboard'         => 0,
            'campaigns'         => 1,
            'stages'            => 2,
            'plans'             => 3,
            'donors'            => 4,
            default             => 0,

        };

    }

    public function return_toast_result($flag, $status, $message)
    {

        return [
            "flag"      => $flag,
            "status"    => $status,
            "message"   => $message,
        ];

    }

}
