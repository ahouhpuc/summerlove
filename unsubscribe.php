<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <title>PUCk Up</title>
  <script>
    function setFocus()
    {
      document.getElementById("dmail").focus();
    }
  </script>
</head>
<body onLoad="setFocus()">
  <?php
    require_once 'settings.php';
    require_once 'header.php';
    require_once 'sql.php'; connect();
  ?>
  <div id='content'>
    <div class='spacer'></div>
    <div id='listing' class='box'>
      <div class='box-header'>Veuillez spécifier le mail utilisé lors de votre insription</div>
      <?php echo "<form method='POST' action='$BASE_URL/index.php'>"; ?>
        <input type='hidden' name='action' value='delete_player'>
        <?php
          echo "          <input type='hidden' name='id' value=\"${_POST['id']}\">\n";
        ?>
        <div style='text-align:center;'><input id='dmail' name='dmail' style='text-align:center;width:95%' type='text'></div>
        <input style='width:100%' type='submit' value='Désincription'>
      </form>
    </div>
    <div class='spacer'></div>
  </div>
</body>
</html>

