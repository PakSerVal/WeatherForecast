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

    //Метеоданные станции
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
            "station.identifier",
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

    //Среднее по координатам
    public function actionAjaxCoordAver() {
        $lat_1 = $_POST["lat_1"];
        $lat_2 = $_POST["lat_2"];
        $lon_1 = $_POST["lon_1"];
        $lon_2 = $_POST["lon_2"];
        $year  = $_POST["year"];
        $month = $_POST["month"];
        $day   = $_POST["day"];
        $hours = $_POST["hours"];
        $stations = weather::getDimensions("station")->data;
        $stationsList = [];
        $propStNumber = "station.number";
        $propStId     = "station.id";
        $propStLat    = "station.latitude";
        $propStLon    = "station.longitude";
        foreach ($stations as $station) {
            $stationId     = $station->$propStId;
            $stationNumber = $station->$propStNumber;
            $stationLat    = $station->$propStLat;
            $stationLon    = $station->$propStLon;
            if($lat_1 <= $stationLat && $lat_2 >= $stationLat && $lon_1 <= $stationLon && $lon_2 >= $stationLon) {
                $stationsList[$stationId] = $stationNumber;
            }
        }
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
        $heightProp = "HGHT";
        $sumList = [];
        $stationNumbers = [];
        foreach ($stationsList as $id => $number) {
            $stationNumbers[] = $number;
            $weatherdata = weather::getFacts([
                "date"    => "$year,$month,$day,$hours",
                "station" => $id
            ]);
            foreach ($weatherdata as $data) {
                $height = $data->$heightProp;
                if (empty($sumList[$height])) {
                    $sumList[$height]["count"] = 1;
                } else {
                    $sumList[$height]["count"] ++;
                }
                foreach ($headers as $header) {
                    if (empty($sumList[$height][$header])) {
                        $sumList[$height][$header] = $data->$header;
                    } else {
                        $sumList[$height][$header] += $data->$header;
                    }
                }
            }
        }

        foreach ($sumList as $height => $sumData) {
            foreach ($headers as $header) {

                $averList[$height][$header] = $sumData[$header] / $sumData["count"];
            }
        }

        ksort($averList);

        if (!empty($averList)) {
            echo "Номера подходящих станций: " . implode(", ", $stationNumbers);
            echo "<table class='tbl'>\n";
            echo "
              <tr><th>Height</th>";
            foreach ($headers as $header) {
                echo "<th>AVG($header)</th>";
            }
            echo "</tr>";
            foreach ($averList as $height => $averValue) {
                echo "<tr>";
                echo "<td>" . $height;
                echo "</td>\n";
                foreach ($headers as $header) {
                    echo "<td>" . $averValue[$header];
                    echo "</td>\n";
                }
                echo "</tr>";
            }
            echo "</table><br>";
        } else {
            echo "Нет станций, подходящих под эти параметры.";
        }
        return true;
    }
}