<?php include ("template.html"); ?>
<div id="second-block">
    <div class="line">
        <h1>Среднее по координатам</h1>
        <h2>Дата</h2><br>
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
        <h3>Диапазон</h3><br>
        Широта : <input type="text" id="lat_1"> - <input type="text" id="lat_2"><br><br>
        Долгота : <input type="text" id="lon_1"> - <input type="text" id="lon_2"><br><br><br>
        <button class="btn btn-success" onclick="getAggregate()">Посчитать</button>
        <br><br>
    </div>
    <div id="ag-result" class="ag-result"></div>
</div>
