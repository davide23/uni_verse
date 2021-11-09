<?php

namespace App\Shared;

use App\Shared\Shared;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Shared
{
    
    public static function formatToVueMultiselectOptions($assocArray)
    {        
        $multselectArray = array();

        foreach($assocArray as $key => $value)
        {
            $multselectArray[] = [
                'name' => $value,
                'code' => $key
            ];
        }

        return $multselectArray;
    }


}