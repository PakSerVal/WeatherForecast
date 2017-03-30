<!DOCTYPE html>
<html lang="en-US">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width" />
      <title>Responsive Design website template</title>
      <link rel="stylesheet" href="/views/template/css/components.css">
      <link rel="stylesheet" href="/views/template/css/responsee.css">
       <link rel="stylesheet" type="text/css" href="/views/template/css/bootstrap.min.css">
      <link rel="stylesheet" href="/views/template/owl-carousel/owl.carousel.css">
      <link rel="stylesheet" href="/views/template/owl-carousel/owl.theme.css">
      <link rel="stylesheet" href="/views/template/owl-carousel/owl.theme.css">
       <link rel="stylesheet" type="text/css" href="/views/template/css/style.css">

      <!-- CUSTOM STYLE -->  
      <link rel="stylesheet" href="/views/site/css/template-style.css">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
      <script type="text/javascript" src="/views/template/js/jquery-1.8.3.min.js"></script>
      <script type="text/javascript" src="/views/template/js/jquery-ui.min.js"></script>
      <script type="text/javascript" src="/views/template/js/modernizr.js"></script>
      <script type="text/javascript" src="/views/template/js/responsee.js"></script>
       <script src="/views/template/js/ajax.js"></script>
       <script src="/views/template/js/jquery-3.1.1.min.js"></script>
       <script src="/views/template/js/bootstrap.min.js"></script>

       <!--[if lt IE 9]>
	      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
      <![endif]-->
   </head>
   <body class="size-1140">
   <script type="text/javascript">
       onchangeYear();
   </script>
   <script type="text/javascript">
       onchangeYearThird();
   </script>
   <script type="text/javascript">
       onchangeYearFourth();
   </script>
      <!-- TOP NAV WITH LOGO -->  
      <header>
         <nav>
            <div class="line">
               <div class="top-nav">
                  <div class="top-nav s-12 l-5">
                     <ul class="right top-ul chevron">
                        <li><a href="#first-block">Общие данные</a>
                        </li>
                        <li><a href="#second-block">Среднее по координатам</a>
                        </li>
                        <li><a href="#third-block">Интерполяция по высоте</a>
                        </li>
                         <li><a href="#fourth-block">Вертикальный профиль</a>
                         </li>
                     </ul>
                  </div>
               </div>
            </div>
         </nav>
      </header>
      <section class="back">
         <!-- FIRST BLOCK --> 	
         <div id="first-block">
            <div class="line">
               <h1>Общие данные метеостанции</h1>
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
          <div id="second-block">
              <div class="line">
                  <h1>Среднее по координатам</h1>
                  <h3>Диапазон</h3><br>
                  Широта : <input type="text" id="lat_1"> - <input type="text" id="lat_2"><br><br>
                  Долгота : <input type="text" id="lon_1"> - <input type="text" id="lon_2"><br><br><br>
                  <button class="btn btn-success" onclick="getAggregate()">Посчитать</button>
                  <br><br>
              </div>
              <div id="ag-result" class="ag-result"></div>
          </div>
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
          <div id="fourth-block">
              <div class="line">
                  <h1>Вертикальный профиль</h1>
                  <h2>Дата</h2><br>
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
                  <h2>Номер станции</h2><br>
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
      </section>
   <footer>
       <div class="line">
       </div>
   </footer>
   </body>
</html>