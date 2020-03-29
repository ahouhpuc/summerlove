<?php

require_once('Messages.class.php');

final class Database extends mysqli {
  function __construct($host = SQL_HOST, $user = SQL_USER, $passwd = SQL_PASSWD, $db_name = SQL_DB_NAME) {
    parent::__construct($host, $user, $passwd, $db_name);
    if ($this->connect_errno) {
      Messages::log_error('Database connection error: ' . $this->connect_error);
      throw new Exception('Database connection error: ' . $this->connect_error);
    }
    if (!$this->set_charset('utf8')) {
      Messages::log_error('Set database charset error: ' . $this->error);
      throw new Exception('Set database charset error: ' . $this->error);
    }
    $this->_host = $host;
    $this->_db = $db_name;
  }

  private $_host;
  function get_host() {
    return $this->_host;
  }
  private $_db;
  function get_db_name() {
    return $this->_db;
  }

  private $query_count = 0;
  private $query_failure = 0;
  function query($query, $resultmode = MYSQLI_STORE_RESULT) {
    $this->query_count++;
    $result = parent::query($query, $resultmode);
    if (!$result) {
      $this->query_failure++;
      Messages::log_error("[$this->_db@$this->_host] Invalid query `$query`: $this->error", true);
    }
    return $result;
  }
  function prepare($query) {
    $stmt = parent::prepare($query);
    if (!$stmt) {
      Messages::log_error("[$this->_db@$this->_host] Invalid prepared statement `$query`: $this->error", true);
    }
    return $stmt;
  }

  function __destruct() {
    Messages::log_debug("[$this->_db@$this->_host] Database - " . $this->query_count . " queries executed - " . $this->query_failure . " queries failed");
    $this->close();
  }
}

?>
