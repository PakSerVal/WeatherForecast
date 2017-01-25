<?php

class weather {
    public static function getDimensions($dimensionName) {
        $res = json_decode(file_get_contents("http://localhost:5000/cube/weather/members/$dimensionName"));
        return $res;
    }

    public static function getDateUniqueUnit($depth, $filter = null) {
        $res = json_decode(file_get_contents("http://localhost:5000/cube/weather/members/date_weather?depth=$depth&$filter"));
        return $res;
    }

    public static function getFacts($filter) {
        $date = empty($filter["date"])? null: $filter["date"];
        $station = empty($filter["station"])? null: $filter["station"];
        return json_decode(
            file_get_contents(
                "http://localhost:5000/cube/weather/facts?cut=date_weather@default:$date|station@default:$station"));
    }
}