<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alexander
 * Date: 14.10.13
 * Time: 17:35
 * To change this template use File | Settings | File Templates.
 */

$file = $_GET["file"];
if (empty($file)) die();
$f = "./core/cp/filemanager$file";

$info = getimagesize($f);

$file_name = explode("/", $file);
$file_name = $file_name[ count($file_name) - 1];


if ($info == false)
{

     header("Content-type: application/x-download");
     header("Content-Disposition: attachment; filename=$file_name");

     readfile($f);

}
else
{
    switch($info[2]) {

        case 1: //gif
            header("Content-type: image/gif");
            break;
        case 2: // jpeg
            header("Content-type: image/jpeg");
            break;
        case 3: // png
            header("Content-type: image/png");
            break;
        case 4: // jpg
            header("Content-type: image/jpg");
            break;
    }
    readfile($f);
}
