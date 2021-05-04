<?php

namespace App\Helpers;

class Common
{
    public function randomCode($size = 1)
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789');
                 shuffle($seed);
                 $rand = '';
                 foreach (array_rand($seed, $size) as $k) $rand .= $seed[$k];
                 return $rand;
    }
    public static function limit($value, $limit = 120, $end = '...'){
    if (mb_strwidth($value, 'UTF-8') <= $limit) {
        return $value;
    }
    return strip_tags(rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8'))).$end;
    }
}
