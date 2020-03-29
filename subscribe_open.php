<?php
  $teams = select($sldb, 'DISTINCT team', 'player', NULL, 'team');
  echo "<script>
  $(function() {
  $('#team').autocomplete({minLength: 0, source: [";
  while ($team = $teams->fetch_assoc()) {
    echo "'" . addslashes($team['team']) . "',";
  }
  echo "]}).focus(function() { $(this).autocomplete('search','')});
  });
  </script>";
?>
        <form class='box-content' method='POST'>
          <div><label>Surnom (optionnel) :</label><input class='input-text' name='nickname' value='<?=$_POST["nickname"]?>'></div>
          <div><label>Prénom :</label><input class='input-text' name='firstname' value='<?=$_POST["firstname"]?>' required></div>
          <div><label>Nom :</label><input class='input-text' name='name' value='<?=$_POST["name"]?>' required></div>
          <div><label>Mail :</label><input id='mail-input' class='input-text' name='mail' value='<?=$_POST["mail"]?>' required></div>
          <div><label>Club : </label><input id='team' class='input-text' name='team' value='<?=$_POST["team"]?>' required></div>
          <div style='display:inline-block;width:100%;margin-top:10px'>
          <div style='float:left;width:auto'>
            <h4 style='color:#623A92'>Experience :</h4>
<?php
  foreach ($LEVELS as $key => $level) {
    echo "            <input required type='radio' name='level' value='$key'";
    if ($_POST['level'] === "$key")
      echo ' checked';
    echo "><span class='label'>$level</span>\n";
    if (($key + 1) % 3 == 0) {
      echo "<br><br>";
    }
  }
?>
            <h4 style='color:#623A92'>Genre :</h4>
<?php
  if ($_POST['gender'] == 'F') {
    $fchecked = $mchecked;
    $mchecked = '';
  } else if ($_POST['gender'] == 'M') {
    $mchecked = "checked";
    $fchecked = '';
  }
  echo<<<END
            <input type='radio' name='gender' value='M' required $mchecked><span class='label'>M (♂)</span>
            <input type='radio' name='gender' value='F' required $fchecked><span class='label'>F (♀)</span>
END;
?>
          </div>
          </div>
          <div>
            <h4 style='color:#623A92'>Postes :</h4>
            <input type='checkbox' name='position[handler]' value='handler' <?php if (isset($_POST['position']['handler'])) { echo 'checked';} ?>><span class='label'>Handler</span>
            <input type='checkbox' name='position[middle]' value='middle' <?php if (isset($_POST['position']['middle'])) { echo 'checked';} ?>><span class='label'>Middle</span>
            <input type='checkbox' name='position[long]' value='long' <?php if (isset($_POST['position']['long'])) { echo 'checked';} ?>><span class='label'>Long</span>
          </div>
          <div>
            <h4 style='color:#623A92'>Disponibilités :</h4>
<?php
            foreach ($DATES as $d => $date) {
              $checked = (isset($_POST['avail'][$d]) ? 'checked' : '');
                echo "            <input type='checkbox' name='avail[$d]' $checked><span class='label'>$date</span>\n";
            }
?>
          </div>
          <input type='hidden' name='action' value='subscribe'>
          <script>
            function confirm_mail() {
              var mailvalue = document.getElementById('mail-input').value;
              var mail = prompt('Merci de bien vouloir confirmer votre mail afin de finaliser votre inscription');
              if (mailvalue == '' || mailvalue != mail) {
                alert('Les deux adresses mail ne correspondent pas');
                return false;
              }
            }
          </script>
          <input id='subscribe' type='submit' value="Let's Love!">
        </form>
