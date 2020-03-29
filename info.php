<?php
$MSG_ID = 0;

function message($msg, $class_lvl) {
  global $MSG_ID;
  echo "<div id='message-$MSG_ID' class='message $class_lvl'>$msg<img onclick='document.getElementById(\"message-$MSG_ID\").style.display = \"none\";' src='images/delete.gif' style='cursor:pointer;float:right;padding-top:4px;padding-right:4px'></div>";
  $MSG_ID++;
}

function error($msg) {
  message($msg, 'error');
  return false;
}

function warning($msg) {
  message($msg, 'warning');
  return true;
}

function info($msg) {
  message($msg, 'info');
  return true;
}

?>
