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

            'register-donor'        =>  'Register Donor',

            'not-available'         =>  'Not Available',

            'name'                  => 'Name',
            'cpr'                   => 'CPR',
            'date-of-birth'         => 'Date of Birth',
            'gender'                => 'Gender',
            'phone'                 => 'Phone',
            'email'                 => 'Email',
            'nationality'           => 'Nationality',
            'city'                  => 'City',
            'blood-group'           => 'Blood Group',
            'diseases'              => 'Diseases',
            'last-travel-date'      => 'Last Travel Date',
            'last-donate-date'      => 'Last Donate Date',
            'time'                  => 'Time',
            'has-green-shield'      => 'Do you have the covid green shield?',
            'regiter'               => 'Register',

            'donor-age-more-than-55' => 'Donor Age More Than 55',
            'donor-last-travel-less-than-1-month' => 'Donor last travel less than 1 month',
            'only-male-allowed-to-donate' => 'Only male allowed to donate',
            'donor' => 'Donor',
        ],

        'ar'    =>  [

            'updated-successfully'  =>  'تم  تحديث :type بنجاح',
            'added-successfully'    =>  'تم إضافة :type بنجاح',

            'dashboard'             =>  'لوحة التحكم',
            'session'               =>  'تحويل',

            'register-donor'        =>  'تسجيل المتبرع',

            'not-available'         =>  'غير متوفر',

            'name'                  => 'الإسم',
            'cpr'                   => 'الرقم الشخصي',
            'date-of-birth'         => 'تاريخ الميلاد',
            'gender'                => 'الجنس',
            'phone'                 => 'الهاتف النقال (بدون فتح الخط)',
            'email'                 => 'الإيميل',
            'nationality'           => 'الجنسية',
            'city'                  => 'المنطقة',
            'blood-group'           => 'فصيلةالدم',
            'diseases'              => 'الأمراض',
            'last-travel-date'      => 'تاريخ آخر سفرة (المهم قبل شهر)',
            'last-donate-date'      => 'تاريخ آخر تبرع',
            'time'                  => 'موعد التبرع',
            'has-green-shield'      => 'هل لديك الدرع الأخضر؟',
            'regiter'               => 'تسجيل',
            'donor-age-more-than-55' => 'السن المدخل يتجاوز الحد المسموح به',
            'donor-last-travel-less-than-1-month' => 'يجب ان يكون اخر سفرة قبل اكثر من شهر',
            'only-male-allowed-to-donate' => 'التبرع للرجال فقط',
            'donor' => 'متبرع',

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
