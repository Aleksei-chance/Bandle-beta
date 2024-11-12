<?php

namespace App\Helpers;

class ResponsesHelper {
    public static function respondErrors($data)
    {
        $errors = array();
        foreach($data as $key => $massage) {
            foreach($massage as $Item) {
                $errors[] = $key.":".$Item;
            }
        }
        return implode("|", $errors);
    }
}