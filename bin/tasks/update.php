#!/usr/bin/php
<?php
// 0 23 * * * * root /var/www/currentProjects/WeatherForecast/bin/tasks/update
//Базовый класс для SQLite3
class MyDB extends SQLite3 {
    function __construct()
    {
        $this->open('/var/www/currentProjects/WeatherForecast/weather.sqlite');
    }
}

function insertRow($table, $row) {
    $db = new MyDB();
    $wherePar = [];
    foreach ($row as $key => $value) {
        $wherePar[] = "`$key` = $value";
    }
    $wherePar = implode(" AND ", $wherePar);
    $sqlSelect = "SELECT id FROM $table WHERE $wherePar";
    $select =$db->query($sqlSelect)->fetchArray()[0];
    if($select) {
        $lastId = $select;
    }
    else {
        $insertKeys = array_map(
            function ($el) {
                return "`$el`";
            },
            array_keys($row)
        );
        $sql = "INSERT OR IGNORE INTO $table(" . implode(",", $insertKeys) . ") VALUES (" . implode(",", array_values($row)) . ")";
        @$db->exec($sql);
        $lastId = $db->query("SELECT last_insert_rowid()")->fetchArray()[0];
    }
    $db->close();
    return $lastId;
}

function insertWeatherData($weatherData, $stationId, $dateId) {
    $db         = new MyDB();
    $weatherDataRow = [
        "PRES" => $weatherData["PRES"],
        "HGHT" => $weatherData["HGHT"],
        "TEMP" => $weatherData["TEMP"],
        "DWPT" => $weatherData["DWPT"],
        "RELH" => $weatherData["RELH"],
        "MIXR" => $weatherData["MIXR"],
        "DRCT" => $weatherData["DRCT"],
        "SKNT" => $weatherData["SKNT"],
        "THTA" => $weatherData["THTA"],
        "THTE" => $weatherData["THTE"],
        "THTV" => $weatherData["THTV"],
    ];
    insertRow("weather", array_merge($weatherDataRow, ["date_id" => $dateId, "station_id" => $stationId]));
    $db->close();
}

$file = fopen("/var/www/currentProjects/WeatherForecast/parseInfo.txt", "r");
$meteoIndexes = [];
while (($line = fgets($file, 1000)) != false) {
    $fields = explode(":", $line);
    if($fields[0] == "Станции") {
        $meteoIndexes = explode(",", $fields[1]);
    }
}
fclose($file);
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
    "year",
    "month",
    "day",
    "time",
    "station_identifier",
    "station_name",
    "station_number",
    "station_latitude",
    "station_longitude",
    "station_elevation"
];


$year = date("Y");
$day = date("d");
$month = date("m");

foreach ($meteoIndexes as $meteoIndex) {
    //Урл, с которого парсим. В него интерполируются значения наших данных (индекс метеотанций и дата)
    $url = "http://weather.uwyo.edu/cgi-bin/sounding?region=naconf&TYPE=TEXT%3ALIST&YEAR=$year&MONTH=$month&FROM=$day"."00&TO=$day"."00&STNM=$meteoIndex";
    $values = [];
    //Получаем содержимое страницы
    $parsingPage = file_get_contents($url);
    //Создаем объект, в который будем парсить
    $document = new DOMDocument();
    $document->loadHTML($parsingPage);
    //Получаем элементы по тегам
    $preElements = $document->getElementsByTagName("pre");
    $hElements = $document->getElementsByTagName("h2");
    $hIndex    = 0; //Счетчик h2 тегов
    $lineIndex = 0; //Счетчик строк для одного элемента тега <pre>
    //Проходим по всем элементом <pre>
    for ($i=0;  $i<$preElements->length; $i++) {
        //эйсплоуд по переносу строк
        $pre = explode("\n", $preElements->item($i)->nodeValue);
        //если строка в <pre> начинается с черточек, то заполняем данные показаний станции
        if($pre[1] == "-----------------------------------------------------------------------------") {
            for ($j = 5; $j<count($pre); $j++) {
                if(!empty($line = $pre[$j])) {
                    for ($k = 0; $k<=70; $k+=7) {
                        $substr = substr($line, $k, 7);
                        $values[$lineIndex][] = trim($substr);
                    }
                }
                $lineIndex++;
            }
            $date_hours = "00Z";
            $dateId = insertRow("dates",
                [
                    "date_year"  => "'$year'",
                    "date_month" => "'$month'",
                    "date_day"   => "'$day'",
                    "date_hours" => "'$date_hours'"
                ]
            );
            $stationId = insertRow("stations", ["station_number" => "'$meteoIndex'"]);
            foreach ($values as $value) {
                $weatherData = [];
                $weatherData["PRES"] = "'$value[0]'";
                $weatherData["HGHT"] = "'$value[1]'";
                $weatherData["TEMP"] = "'$value[2]'";
                $weatherData["DWPT"] = "'$value[3]'";
                $weatherData["RELH"] = "'$value[4]'";
                $weatherData["MIXR"] = "'$value[5]'";
                $weatherData["DRCT"] = "'$value[6]'";
                $weatherData["SKNT"] = "'$value[7]'";
                $weatherData["THTA"] = "'$value[8]'";
                $weatherData["THTE"] = "'$value[9]'";
                $weatherData["THTV"] = "'$value[10]'";
                insertWeatherData($weatherData, $stationId, $dateId);
            }
        }
        $values = [];
    }
}
