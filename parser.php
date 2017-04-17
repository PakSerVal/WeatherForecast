#!/usr/bin/php
<?php
//Получаем индексы метеостанций, дату снятия показаний
$file = fopen("parseInfo.txt", "r");
$meteoIndexes = [];
$year    = null;
$month   = null;
$fromDay = null;
$toDay   = null;
//Инициализаиця
while (($line = fgets($file, 1000)) != false) {
    $fields = explode(":", $line);
    if($fields[0] == "Станции") {
        $meteoIndexes = explode(",", $fields[1]);
    }
    if($fields[0] == "Дата") {
        $dateArray = explode(",", $fields[1]);
        $year      = $dateArray[0];
        $month     = $dateArray[1];
        $fromDay   = $dateArray[2];
        $toDay     = $dateArray[3];
    }
}
fclose($file);
//Определяем заголовки csv файла
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
$f = fopen("weather.csv", "a");
//Вставляем их
if(filesize("weather.csv") == 0) {
    fputcsv($f, $headers);
}
//Цикл по индексам
echo "Парсинг...";
foreach ($meteoIndexes as $meteoIndex) {
    //Урл, с которого парсим. В него интерполируются значения наших данных (индекс метеотанций и дата)
    $url = "http://weather.uwyo.edu/cgi-bin/sounding?region=naconf&TYPE=TEXT%3ALIST&YEAR=$year&MONTH=$month&FROM=$fromDay&TO=$toDay&STNM=$meteoIndex";
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
        } else { // Иначе получаем данные о самой станции
            $stationInfo = [];
            for ($p = 1; $p < count($pre)-1; $p++) {
                $line = explode(":", $pre[$p]);
                $stationInfo[trim($line[0])] = trim($line[1]);
            }
            $inHeader = $hElements->item($hIndex)->nodeValue;
            $inHeader = explode(" ", $inHeader);
            $day  = $inHeader[count($inHeader)-3];
            $time = $inHeader[count($inHeader)-4];
            $stationName = null;
            for ($iHeader = 1; $iHeader <= count($inHeader)-7; $iHeader++) {
                $stationName .= $inHeader[$iHeader] . " ";
            }
            $stationName = trim($stationName);
            for($l = 0; $l < $lineIndex-1; $l++) {
                $values[$l][] = $year;
                $values[$l][] = $month;
                $values[$l][] = $day;
                $values[$l][] = $time;
                $values[$l][] = $stationInfo["Station identifier"]? $stationInfo["Station identifier"] : null;
                $values[$l][] = $stationName;
                $values[$l][] = isset($stationInfo["Station number"])? $stationInfo["Station number"] : null;
                $values[$l][] = isset($stationInfo["Station latitude"])? $stationInfo["Station latitude"] : null;
                $values[$l][] = isset($stationInfo["Station longitude"])? $stationInfo["Station longitude"] : null;
                $values[$l][] = isset($stationInfo["Station elevation"])? $stationInfo["Station elevation"] : null;
                fputcsv($f, $values[$l]);// пут строки в csv
            }
            $values = [];
            $lineIndex = 0;
            $hIndex++;
        }
    }
}
fclose($f);
echo "OK";
