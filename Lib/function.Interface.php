<?php

  function DisplayFrontPageStatistics()
  {
    /* deprecated or currently unused */
  }

  function DisplayFrontPageMessage()
  {
    /* deprecated or currently unused */
  }

  function quickTips() {
    /* deprecated or currently unused */
  }

  function siteNavigationHeader($msg = "") {
    /* deprecated or currently unused */
  }

  function siteFooter()
  {
    global $ltTotal;

    ?>

    <span class="smalltext"><p align="center">

    &copy; 2007-08 Job Application. <?php

        calcLoadTime();

        print "Page load time: ".round($ltTotal,3)." millisecond(s)";

    ?>

    </p>

    </span>

    <?php
  }

  function siteNavigation() {

    global $qsession;

    ?>

  <div class = "Navigation">

  <?php

    if (q_isLoggedIn()) {

    ?>
    <table border="0" cellspacing="0" cellpadding="0"><tr>
      <td class="left">&nbsp;</td>
      <td class="main">
       <div id = "navMyAccount"><a href="<?php print $GLOBAL_ROOT; ?>/myaccount.php">My Account</a></div>
      </td>
      <td class="right">&nbsp;</td>
    </tr></table>
    <?php

      }

  ?>

    <table border="0" cellspacing="0" cellpadding="0"><tr>
      <td class="left">&nbsp;</td>
      <td class="main">
       <div style="position:relative" nowrap><a href="index.php">Home</a></div>
      </td>
      <td class="right">&nbsp;</td>
    </tr></table>

    <table border="0" cellspacing="0" cellpadding="0"><tr>
      <td class="left">&nbsp;</td>
      <td class="main">
       <div><a href="<?php print $GLOBAL_ROOT; ?>/encyclopedia.php">Encyclopedia</a></div>
      </td>
      <td class="right">&nbsp;</td>
    </tr></table>

    <table border="0" cellspacing="0" cellpadding="0"><tr>
      <td class="left">&nbsp;</td>
      <td class="main">
       <div nowrap><a href="<?php print $GLOBAL_ROOT; ?>/browsebios.php">Browse&nbsp;Users</a></div>
      </td>
      <td class="right">&nbsp;</td>
    </tr></table>

    <table border="0" cellspacing="0" cellpadding="0"><tr>
      <td class="left">&nbsp;</td>
      <td class="main">
       <div id = "navAbout"><a href="<?php print $GLOBAL_ROOT; ?>/about.php">About</a></div>
      </td>
      <td class="right">&nbsp;</td>
    </tr></table>

    <table border="0" cellspacing="0" cellpadding="0"><tr>
      <td class="left">&nbsp;</td>
      <td class="main">
       <div id = "navContactAS" nowrap><a href="<?php print $GLOBAL_ROOT; ?>/contact.php">Contact Us</a></div>
      </td>
      <td class="right">&nbsp;</td>
    </tr></table>

    <table border="0" cellspacing="0" cellpadding="0"><tr>
      <td class="left">&nbsp;</td>
      <td class="main">
      <?php if (q_isLoggedIn()) {
          if (strpos(selfURL(),"?")) $combiner = "&"; else $combiner = "?"; ?>
        <div id = "navLog" nowrap><a href="<?php print selfURL(); print $combiner; ?>log=out">Log Out</a></div>
      <?php } else { ?>
        <div id = "navLog" nowrap><a href="<?php print $GLOBAL_ROOT; ?>/login.php">Log In</a></div>
      <?php } ?>
      </td>
      <td class="right">&nbsp;</td>
    </tr></table>

    <p> <!-- CSS Chooser -->

    <!--

    <img src="<?php print $GLOBAL_ROOT; ?>/img/SelectSiteTheme.gif">

    <p> //-->

      <div style="text-align:center;">

        <a href="#" onclick="setActiveStyleSheet('style0'); return false;"><img src="<?php print $GLOBAL_ROOT; ?>/img/theme0.gif" border="0" alt="No Style (Default)" style=""></a><p>

        <a href="#" onclick="setActiveStyleSheet('style1'); return false;"><img src="<?php print $GLOBAL_ROOT; ?>/img/theme1.gif" border="0" alt="White Text on Black Background (Default)"></a><p>

      </div>

      <div style="height:400px;"></div>

    </div>

  <?php }

?>