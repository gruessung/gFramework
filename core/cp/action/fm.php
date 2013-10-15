<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexander
 * Date: 14.10.13
 * Time: 08:50
 * To change this template use File | Settings | File Templates.
 */

$bildtypen = array(1 => "image/gif",
                   2 => "image/jpeg",
                   3 => "image/png",
                   4 => "image/jpg");

$action = @$_GET["fm"];
if (empty($action)) $action = "dir";

$dir = @$_GET["dir"];
if (empty($dir)) $dir = "/";

define("base", core."cp/filemanager");

$currentDir = base.$dir."/";

if (strpos(realpath($currentDir), realpath(base)) === false)
{
    echo '<div class="alert alert-error"><b>Verzeichnisschutz</b><br />Sie d&uuml;rfen dieses Verzeichnis nicht verlassen.<br />
          <a href="index.php?action=fm">Bitte starten Sie den Filemanager neu!</a></div>';
    $currentDir = base;
    die();
}

if ($action == "delete_folder")
{
    $rm = rmdir($currentDir."/".$_GET["dd"]);
    if (!$rm)
    {
        echo "<b>Der Ordner kann nur leer gel&ouml;scht werden!</b><br />Leite weiter...";
    }
    else
    {
        echo "Bitte warten...";
    }
    echo '<meta http-equiv="refresh" content="3; URL=index.php?action=fm&fm=dir">';
}
else if ($action == "new_folder")
{
    if ($_POST["submit"])
    {
        if ($dir != $_POST["dir"]) die('bot request detected');
        mkdir($currentDir.$_POST["name"], 0777);
        echo "Bitte warten...";
        echo '<meta http-equiv="refresh" content="0; URL=index.php?action=fm&fm=dir&dir='.$dir.'">';

    }
    else
    {
        echo '<form action="index.php?action=fm&fm=new_folder&dir='.$dir.'" method="POST">
                Wie soll der neue Ordner im Verzeichnis <b>'.$dir.'</b> hei&szlig;en? <br />
                <input type="text" name="name" /><br />
                <input type="submit" name="submit" class="btn btn-primary" />
                <input type="hidden" name="dir" value="'.$dir.'" />
              </form>';
    }
}
else if ($action == "link")
{

    echo 'Geben Sie bitte folgenden Link als Dateiquelle an: ';
    $url = "<br /><pre>http://".$_SERVER["HTTP_HOST"].$_SERVER["HTTP_PORT"].web_root."get.php?file=".$_GET["file"]."</pre>";
    echo $url;
    echo '<br /><br /><a href="javascript:window.close();">Fenster schlie&szlig;en</a>';
}
else if ($action == "upload")
{

    if ($_POST["submit"])
    {
        if ($dir != $_POST["dir"]) die('bot request detected');

        $file = $_FILES["file"];



        if ($file["size"]==0) die('<div class="alert alert-error">Keine Datei ausgew&auml;hlt.<br /></div>');
        $move = move_uploaded_file($file["tmp_name"], $currentDir."/".$file["name"]);
        if (!$move)
        {
            echo '<div class="alert alert-error">Fehler beim hochladen der Datei.<br /><br />Fehlerinformationen unten.<br /></div>';
            echo "<pre>";
            var_dump($file);
            echo "</pre>";
        }
        else
        {
            echo '<div class="alert alert-success">Datei hochgeladen<br /><a href="index.php?action=fm&fm=dir&dir='.$dir.'">Zur&uuml;ck</a></div>';
        }


    }
    else
    {

        echo '
               <div class="alert alert-info"><b>Beta Hinweis</b><br>Bitte keine Umlaute in den Dateinamen, dies kann zu Fehlern f&uuml;hren.</div><br />

               <form action="index.php?action=fm&fm=upload&dir='.$dir.'" method="POST" enctype="multipart/form-data">
                W&auml;hlen Sie eine Datei zum Upload in den Ordner <b>'.$dir.'</b> aus: <br />
                <input type="file" name="file" /><br />
                <input type="submit" name="submit" class="btn btn-primary" />
                <input type="hidden" name="dir" value="'.$dir.'" />
              </form>';

    }
}
else if ($action == "delete")
{
    unlink(realpath($currentDir)."/".$_GET["file"]);
    if (file_exists(realpath($currentDir)."/".$_GET["file"]))
    {
        echo '<div class="alert alert-warning"><b>Fehler</b><br />Leider stimmen die Zugriffsrechte nicht. Der Filemanager konnte die Datei nicht l&ouml;schen.<br />
        <a href="index.php?action=fm&fm=dir&dir='.$dir.'">Zur&uuml;ck</a></div>';
    }
    else
    {
        echo "Bitte warten...";
        echo '<meta http-equiv="refresh" content="0; URL=index.php?action=fm&fm=dir&dir='.$dir.'">';
    }


}
else if ($action == "dir")
{


    echo "<br />";

        echo '<a href="index.php?action=fm&fm=upload&dir='.$dir.'" class="btn">
                <i class="icon-upload"></i> Datei hochladen
              </a>

              <a href="index.php?action=fm&fm=new_folder&dir='.$dir.'" class="btn">
                <i class="icon-plus"></i> Neuer Ordner
              </a>
              <br />';
      echo "  <table class=\"table table-bordered table-stripped\">
            <thead>
            <th>Dateiname</th>
            <th>Gr&ouml;&szlig;e</th>
            <th>Typ</th>
            <th>Optionen</th>
            </thead>";

    $handle = opendir ($currentDir);

    $file_dir = realpath($currentDir);
    $s = explode(realpath(base), $file_dir);
    $file_dir = $s[1];

    while ($datei = readdir ($handle)) {

        if ($datei != "." AND $datei != ".htaccess" )
        {

            if (is_dir(realpath($currentDir)."/".$datei))
            {

                echo
                    "<tr>
                    <td><a href=\"index.php?action=fm&fm=dir&dir=".$dir."/$datei\">$datei</a></td>
                    <td></td>
                    <td>Ordner</td>
                    <td>
                        <a href=\"index.php?action=fm&fm=delete_folder&dd=$datei&dir=$dir\">
                            <img src=\"../../apps/com.gvisions.framework/icons/delete.png\" />
                        </a>
                    </td>
                </tr>"  ;
            }
            else
            {

                $info = getimagesize($currentDir.$datei);
                if ($info)
                {
                    $typ = $bildtypen[$info[2]];
                }
                else
                {
                    $typ = "n/a";
                }

                echo
                    "<tr>
                    <td>$datei</td>
                    <td>".filesize($currentDir.$datei)."b</td>
                    <td>$typ</td>
                    <td>
                        <a target=\"_blank\" href=\"".web_root."get.php?file=$file_dir/$datei\"><img src=\"../../apps/com.gvisions.framework/icons/camera.png\" /></a>&nbsp;&nbsp;
                        <a href=\"index.php?action=fm&fm=link&file=$dir/$datei\"><img src=\"../../apps/com.gvisions.framework/icons/link.png\" /></a>&nbsp;&nbsp;
                        <a href=\"index.php?action=fm&fm=delete&file=$datei&dir=$dir\"><img src=\"../../apps/com.gvisions.framework/icons/delete.png\" /></a>
                    </td>
                </tr>"  ;
            }


        }
    }
    closedir($handle);


    echo '</table>
    <small>Legende:</small> <img src="../../apps/com.gvisions.framework/icons/camera.png"> <small>Anzeigen</small> &nbsp; <img src="../../apps/com.gvisions.framework/icons/link.png"> <small>Direktlink anzeigen</small> &nbsp; <img src="../../apps/com.gvisions.framework/icons/delete.png"><small>L&ouml;schen</small>';
    echo "<br /><b>Aktuelles Verzeichnis: </b>". realpath($currentDir);

}