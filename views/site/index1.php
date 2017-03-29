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
        <h1 style="color: red">Метеоданные станции</h1>
        <br>
        <h2>Дата:</h2><br>
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
        <label>Номер станции</label>
        <select id="station" class="textarea" required>
            <?php foreach ($stationsList as $station):?>
                <option value=<?php echo $station["id"];?>><?php echo $station["number"]; ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-success" onclick="getData()">Получить данные</button>
        <br><br>
        <div id="info-result"></div>
        <div class="searching">
            <h3>Среднее по координатам</h3>
            <h3>Первая пара значений</h3><br>
            Широта <input type="text" id="lat_1"><br>
            Долгота <input type="text" id="lon_1"><br>
            <h3>Вторая пара значений</h3><br>
            Широта <input type="text" id="lat_2"><br>
            Долгота <input type="text" id="lon_2"><br>
            <button class="btn btn-success" onclick="getAggregate()">Посчитать</button>
            <br><br>
            <div id="ag-result"></div>
        </div>
        <br>
        <div class="vertical">
            <h1>Вертикальный профиль</h1>
            <label>Выберите параметр:</label>
            <select id="drawPar">
                <option value=PRES>Atmospheric Pressure</option>
                <option value=TEMP>Temperature</option>
                <option value=DWPT>Dewpoint Temperature</option>
                <option value=RELH>Relative Humidity</option>
                <option value=MIXR>Mixing Ratio</option>
                <option value=DRCT>Wind Direction</option>
                <option value=SKNT>Wind Speed</option>
            </select>
            <br>
            <button class="btn btn-success" onclick="drawProfile()">Построить график</button>
            <div id="vertical-result"></div>
        </div>
    </div>
    <br>
    <br>
                <div class="interpolation">
                    <h1>Интерполяция</h1>
                    <h4>Выбрать параметры:</h4>
                            <input type="checkbox" name="options[]" value="PRES">Atmospheric Pressure<Br>
                            <input type="checkbox" name="options[]" value="TEMP">Temperature<Br>
                            <input type="checkbox" name="options[]" value="DWPT">Dewpoint Temperature<Br>
                            <input type="checkbox" name="options[]" value="RELH">Relative Humidity<Br>
                            <input type="checkbox" name="options[]" value="MIXR">Mixing Ratio<Br>
                            <input type="checkbox" name="options[]" value="DRCT">Wind Direction<Br>
                            <input type="checkbox" name="options[]" value="SKNT">Wind Speed<Br>
                    <br>
                    <label>Введите высоту</label> <input type="text" id="inter_height">
                    <br><br><br>
                    <button class="btn btn-success" onclick="getInterpolateData()">Получить данные</button>
                    <div id="interpolate-result"></div>
                </div>

</body>
</html>