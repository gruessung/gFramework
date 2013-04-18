<?php
/* Diese Datei ist Teil des gFrameworks
In der Datei enthalten, ist die Errorausgabe von gVisions in Form der Funktion gError,
welche mit set_error_handler(var str class); aktiviert wird.
*/

function gError($fehlercode, $fehlertext, $fehlerdatei, $fehlerzeile)
{
$echo = "";
    switch ($fehlercode) {
    case E_USER_ERROR:
        $echo .= "<span style=\"font-color:red;\"><b>gError: Es ist ein Fehler aufgetreten:</b> [$fehlercode] $fehlertext<br />\n";
        $echo .="  Fataler Fehler in Zeile $fehlerzeile in der Datei $fehlerdatei";
        $echo .=", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $echo .="Abbruch...<br /></span>\n";
        echo $echo;
        error_log($echo, 3, root."/error.log");
        exit(1);
        break;

    case E_USER_WARNING:
        $echo .= "<b>gError: Warnung:</b> [$fehlercode] $fehlertext in Zeile $fehlerzeile in der Datei $fehlerdatei<br />\n";     
        echo $echo;
        error_log($echo, 3, root."/error.log");
        break;

    case E_USER_NOTICE:
        $echo .=  "<b>gError: Hinweis:</b> [$fehlercode] $fehlertext in Zeile $fehlerzeile in der Datei $fehlerdatei<br />\n";
        echo $echo;
        error_log($echo, 3, root."/error.log");
        break;


    default:
        $echo .=  "gError: Unbekannter Fehlertyp: [$fehlercode] $fehlertext in Zeile $fehlerzeile in der Datei $fehlerdatei<br />\n";
        if (debug == "true")
        {
          echo $echo;
        }
        error_log($echo, 3, root."/error.log");
        break;
    }

    /* Damit die PHP-interne Fehlerbehandlung nicht ausgeführt wird */
    return true;
}




?>