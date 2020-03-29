<?php
function authenticate($login, $password) {
  global $sldb;
  require_once('sql.php');
  $ret = false;
  $password = MD5($password);
  $req = select($sldb, 'permission', 'user', "password='$password' AND login='$login'");
  if ($req->num_rows == 1) {
    $_SESSION['login'] = $login;
    $info = $req->fetch_assoc();
    $_SESSION['permission'] = $info['permission'];
    sql_update($sldb, 'user', 'last_login_date=NOW(), last_login_ip="' . $_SERVER['REMOTE_ADDR'] . '"', "login='$login'");
    $ret = true;
  }
  return $ret;
}

function logout() {
  $_SESSION = array();
  session_destroy();
  session_commit();
}

?>
