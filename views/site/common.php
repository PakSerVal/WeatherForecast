    <?php include ("template.html");?>
    <section class="back">
         <div id="first-block">
            <div class="line">
               <h1>Общие данные</h1>
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
                <h2>Номер станции</h2><br>
                <select id="station" class="textarea" required>
                    <?php foreach ($stationsList as $station):?>
                        <option value=<?php echo $station["id"];?>><?php echo $station["number"]; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <button class="btn btn-success" onclick="getData()">Получить данные</button>
                <div id="info-result"></div>
            </div>
         </div>
      </section>
   </body>
</html>