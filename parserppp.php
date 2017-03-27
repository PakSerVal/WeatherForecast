#!/usr/bin/php
<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
$f = fopen("weather1.csv", "a");
for ($meteoIndex = 7600; $meteoIndex<=100000; $meteoIndex ++) {
    echo $meteoIndex;
    //Урл, с которого парсим. В него интерполируются значения наших данных (индекс метеотанций и дата)
    $url = "http://weather.uwyo.edu/cgi-bin/sounding?region=naconf&TYPE=TEXT%3ALIST&YEAR=2016&MONTH=12&FROM=0100&TO=0300&STNM=$meteoIndex";
    $values = [];
    //Получаем содержимое страницы
    $parsingPage = file_get_contents($url);
    if(strlen($parsingPage) < 1000) {
        echo "\n";
        continue;
    }
    //Создаем объект, в который будем парсить
    $document = new DOMDocument();
    $document->loadHTML($parsingPage);
    //Получаем элементы по тегам
    $preElements = $document->getElementsByTagName("pre");
    $hElements = $document->getElementsByTagName("h2");
    if($preElements->length != 0) {
        fputcsv($f, [$meteoIndex]);
        echo "OK";
    }
    echo "\n";
}
fclose($f);
echo "OK";
