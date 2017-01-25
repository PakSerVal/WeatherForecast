<head>
    <?php
    /* Include all the classes pChart*/
    include(ROOT . "/classes/pDraw.class.php");
    include(ROOT . "/classes/pImage.class.php");
    include(ROOT . "/classes/pData.class.php");
    ?>
</head>
<?php
$myData = new pData();

    $myData->addPoints([1,2,3,4,5,8,7,8,9],"Total");
    $myData->addPoints([1,2,3,4,5,6.5,7,8,9],"Labels");

$myData->addPoints([1,2,3,4,5,13,7,8,9],"T");
//$myData->addPoints([1,2,3,4,5,6.5,7,8,9],"L");

//$unique = date("Y.m.d_H.i");
//$gsFilename_Traffic = "traffic_".$unique.".png";

//$myData->setSerieDescription("Labels","Days");
$myData->setAbscissa("Labels");
//$myData->setAxisUnit(0," KB");

//$serieSettings = array("R"=>229,"G"=>11,"B"=>11,"Alpha"=>100);
//$myData->setPalette("Total",$serieSettings);

$myPicture = new pImage(1250,400,$myData); // <-- Размер холста
$myPicture->setFontProperties(array("FontName"=>"/home/sergey/www/DataWarhouse/fonts/GeosansLight.ttf","FontSize"=>8));
$myPicture->setGraphArea(50,20,1230,380); // <-- Размещение графика на холсте
$myPicture->drawScale();
//$myPicture->drawBestFit(array("Alpha"=>40)); // <-- Прямая статистики

$myPicture->drawLineChart();
$myPicture->drawPlotChart(array("DisplayValues"=>FALSE,"PlotBorder"=>TRUE,"BorderSize"=>0,"Surrounding"=>-60,"BorderAlpha"=>50)); // <-- Точки на графике
//$myPicture->drawLegend(700,10,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));// <-- Размещение легенды
$myPicture->Render("/home/sergey/www/DataWarhouse/pChartPic/img1.png");

?>
<br /><h3>График</h3>
<br /><IMG src="/pChartPic/img1.png" />