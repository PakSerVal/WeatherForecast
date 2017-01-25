function handlePeriod1() {
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