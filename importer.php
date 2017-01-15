#!/usr/bin/php
<?php

class MyDB extends SQLite3 {
    function __construct()
    {
        $this->open('weather.sqlite');
    }
}

function createTables() {
    $db = new MyDB();
    $sql = "
            drop table if exists dates; drop table if exists stations; drop table if exists weather;
            CREATE TABLE dates (id INTEGER PRIMARY KEY AUTOINCREMENT, date_year integer, date_month integer, date_day integer, date_hours integer);
            CREATE TABLE stations (id INTEGER PRIMARY KEY AUTOINCREMENT, station_number integer, station_latitude REAL , station_longitude REAL);
            CREATE TABLE weather (id INTEGER PRIMARY KEY AUTOINCREMENT, date_id INTEGER(128), station_id INTEGER, PRES REAL, HGHT REAL, TEMP REAL, DWPT REAL, RELH REAL, MIXR REAL, DRCT REAL, SKNT REAL, THTA REAL, THTE REAL, THTV REAL);
    ";

    @$db->exec($sql);
    $db->close();
}

function insertRow($table, $row) {
    $db = new MyDB();
    $wherePar = [];
    foreach ($row as $key => $value) {
        $wherePar[] = "$key = $value";
    }
    $wherePar = implode(" AND ", $wherePar);
    $sqlSelect = "SELECT id FROM $table WHERE $wherePar";
    $select =$db->query($sqlSelect)->fetchArray()[0];
    if($select) {
        $lastId = $select;
    }
    else {
        $sql = "INSERT OR IGNORE INTO $table(" . implode(",", array_keys($row)) . ") VALUES (" . implode(",", array_values($row)) . ")";
        @$db->exec($sql);
        $lastId = $db->query("SELECT last_insert_rowid()")->fetchArray()[0];
    }
    $db->close();
    return $lastId;
}

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
            $selectSql = "SELECT id FROM dates WHERE date_year = $year AND date_month = $month AND date_day = $day AND date_hours = $date_hours";
            $dateId = empty($db->query($selectSql)->fetchArray())? null: $db->query($selectSql)->fetchArray()[0];
            if(empty($dateId)) {
                $dateId = insertRow("dates", $dateRow);
            }
            $station_number = $row["station_number"];
            $station_latitude = $row["station_latitude"];
            $station_longitude = $row["station_longitude"];
            $stationRow = [
                "station_number" => $station_number,
                "station_latitude" => $station_latitude,
                "station_longitude" => $station_longitude,
            ];
            $selectSql = "SELECT id FROM stations WHERE station_number = $station_number AND station_latitude = $station_latitude AND station_longitude = $station_longitude";
            $stationId = empty($db->query($selectSql)->fetchArray())? null: $db->query($selectSql)->fetchArray()[0];
            if(empty($stationId)) {
                $stationId = insertRow("stations", $stationRow);
            }
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