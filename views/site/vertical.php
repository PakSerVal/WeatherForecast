<?php include ("template.html");?>
<div id="fourth-block">
    <div class="line">
        <h1>Вертикальный профиль</h1>
        <h1>Дата</h1><br>
        <label>Год</label>
        <select id="year_fourth" class="textarea" required onchange="onchangeYearFourth()">
            <?php foreach ($yearsList as $year):?>
                <option value=<?php echo $year;?>><?php echo $year; ?></option>
            <?php endforeach; ?>
        </select>
        <label>Месяц</label>
        <select id="month_fourth" onchange="onChangeMonthFourth()"></select>
        <label>День</label>
        <select id="day_fourth" onchange="onChangeDayFourth()"></select>
        <label>Время</label>
        <select id="hours_fourth"></select>
        <br>
        <h1>Номер станции</h1><br>
        <select id="station_fourth" class="textarea" required>
            <?php foreach ($stationsList as $station):?>
                <option value=<?php echo $station["id"];?>><?php echo $station["number"]; ?></option>
            <?php endforeach; ?>
        </select><br><br>
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
    </div>
    <div id="vertical-result"></div>
</div>