<?php

function connect()
{
  global $slbd;
  global $SQL_HOST;
  global $SQL_USER;
  global $SQL_PASSWD;
  global $SQL_DATABASE;
  global $slbd;
  $sldb = mysqli_connect($SQL_HOST, $SQL_USER, $SQL_PASSWD, $SQL_DATABASE);
}

function select($sldb, $fields, $from, $where = null, $orderby = null, $limit = null)
{
  $query = "SELECT $fields FROM $from";
  if ($where)
  {
    $query .= ' WHERE ' . $where;
  }
  if ($orderby)
  {
    $query .= ' ORDER BY ' . $orderby;
  }
  if ($limit)
  {
    $query .= ' LIMIT ' . $limit;
  }
  $query .= ';';
  $req = $sldb->query($query) or die('Erreur SQL !<br>'.$query.'<br>'.mysql_error());
  return $req;
}

function insert($sldb, $fields, $fields_values, $table) {
  $query = 'INSERT INTO ' . $table;
  $query .= ' (' . implode(',', $fields) . ')';
  $query .= ' VALUES (' . implode(',', $fields_values) . ');';
  return $sldb->query($query) or die('Erreur SQL !<br>' . mysql_error());
}

function sql_update($sldb, $table, $fields, $where)
{
  $query = "UPDATE $table SET $fields";
  if ($where)
  {
    $query .= ' WHERE ' . $where;
  }
  $query .= ';';
  $ret = $sldb->query($query) or die('Erreur SQL !<br>'.$query.'<br>'.mysql_error());
  return $ret;
}

function sql_delete($table, $where)
{
  mysqli_query("DELETE FROM $table WHERE $where");
}

function sql_disconnect()
{
  global $sldb;
  $sldb->close();
}
?>
