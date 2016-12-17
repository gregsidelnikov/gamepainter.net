<div id = "PublishContainer"

  style = "position: relative; width: 450px; height: 600px; ;z-index:10000000; margin-top:-30px; border:0;">

    <div id = "QueueOptions" style = "width:480px; color:gray; padding: 8px; background: #444;z-index:10000000; border-radius:10px;position:relative;">

        <div id = "Calendar" style = "background:#fff; border:0">

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
            </div>
        </div>
      <?php /*
      <p id = "ScheduleMsg">Choose publish destination to schedule:</p>
      <div id = "ScheduleDate">
          <select id = "sched_month">
              <option value = "1">01</option>
              <option value = "2">02</option>
              <option value = "3">03</option>
              <option value = "4">04</option>
              <option value = "5">05</option>
              <option value = "6">06</option>
              <option value = "7">07</option>
              <option value = "8">08</option>
              <option value = "9">09</option>
              <option value = "10">10</option>
              <option value = "11">11</option>
              <option value = "12">12</option>
          </select>
          <input type = "text" id = "sched_day" style = "width: 48px" value = "<?php print date("d"); ?>"/>
          <input type = "text" id = "sched_year" style = "width: 52px" value = "<?php print date("Y"); ?>"/>
          <input type = "text" id = "sched_time" value = "07:00am EDT"/>
          <input type = "button" id = "next_av" onclick = "get_next_available_schedule_date()" value = "Next Available" />
          <br/>
          <input type = "checkbox"
              onclick = "var time_str = $('#sched_year').val() + '-' + $('#sched_month').val() + '-' + $('#sched_day').val() + ' ' + $('#sched_time').val();
                         set_schedule_time(CURRENT_ARTICLE_ID_SETTINGS, time_str);
                         get_time_left(time_str);">
           <b>scheduled <span style = "color:#52caf6" id = "sched_time_left"></span></b>
      </div>
      <p style = "text-align:center; color:gray; font-size: 12px !important; margin-top:4px;">Publish this article:</p>
      <p style = "text-align:center;"><input type = "button" value = "Publish Article Now" onclick = "" /></p>
      */ ?>
    </div>
</div>