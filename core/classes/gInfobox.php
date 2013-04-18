<?php
class infobox extends gFramework {
  function showFatalError($msg) {
  ?>
 <SCRIPT LANGUAGE="JavaScript">
<!-- Hide from older browsers
alert("<?=$msg?>");
// end hiding -->
</SCRIPT>
<?php
  }
}