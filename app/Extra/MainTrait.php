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



        ]
    ];

    public function get_active_index($key)
    {

        return match($key)
        {

            'dashboard'         => 0,
            'campaigns'         => 1,
            'user-management'   => 2,
            'settings'          => 3,
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
