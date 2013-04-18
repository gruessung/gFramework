<?php
$test = new UserManagement();
?>
Lesen Sie sich die Bestimmungen durch und akzeptieren Sie diese:<br>
<?php
  $xml = simplexml_load_file(root."temp/$xmlFileName");
  $license = $xml->license;
?>
<textarea rows="10" cols="35" disabled><?=$license?></textarea>        <br>
<a href="index.php?action=download&step=0&srv=<?=$srv?>&file=<?=$xmlFileName?>">Ich akzeptiere NICHT</a> - <a href="index.php?action=download&step=3&srv=<?=$srv?>&file=<?=$xmlFileName?>">Ich akzeptiere</a>