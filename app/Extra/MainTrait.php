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

            "sessions" => [
                "title"             =>  "Dashboard",
                "icon"              =>  "fas fa-home",
                "route"             =>  "admin-dashboard",
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
            'sessions'          => 1,
            'user-management'   => 2,
            'settings'          => 3,
            default             => 0,

        };

    }

}
