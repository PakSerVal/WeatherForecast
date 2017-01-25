<?php

class SiteController
{
    public function actionIndex() {
        $stations = weather::getDimensions("station")->data;
        $stationsList = [];
        $propStNumber = "station.number";
        $propStId     = "station.id";
        foreach ($stations as $station) {
            $stationValues = [];
            $stationValues["id"]     = $station->$propStId;
            $stationValues["number"] = $station->$propStNumber;
            $stationsList[] = $stationValues;
        }
        $years = weather::getDateUniqueUnit("1")->data;
        $yearsList = [];
        $propName = "date_weather.year";
        foreach ($years as $year) {
            $yearsList[] = $year->$propName;
        }

        include_once ROOT."/views/site/index.php";
        return true;
    }

    public function actionAjaxchangeYear() {
        $year = $_POST["year"];
        $monthes = weather::getDateUniqueUnit(2, "cut=date_weather@default=year:$year")->data;
        $propName = "date_weather.month";
        $monthesList = [];
        foreach ($monthes as $month) {
            $monthesList[] = $month->$propName;
        }
        $monthesList = array_unique($monthesList);
        echo json_encode($monthesList);
        return true;
    }

    public function actionAjaxchangeMonth() {
        $year  = $_POST["year"];
        $month = $_POST["month"];
        $days  = weather::getDateUniqueUnit(3, "cut=date_weather@default=year:$year,$month")->data;
        $daysList =[];
        $propName = "date_weather.day";
        foreach ($days as $day) {
            $daysList[] = $day->$propName;
        }
        $daysList = array_unique($daysList);
        echo json_encode($daysList);
        return true;
    }

    public function actionAjaxchangeDay() {
        $year  = $_POST["year"];
        $month = $_POST["month"];
        $day   = $_POST["day"];
        $hours  = weather::getDateUniqueUnit(4, "cut=date_weather@default=year:$year,$month,$day")->data;
        $hoursList =[];
        $propName = "date_weather.hours";
        foreach ($hours as $hour) {
            $hoursList[] = $hour->$propName;
        }
        $hoursList = array_unique($hoursList);
        echo json_encode($hoursList);
        return true;
    }

    public function actionAjaxgetData() {
        $year    = $_POST["year"];
        $month   = $_POST["month"];
        $day     = $_POST["day"];
        $hours   = $_POST["hours"];
        $station = $_POST["station"];
        $weatherdata = weather::getFacts([
            "date"    => "$year,$month,$day,$hours",
            "station" => $station
        ]);
        $headers = [
            "PRES",
            "HGHT",
            "TEMP",
            "DWPT",
            "RELH",
            "MIXR",
            "DRCT",
            "SKNT",
            "THTA",
            "THTE",
            "THTV",
        ];
        echo "<table class='tbl'>\n";
        echo "
              <tr>";
        foreach ($headers as $header) {
            echo "<th>$header</th>";
        }
        echo "</tr>";
        foreach ($weatherdata as $data) {
            echo "<tr>\n";
            foreach ($headers as $header) {
                echo "<td>".$data->$header;
                echo "</td>\n";
            }
            echo "<tr/>";
        }
        echo "</table><br>";

        $stationHeaders = [
            "station.name",
            "station.number",
            "station.latitude",
            "station.longitude",
            "station.elevation"
        ];
        foreach ($stationHeaders as $header) {
            $value =$weatherdata[0]->$header;
            if(!empty($value)) {
                echo "<label>$header : $value</label><br>";
            }
        }
        return true;
    }
}