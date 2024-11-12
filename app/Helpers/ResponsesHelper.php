<?php

namespace App\Helpers;

class ResponsesHelper {
    public static function respondErrors($data, $string = '')
    {
        $errors = array();
        foreach($data as $key => $massage) {
            foreach($massage as $Item) {
                $errors[] = $key.$string.":".$Item;
            }
        }
        return implode("|", $errors);
    }
}