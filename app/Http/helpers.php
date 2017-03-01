<?php

namespace app\Http;

class Helperfunctions {
    /**
     * Given the array of type ['slug' => 'title', ...]
     * create new array of type [ '0' => '<a href='slug'>title</a>]
     * if $attributes given (also array), implode them from ['id'=>'newLink', 'class'=>'newClass']
     * to <a href='slug' id='newLink' class='newClass'>title</a>
     *
     *
     * @param $array, $attributes, $prefix
     * @return array
     */
    public static function linkifyArray($array, $attributes, $prefix) {
        $htmlAttributes = '';
        //inline attributes before appending them to <a></a>
        if (is_array($attributes))
        {
            foreach ($attributes as $k => $v)
            {
                $htmlAttributes.= $k.'="'.$v.'" ';
            }
        }

        $arrayOfLinks = [];
        //create array of links
        if(is_array($array))
        {
            foreach ($array as $kk => $vv)
            {
                $arrayOfLinks[]='<a '.$htmlAttributes.' href="'.$prefix.$kk.'">'.$vv.'</a>';
            }
        }

        return $arrayOfLinks;
    }
}