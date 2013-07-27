<?php
  $test = new gUserManagement();
  echo '<li>Breche Installation ab...</li>';
  $x = simplexml_load_file(root."temp/$xmlFileName");
  unlink (root."temp/$xmlFileName");
  if (file_exists(root."/temp/".basename($x->zipfile))) { unlink (root."/temp/".basename($x->zipfile));  }
  echo "<li>Fertig.</li>";
?>