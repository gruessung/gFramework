<?php
 /*
 gFramework Frontend
 */

 /*
 So, dann starten wir mal die TPL Engine..*brum* xP
 */
 $template = new TPL();
 $template->menuid = 1;
 $template->sitename = "Nicht gefunden";
 $template->text = "<div class=\"alert alert-error\"><b>Es ist ein Fehler aufgetreten:</b><br><ul><li>die geforderte Anwendung ist deaktiviert, oder</li><li>die Anwendung konnte nicht gefunden werden, oder</li><li>die ID ist mehrmals vergeben und konnte nicht zugeordnet werden.</li></ul></div>";
 $template->show();
