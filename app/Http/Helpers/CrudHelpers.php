<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Created by PhpStorm.
 * User: Maina
 * Date: 1/16/2019
 * Time: 2:56 PM
 */


/**
 * @param $table
 * @param array $values
 * @param bool $return_id
 * @return bool|int
 */
function insert($table, $values = [], $return_id = false)
{
    try {

        $query = DB::table($table);

        if ($return_id) {
            return $query->insertGetId($values);
        }
        return $query->insert($values);
    } catch (\Exception $e) {

        $logData = array('log_content' => json_encode($e->getMessage()));
        insert('tbl_logs', $logData);

        Log::error("Exception  insert ::  ".$e->getMessage());

        return false;
    }
}

function update($table, array $conditions, array $values)
{
    $query = DB::table($table);

    foreach ($conditions as $key => $value) {
        $query = $query->where($key, $value);
    }

    return ($query->update($values) >= 1);
}

function updateLast($table, array $conditions, array $values)
{
    $query = DB::table($table);

    foreach ($conditions as $key => $value) {
        $query = $query->where($key, $value);
    }

    return ($query->orderBy('created_at', 'DESC')->limit(1)->update($values) >= 1);
}

function batchUpdate($table, $needle, array $haystack, array $values)
{
    $query = DB::table($table);

    $query = $query->whereIn($needle, $haystack);

    return ($query->update($values) >= 1);
}

function delete($table, array $conditions)
{
    $query = DB::table($table);

    foreach ($conditions as $key => $value) {
        $query = $query->where($key, $value);
    }

    return $query->delete();
}