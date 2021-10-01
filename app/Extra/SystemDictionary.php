<?php

namespace App\Extra;

use Exception;

class SystemDictionary {

    public const DICTIONARY = [

        'en'    =>  [


            'added-successfully'    =>  ':type Added Successfully',
            'updated-successfully'  =>  ':type Updated Successfully',

            'dashboard'             =>  'Dashboard',
            'session'               =>  'Session',

        ],

        'ar'    =>  [

            'updated-successfully'  =>  'تم  تحديث :type بنجاح',
            'added-successfully'    =>  'تم إضافة :type بنجاح',

            'dashboard'             =>  'لوحة التحكم',
            'session'               =>  'تحويل',

        ]


    ];

    public static function trans($key, $language = 'en', $params = [])
    {

        try
        {

            $translate = self::DICTIONARY[$language][$key];

            foreach ( $params as $param => $value )
            {

                $translate = str_replace( $param, $value, $translate);

            }

            return $translate;

        }
        catch(Exception $ex)
        {
            return $key;
        }


    }

}
