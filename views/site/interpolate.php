<?php include "template.html"; ?>
<div id="third-block">
    <div class="line">
        <h1>Интерполяция по высоте</h1>
        <h2>Дата</h2><br>
        <label>Год</label>
        <select id="year_third" class="textarea" required onchange="onchangeYearThird()">
            <?php foreach ($yearsList as $year):?>
                <option value=<?php echo $year;?>><?php echo $year; ?></option>
            <?php endforeach; ?>
        </select>
        <label>Месяц</label>
        <select id="month_third" onchange="onChangeMonthThird()"></select>
        <label>День</label>
        <select id="day_third" onchange="onChangeDayThird()"></select>
        <label>Время</label>
        <select id="hours_third"></select>
        <br>
        <h2>Номер станции</h2><br>
        <select id="station_third" class="textarea" required>
            <?php foreach ($stationsList as $station):?>
                <option value=<?php echo $station["id"];?>><?php echo $station["number"]; ?></option>
            <?php endforeach; ?>
        </select><br><br>
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
</div>
