#!/usr/bin/php
<?php
//Базовый класс для SQLite3
class MyDB extends SQLite3 {
    function __construct()
    {
        $this->open('weather.sqlite');
    }
}
//Создание базы данных
function createTables() {
    $db = new MyDB();
    $sql = "
            drop table if exists dates; drop table if exists stations; drop table if exists weather;
            CREATE TABLE dates (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `date_year` integer, `date_month` integer, `date_day` integer, `date_hours` integer);
            CREATE TABLE stations (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `station_name` VARCHAR (128), `station_number` integer, `station_latitude` REAL , `station_longitude` REAL, `station_elevation` REAL);
            CREATE TABLE weather (`id` INTEGER PRIMARY KEY AUTOINCREMENT, `date_id` INTEGER(128), `station_id` INTEGER, `PRES` REAL, `HGHT` REAL, `TEMP` REAL, `DWPT` REAL, `RELH` REAL, `MIXR` REAL, `DRCT` REAL, `SKNT` REAL, `THTA` REAL, `THTE` REAL, `THTV` REAL);
    ";

    @$db->exec($sql);
    $db->close();
}
//Функция для вставки записи в таблицу
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
//Вставка данных
function insertWeatherData() {
    $db = new MyDB();
    $count = 1;
    $header = [];
    if (($handle = fopen("weather.csv", "r")) !== FALSE) {
        echo "Импорт погоды...";
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $row = [];
            if ($count == 1) {
                $header = $data;
                $count++;
                continue;
            }
            for ($i = 0; $i < count($header); $i++) {
                $row[$header[$i]] = "\"$data[$i]\"";
            }
            $year = $row["year"];
            $month = $row["month"];
            $day = $row["day"];
            $date_hours = $row["time"];
            $dateRow = [
                "date_year" => $year,
                "date_month" => $month,
                "date_day" => $day,
                "date_hours" => $date_hours
            ];
            $dateId = insertRow("dates", $dateRow);
            $stationRow = [
                "station_name" => $row["station_name"],
                "station_number" => $row["station_number"],
                "station_latitude" => $row["station_latitude"],
                "station_longitude" => $row["station_longitude"],
                "station_elevation" => $row["station_elevation"]
            ];
            $stationId = insertRow("stations", $stationRow);
            $weatherDataRow = [
                "PRES" => $row["PRES"],
                "HGHT" => $row["HGHT"],
                "TEMP" => $row["TEMP"],
                "DWPT" => $row["DWPT"],
                "RELH" => $row["RELH"],
                "MIXR" => $row["MIXR"],
                "DRCT" => $row["DRCT"],
                "SKNT" => $row["SKNT"],
                "THTA" => $row["THTA"],
                "THTE" => $row["THTE"],
                "THTV" => $row["THTV"],
            ];
            insertRow("weather", array_merge($weatherDataRow, ["date_id" => $dateId, "station_id" => $stationId]));
            $count++;
        }
        echo "Импортировано $count записей\n";
        fclose($handle);
    }
    $db->close();
}

createTables();
insertWeatherData();