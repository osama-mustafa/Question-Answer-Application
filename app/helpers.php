<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


// This function increment view count for any entity like post, article, question ...etc
// you should call it in the show() method of that entity.
// NOTE THAT: The entity should have a field in the database for views.

if (!function_exists('incrementViewCount')) {
    function incrementViewCount($table, $field = 'views', $recordId)
    {
        try {
            $key = $table . $recordId;
            $viewed = Session::get($key, false);
            if (!$viewed) {
                DB::table($table)->where('id', $recordId)->increment($field, 1);
                Session::put($key, true);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
