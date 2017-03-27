<?php

class Valute {
    public static function getResult($getRequest) {
        return json_decode(file_get_contents($getRequest));
    }

    public static  function getDimensions($dimensionName) {
        $res = json_decode(file_get_contents("http://localhost:5000/cube/courses/members/$dimensionName"));
        return $res;
    }

    public static function getFacts(array $filter) {
        $date = empty($filter["date"])? null: $filter["date"];
        $valute_type_id = empty($filter["valute_type_id"])? null: $filter["valute_type_id"];
        return json_decode(
            file_get_contents(
                "http://localhost:5000/cube/courses/facts?cut=date_course@id:$date|valute_type@default:$valute_type_id"));
    }

    public static function getAggregates(array $date) {
        $year     = null;
        $month    = null;
        $quarter  = null;
        $valuteId = null;
        if(!empty($date["year"]) && !empty($date["quarter"]) && !empty($date["month"]) && !empty($date["valuteId"])) {
            $year  = $date["year"];
            $month = $date["month"];
            $quarter = $date ["quarter"];
            $valuteId = $date["valuteId"];
            if(isset($_SESSION["period"])) {
                $period = $_SESSION["period"];
            }
            else $period = "month";
        }
        else return [];
        $path = null;
        switch ($period) {
            case "month":
                $path = "$year,$quarter,$month";
                break;
            case "quarter":
                $path = "$year,$quarter";
                break;
            case "year":
                $path = "$year";
                break;
        }
        return json_decode(
            file_get_contents(
                "http://localhost:5000/cube/courses/aggregate?cut=date_course@date:$path|valute_type@default:$valuteId"))->summary;
    }
}