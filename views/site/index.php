<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Atmospheric science</title>
    <link rel="stylesheet" type="text/css" href="/views/template/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/views/template/css/style.css">
    <script src="/views/template/js/jquery-3.1.1.min.js"></script>
    <script src="/views/template/js/bootstrap.min.js"></script>
    <script src="/views/template/js/ajax.js"></script>
</head>
<body>
    <script type="text/javascript">
        onchangeYear();
    </script>
    <div class="info">
        <h1>Метеоданные станции</h1>
        <label>Номер станции</label>
        <select id="station" class="textarea" required>
            <?php foreach ($stationsList as $station):?>
                <option value=<?php echo $station["id"];?>><?php echo $station["number"]; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label>Дата:</label><br>
        <label>Год</label>
        <select id="year" class="textarea" required onchange="onchangeYear()">
            <?php foreach ($yearsList as $year):?>
                <option value=<?php echo $year;?>><?php echo $year; ?></option>
            <?php endforeach; ?>
        </select>
        <label>Месяц</label>
             <select id="month" onchange="onChangeMonth()"></select>
        <label>День</label>
            <select id="day" onchange="onChangeDay()"></select>
        <label>Время</label>
        <select id="hours"></select>
        <br>
        <button class="btn btn-success" onclick="getData()">Получить данные</button>
        <br><br>
        <div id="info-result"></div>
    </div>
    <br>
<!--    <div class="aggregate">-->
<!--        <h1>Агрегированные данные</h1>-->
<!--        <label>Период:</label><br>-->
<!--        <label>от: </label><select></select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label>до: </label><select></select><br>-->
<!--        <h4>Выбрать параметры:</h4>-->
<!--        <input type="checkbox" name="options" value="PRES">Atmospheric Pressure<Br>-->
<!--        <input type="checkbox" name="options" value="TEMP">Temperature<Br>-->
<!--        <input type="checkbox" name="options" value="DWPT">Dewpoint Temperature<Br>-->
<!--        <input type="checkbox" name="options" value="FRPT">Frost Point Temperature<Br>-->
<!--        <input type="checkbox" name="options" value="RELH">Relative Humidity<Br>-->
<!--        <input type="checkbox" name="options" value="RELI">Relative Humidity with respect to Ice<Br>-->
<!--        <input type="checkbox" name="options" value="MIXR">Mixing Ratio<Br>-->
<!--        <input type="checkbox" name="options" value="DRCT">Wind Direction<Br>-->
<!--        <input type="checkbox" name="options" value="SKNT">Wind Speed<Br>-->
<!--        <h4>Что считать</h4>-->
<!--        <input type="checkbox" name="functions" value="max">Максимольное<Br>-->
<!--        <input type="checkbox" name="options" value="avg">Среднее<Br>-->
<!--        <input type="checkbox" name="options" value="min">Минимальное<Br>-->
<!--        <button class="btn btn-success">Получить данные</button>-->
<!--        <br><br>-->
<!--        <div class="aggregate-result"></div>-->
<!--    </div>-->
<!--    <br>-->
<!--    <div class="searching">-->
<!--        <h1>Поиск по синоптическому индексу станции</h1>-->
<!--        Индекс <input type="text" name="index"><br>-->
<!--        <button class="btn btn-success">Найти</button>-->
<!--        <br><br>-->
<!--        <div class="search-result"></div>-->
<!--    </div>-->
</body>
</html>