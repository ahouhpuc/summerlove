<?php

/*
 * Messages class aims to log and display various level of messages for debug,
 * information or security purpose.
 * This class is a singleton because of messages which need to be stored in a
 * single point.
 */
final class Messages {
  public $messages = Array('error' => Array(), 'warning' => Array(), 'info' => Array(), 'debug' => Array());
  public $popups = Array('error' => Array(), 'warning' => Array(), 'info' => Array(), 'debug' => Array());

  private static $_instance = NULL;
  private function __construct() {}
  public static function get_instance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new Messages();
    }
    return self::$_instance;
  }

  /*
   * Store a message with level.
   * Can be retrieve to be displayed with function get_messages()
   */
  private static function _add_message($lvl, $msg, $popup = TRUE) {
    self::get_instance()->messages[$lvl][] = $msg;
    if ($popup == TRUE) {
      self::_add_popup($lvl, $msg);
    }
  }
  /*
   * Store a message with level to be displayed in a popup.
   * Can be retrieve to be displayed with function get_popups()
   */
  private static function _add_popup($lvl, $msg) {
    self::get_instance()->popups[$lvl][] = $msg;
  }

  /*
   * Store a debug message only if session contains a debug key
   */
  public static function debug($msg, $popup = FALSE) {
    if (self::get_instance()->get_log_level() <= self::LOG_DEBUG) {
      self::_add_message('debug', $msg, $popup);
    }
  }

  /*
   * Store an info message
   */
  public static function info($msg, $popup = FALSE) {
    if (self::get_instance()->get_log_level() <= self::LOG_INFO) {
      self::_add_message('info', $msg, $popup);
    }
  }

  /*
   * Store a warning message
   */
  public static function warning($msg, $popup = FALSE) {
    if (self::get_instance()->get_log_level() <= self::LOG_WARN) {
      self::_add_message('warning', $msg, $popup);
    }
  }

  /*
   * Store an error message
   * If $tofile is true message is also stored in log file
   */
  public static function error($msg, $tofile = FALSE, $popup = FALSE) {
    if (self::get_instance()->get_log_level() <= self::LOG_ERROR) {
      self::_add_message('error', $msg, $popup);
      if ($tofile) {
        self::log_error($msg, true);
      }
    }
  }

  /*
   * Retrieve stored messages
   */
  public static function get_messages() {
    return self::get_instance()->messages;
  }
  /*
   * Retrieve stored messages
   */
  public static function get_popups() {
    return self::get_instance()->popups;
  }

  /*
   * Log message to log file
   */
  private static function log_message($msg, $level) {
    /*
    try {
      $uid = User::get_user()->get_id();
    } catch (Unidentified_User_Exception $uue) {
      $uid = 'Anonymous';
    }
    */
    error_log(date('[Y-m-d H:i:s]') . " [$level] [uid=$uid] $msg\n", 3, LOG_DIR . LOG_FILE_PREFIX . '.' . date('Y.m') . '.log');
  }
  public static function log_error($msg, $stacktrace = false) {
    if (self::get_instance()->get_log_level() <= self::LOG_ERROR) {
      if  ($stacktrace) {
        $msg .= "\n" . (new Exception())->getTraceAsString();
      }
      self::log_message($msg, 'error');
    }
  }
  public static function log_warning($msg) {
    if (self::get_instance()->get_log_level() <= self::LOG_WARN) {
      self::log_message($msg, 'warning');
    }
  }
  public static function log_info($msg) {
    if (self::get_instance()->get_log_level() <= self::LOG_INFO) {
      self::log_message($msg, 'info');
    }
  }
  public static function log_debug($msg) {
    if (self::get_instance()->get_log_level() <= self::LOG_DEBUG) {
      self::log_message($msg, 'debug');
    }
  }

  /*
   * /!\ For debug only /!\
   * Print array in pre tag only if session contains a debug key
   */
  public static function pre_print_r($var) {
    if (self::get_instance()->get_log_level() <= self::LOG_DEBUG) {
      echo '<pre>';
      print_r($var);
      echo '</pre>';
    }
  }

  const LOG_TRACE = 0;
  const LOG_DEBUG = 10;
  const LOG_INFO = 20;
  const LOG_WARN = 30;
  const LOG_ERROR = 40;
  const LOG_NONE = 100;
  private $log_level = self::LOG_INFO;
  public function set_log_level($level) {
    $this->log_level = $level;
  }
  public function get_log_level() {
    return $this->log_level;
  }


}
?>
