<?php

class Events {
    public static function getDimensions($dimensionName) {
        $res = json_decode(file_get_contents("http://localhost:5000/cube/events/members/$dimensionName"));
        return $res;
    }

    public static function getFacts($filter) {
        $date = empty($filter["date"])? null: $filter["date"];
        $valute_type_id = empty($filter["valute_type_id"])? null: $filter["valute_type_id"];
        return json_decode(
            file_get_contents(
                "http://localhost:5000/cube/events/facts?cut=date_course@id:$date|valute_type@default:$valute_type_id"));
    }
}