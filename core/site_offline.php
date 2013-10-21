<?php
$template = new gTPL();
$template->menuid = 0;
$template->sitename = "Offline";
$template->text = "<div class=\"alert alert-error\"><b>Oops....</b><br>Diese Website ist gerade offline.<br /><br />".site_offline_reason."<br /><br /><small><a href=\"core/cp/index.php\">gCP Login</a></small></div>";
$template->show();
?>