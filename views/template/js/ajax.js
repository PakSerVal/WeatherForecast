function convert() {

    $(document).ready(function () {
            $.ajax({
                url : "/site/ajaxConvert",
                method : "post",
                data :{
                    valute_type  : $("#valute_type").val(),
                    year         : $("#year").val(),
                    quarter      : $("#quarter").val(),
                    month        : $("#month").val(),
                    day          : $("#day").val()
                }
            }).done(function (data) {
                $("#avg_result").html(JSON.parse(data).avg);
                $("#max_result").html(JSON.parse(data).max);
                $("#min_result").html(JSON.parse(data).min);
            })
    })
}
function onchangeYear() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeYear",
            method : "post",
            data :{
                year      : $("#year").val(),
            }
        }).done(function (data) {
            var monthes = JSON.parse(data);
            var text;
            for(var i in monthes) {
                text += "<option value='" + monthes[i] + "'>" + monthes[i] + "</option>";
            }
            $("#month").html(text);
            onChangeMonth();
        })
    })
}

function onchangeYearThird() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeYear",
            method : "post",
            data :{
                year      : $("#year_third").val(),
            }
        }).done(function (data) {
            var monthes = JSON.parse(data);
            var text;
            for(var i in monthes) {
                text += "<option value='" + monthes[i] + "'>" + monthes[i] + "</option>";
            }
            $("#month_third").html(text);
            onChangeMonthThird();
        })
    })
}

function onchangeYearFourth() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeYear",
            method : "post",
            data :{
                year      : $("#year_fourth").val(),
            }
        }).done(function (data) {
            var monthes = JSON.parse(data);
            var text;
            for(var i in monthes) {
                text += "<option value='" + monthes[i] + "'>" + monthes[i] + "</option>";
            }
            $("#month_fourth").html(text);
            onChangeMonthFourth();
        })
    })
}

function onChangeMonth() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeMonth",
            method : "post",
            data :{
                year       : $("#year").val(),
                month      : $("#month").val()
            }
        }).done(function (data) {
            var days = JSON.parse(data);
            var text;
            for(var i in days) {
                text += "<option value='" + days[i] + "'>" + days[i] + "</option>";
            }
            $("#day").html(text);
            onChangeDay();
        })
    })
}

function onChangeMonthFourth() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeMonth",
            method : "post",
            data :{
                year       : $("#year_fourth").val(),
                month      : $("#month_fourth").val()
            }
        }).done(function (data) {
            var days = JSON.parse(data);
            var text;
            for(var i in days) {
                text += "<option value='" + days[i] + "'>" + days[i] + "</option>";
            }
            $("#day_fourth").html(text);
            onChangeDayFourth();
        })
    })
}

function onChangeMonthThird() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeMonth",
            method : "post",
            data :{
                year       : $("#year_third").val(),
                month      : $("#month_third").val()
            }
        }).done(function (data) {
            var days = JSON.parse(data);
            var text;
            for(var i in days) {
                text += "<option value='" + days[i] + "'>" + days[i] + "</option>";
            }
            $("#day_third").html(text);
            onChangeDayThird();
        })
    })
}

function onChangeDay() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeDay",
            method : "post",
            data :{
                year       : $("#year").val(),
                month      : $("#month").val(),
                day        : $("#day").val()
            }
        }).done(function (data) {
            var hours = JSON.parse(data);
            var text;
            for(var i in hours) {
                text += "<option value='" + hours[i] + "'>" + hours[i] + "</option>";
            }
            $("#hours").html(text);
        })
    })
}

function onChangeDayThird() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeDay",
            method : "post",
            data :{
                year       : $("#year_third").val(),
                month      : $("#month_third").val(),
                day        : $("#day_third").val()
            }
        }).done(function (data) {
            var hours = JSON.parse(data);
            var text;
            for(var i in hours) {
                text += "<option value='" + hours[i] + "'>" + hours[i] + "</option>";
            }
            $("#hours_third").html(text);
        })
    })
}

function onChangeDayFourth() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxchangeDay",
            method : "post",
            data :{
                year       : $("#year_fourth").val(),
                month      : $("#month_fourth").val(),
                day        : $("#day_fourth").val()
            }
        }).done(function (data) {
            var hours = JSON.parse(data);
            var text;
            for(var i in hours) {
                text += "<option value='" + hours[i] + "'>" + hours[i] + "</option>";
            }
            $("#hours_fourth").html(text);
        })
    })
}

function getData() {
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxgetData",
            method : "post",
            data :{
                station    : $("#station").val(),
                year       : $("#year").val(),
                month      : $("#month").val(),
                day        : $("#day").val(),
                hours      : $("#hours").val()
            }
        }).done(function (data) {
            $("#info-result").html(data);
        })
    })
}
function handlePeriod() {
    $(document).ready(function () {
        var period = $("#period").val();
        if(period == 'month') {
            $("#month_ob").fadeIn();
            $("#quarter_ob").fadeIn();
        } else
        if(period == 'quarter') {
            $("#month_ob").fadeOut();
            $("#quarter_ob").fadeIn();
        } else
        if(period == 'year') {
            $("#month_ob").fadeOut();
            $("#quarter_ob").fadeOut();
        } else
        if(period == 'day') {
            $("#month_ob").fadeIn();
            $("#quarter_ob").fadeIn();
        }
        $.ajax({
            url : "/site/ajaxHandlePeriod",
            method : "post",
            data :{
                period      : period
            }
        })
    })
}

function draw() {
    $("#picture").empty();
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxDraw",
            method : "post",
            data :{
                valute_draw_type      : $("#valute_draw_type").val(),
                start_date            : $("#start_date").val(),
                final_date            : $("#final_date").val()
            }
        }).done(function (data) {
            $("#picture").html(data);
        })
    })
}

function getAggregate() {
    $(document).ready(function () {
        var lat_1 = $("#lat_1").val();
        var lat_2 = $("#lat_2").val();
        var lon_1 = $("#lon_1").val();
        var lon_2 = $("#lon_2").val();
        $.ajax({
            url : "/site/ajaxCoordAver",
            method : "post",
            data :{
                lat_1      : lat_1,
                lat_2      : lat_2,
                lon_1      : lon_1,
                lon_2      : lon_2,
                year       : $("#year").val(),
                month      : $("#month").val(),
                day        : $("#day").val(),
                hours      : $("#hours").val()
            }
        }).done(function (data) {
            $("#ag-result").html(data);
        })
    })
}

function drawProfile() {
    $("#vertical-result").empty();
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxDraw",
            method : "post",
            data :{
                year       : $("#year_fourth").val(),
                month      : $("#month_fourth").val(),
                day        : $("#day_fourth").val(),
                hours      : $("#hours_fourth").val(),
                drawPar    : $("#drawPar").val(),
                station    : $("#station_fourth").val(),
            }
        }).done(function (data) {
            $("#vertical-result").html(data);
        })
    })
}

function getInterpolateData() {
    var arr=$('input:checkbox:checked').map(function() {return this.value;}).get();
    var parStr = "";
    for (i = 0; i < arr.length; i++) {
        parStr += (arr[i] + " ");
    }
    $(document).ready(function () {
        $.ajax({
            url : "/site/ajaxInterpolate",
            method : "post",
            data :{
                year       : $("#year_third").val(),
                month      : $("#month_third").val(),
                day        : $("#day_third").val(),
                hours      : $("#hours_third").val(),
                height     : $("#inter_height").val(),
                parStr     : parStr,
                station    : $("#station_third").val(),
            }
        }).done(function (data) {
            $("#interpolate-result").html(data);
        })
    })
}
