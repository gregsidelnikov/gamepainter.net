<div id = "calendarArea"
  style = "margin-top: 23px; background:#fff; padding: 10px; position: absolute; top: 0px; left: 0px; width: 500px; height: 440px; margin-top:10px;">
    <div id = "Calendar" style = "position: relative; background: #fff; border: 1px solid #dedede; width: 400px; padding: 5px; padding-top: 16px;">

        <div style = "position: absolute; font-family: Verdana, sans-serif; font-size: 11px; top: 0; left: 3px;" id = "cal_sched_article_name"></div>

        <div id = "Y">
            <b>2009</b>
            <b>2010</b>
            <b>2011</b>
            <b>2012</b>
            <b>2013</b>
            <b>2014</b>
            <b>2015</b>
            <b>2016</b>
            <b>2017</b>
        </div>
        <div class = "sep"></div>
        <div id = "M">
            <b>JAN</b>
            <b>FEB</b>
            <b>MAR</b>
            <b>APR</b>
            <b>MAY</b>
            <b>JUN</b>
            <b>JUL</b>
            <b>AUG</b>
            <b>SEP</b>
            <b>OCT</b>
            <b>NOV</b>
            <b>DEC</b>
        </div>
        <div class = "sep2"></div>
        <div id = "Week">
            <b>Monday</b>
            <b>Tuesday</b>
            <b>Wednesday</b>
            <b>Thursday</b>
            <b>Friday</b>
            <b>Saturday</b>
            <b>Sunday</b>
        </div>
        <div id = "Day">
            <div id = "Day365"></div>
            <?php include("../calendar/pop_reserve.php"); ?>
            <?php include("../calendar/pop_thankyou.php"); ?>
            <?php include("../calendar/pop_list.php"); ?>
            <?php include("../calendar/pop_detail.php"); ?>
            <?php include("../calendar/pop_choose.php"); ?>
        </div>
    </div>
    <span style = "color:gray; font-size:11px; font-family: Verdana, sans-serif;">* Use this calendar to schedule blogs, webpages and emails.</span>
</div>