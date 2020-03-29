<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link rel="shortcut icon" href="http://www.ahouhpuc.fr/site/images/favicon.ico" />
  <script src="../jquery/jquery-2.1.4.min.js" type="text/javascript"></script>
  <script src="jquery-ui-1.10.0.custom/js/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="jquery-ui-1.10.0.custom/css/smoothness/jquery-ui-1.10.0.custom.min.css" />

  <link href='../jquery/plugin/tablesorter/2.21.4/dist/css/theme.default.min.css' rel="stylesheet">
  <script src="../jquery/plugin/tablesorter/2.21.4/dist/js/jquery.tablesorter.min.js" type='text/javascript'></script>

  <!-- radio and checkbox style -->
  <link href="icheck/skins/square/purple.css" rel="stylesheet">
  <script src="icheck/icheck.js"></script>
  <script src='summerlove.js'></script>

  <div id="fb-root"></div>
  <title>Summer Love - by Ah Ouh Puc</title>
</head>
<body>
<!-- facebook box -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- !facebook box -->
  <?php
    require_once 'settings.php';
    require_once 'header.php';
  ?>
  <div id='content'>
    <div id='menu'></div>
  <?php
    require_once 'sql.php';// connect();
    $puckup = select($sldb, '*', 'puckup', 'date > NOW()', null, '1')->fetch_assoc();
    
//    $puckup = $sldb->fetch_array(select('*', 'puckup', 'date > NOW()', null, '1'));
    if (isset($_POST['action'])) {
      if ($puckup['open'] == false) {
        error('Les (dés)inscriptions sont fermées !');
      } else {
        if ($_POST['action'] === 'delete_player') {
          $player = mysql_fetch_array(select($sldb, 'mail', 'player', 'id=' . $_POST['id']));
          if ($player['mail'] === $_POST['dmail']) {
            sql_delete('player', 'id='.$_POST['id']);
          } else {
            error("L'adresse mail renseignée ne correspond pas à celle de l'inscription");
          }
        } else if ($_POST['action'] === 'subscribe') {
          $inscrits = select($sldb, 'COUNT(id)', 'player', 'pid='.$puckup['id'])->fetch_row();
          $free_places = $MAX_PLAYERS - $inscrits[0];
          $ok = true;
          $waiting = 0;
          if ($free_places <= 0) {
            $waiting = 1;
          }
          if (!$_POST['firstname']) {
            $ok = error('Le champ <i>Prénom</i> est obligatoire.');
          }
          if (!$_POST['name']) {
            $ok = error('Le champ <i>Nom</i> est obligatoire.');
          }
          if (!$_POST['mail']) {
            $ok = error('Le champ <i>Mail</i> est obligatoire.');
          } else if (filter_var( $_POST['mail'], FILTER_VALIDATE_EMAIL ) === false) {
            $ok = error("Le <i>Mail</i> spécifié n'est pas valide.");
          }
          if (!$_POST['team']) {
            $ok = error('Le champ <i>Équipe</i> est obligatoire.');
          }
          if ($_POST['level'] < 0 || $_POST['level'] > 4) {
            $ok = error('<i>Experience</i> non valide.');
          }
          if (!isset($_POST['position'])) {
            $ok = error("Merci d'indiquer au moins un poste");
          }
          if (!isset($_POST['avail'])) {
            $ok = error("Merci d'indiquer au moins une disponibilité");
          }
          $player = select($sldb, 'id', 'player', "mail='" . $_POST['mail'] . "' AND pid=" . $puckup['id']);
          if ($player->num_rows > 0) {
            $ok = error('Un joueur est déjà inscrit avec cette adresse mail.');
          }
          if ($ok) {
            $success = insert($sldb, Array('pid', 'nickname', 'firstname', 'name', 'mail', 'team', 'level', 'gender', 'post', 'd1','d2','d3','d4','d5','d6','d7','d8','d9', 'waiting', 'subscribe_date', 'ip'),
                Array($puckup['id'],
                      empty($_POST['nickname']) ? 'NULL' : "'" . $sldb->real_escape_string($_POST['nickname']) . "'",
                      "'" . $sldb->real_escape_string($_POST['firstname']) . "'",
                      "'" . $sldb->real_escape_string($_POST['name']) . "'",
                      "'" . $sldb->real_escape_string($_POST['mail']) . "'",
                      "'" . $sldb->real_escape_string($_POST['team']) . "'",
                      $_POST['level'], "'${_POST['gender']}'",
                      "'" . implode(',', $_POST['position']) . "'",
                      intval(isset($_POST['avail'][1])), intval(isset($_POST['avail'][2])),
                      intval(isset($_POST['avail'][3])), intval(isset($_POST['avail'][4])),
                      intval(isset($_POST['avail'][5])), intval(isset($_POST['avail'][6])),
                      intval(isset($_POST['avail'][7])), intval(isset($_POST['avail'][8])),
                      intval(isset($_POST['avail'][9])),
                      $waiting,
                      'NOW()', "'${_SERVER['REMOTE_ADDR']}'"), 'player');
            $iid = $sldb->insert_id;
            if ($success == TRUE) {
              $headers = "From: summerlove@ahouhpuc.fr\r\n" .
                         "Bcc: summerlove@ahouhpuc.fr\r\n" .
                         "Reply-To: summerlove@ahouhpuc.fr\r\n" .
                         'Content-type: text/plain; charset=utf-8' . "\r\n";
                         'X-Mailer: PHP/' . phpversion();
              if ($waiting == 0) {
                info('Vous avez correctement été inscrit à la Summer Love ! Vous allez recevoir un mail de confirmation.');
                $mail_data = "Bonjour ${_POST['firstname']},

Nous avons bien reçu ton inscription pour l'édition $ANNEE de la Summer Love. Félicitations, tu as remonté la moitié du terrain mais ne relâche rien, il reste l'autre moitié pour scorer ta participation !

Les sessions auront lieu les JEUDI ".implode($DATES, ', ')." à partir de 19h30.
Après les matchs, RDV au Fleurus pour profiter des prix cassés du bar incontournable de l'été !

Pour valider ton inscription, il te reste à régler le player fee de 20€ à payer d'ici une semaine par virement bancaire (cf ci-dessous) en indiquant bien 'Summerlove' ET TON NOM (c'est important !).
Banque : LA BANQUE POSTALE
IBAN : FR21 2004 1000 0169 9959 9R02 073
BIC : PSSTFRPPPAR
Bénéficiaire : EUCF08

En cas de non-réglement dans les temps tu sera ajouté en bas de la liste d'attente.

Si tu as des questions, n'hésite pas à nous contacter en répondant directement à ce mail.

Nous reviendrons très prochainement vers toi pour t'annoncer ton équipe et te donner de plus amples informations sur le déroulement du tournoi.

À très vite sur les terrains et au Fleurus.

Disc and Love

-- 
L'Ah Ouh Puc team";
              } else {
                info("Vous avez correctement été ajouté à la liste d'attente ! Vous allez recevoir un mail de confirmation (Pensez à vérifier vos spams !).");
                $mail_data = "Bonjour ${_POST['firstname']},

Nous avons bien reçu ta demande d'inscription mais les places sont déjà toutes prises.
Tu as néanmoins été placé(e) sur liste d'attente et nous ne manquerons pas de te prévenir si une place se libère !

Si tu as des questions, n'hésite pas à nous contacter en répondant directement à ce mail.

-- 
L'Ah Ouh Puc team";
              }
              mail($_POST['mail'], "Inscription Summer Love $ANNEE", $mail_data, $headers);
            } else {
              error("Une erreur s'est produite durant l'incription, merci de réessayer ou de contacter <a href='mailto:summerlove@ahouhpuc.fr'>summerlove@ahouhpuc.fr</a>");
            }
          }
        }
      }
    }
    if ($puckup['id']) {
      $inscrits = select($sldb, 'IFNULL(nickname,firstname) AS name, level, team, paid', 'player', 'waiting = 0 AND pid='.$puckup['id'], 'level, name');
      $waiting_list = select($sldb, 'IFNULL(nickname,firstname) AS name, level, team', 'player', 'waiting = 1 AND pid='.$puckup['id'], 'subscribe_date ASC, level, name');
    }
    $free_places = $MAX_PLAYERS - $inscrits->num_rows;
  ?>
      <div id='content-spacer'>
      <div style='display:inline-block;width:100%;'>
      <!-- Incription -->
      <div id='inscription' class='box'>
        <?php
          if ($puckup['id']) {
            $date = date('d/m/Y à H\hi', strtotime($puckup['date']));
            $next_puckup_header = "Début de la Summer Love le $date";
          } else {
            $next_puckup_header = "La prochaine Summer Love n'est pas encore prévue";
          }
          echo "<div class='box-header'>$next_puckup_header</div>\n";
          if ($puckup['open'] == true) {
            require('subscribe_open.php');
          } else {
            echo<<<END
<div class='box-content' style='text-align:center'>
                Désolé, les inscriptions sont fermées.
              </div>
END;
          }
        ?>
      </div>
      <!-- Inscription -->

      <!-- Principe -->
      <div id='principe' class='box'>
        <div class='box-header'>Informations</div>
        <div class='box-content'>
          <ul>
            <li>Player Fee: 20€. Paiement par virement, 1 semaine maximum après l'inscription.</li>
            <li><a href='https://www.google.com/maps/place/81+Boulevard+Mass%C3%A9na/@48.8205033,2.3671874,17z/data=!3m1!4b1!4m2!3m1!1s0x47e6722b945cb859:0x706150b867ec550e'>Stade Carpentier</a><br>
              81, boulevard Masséna<br>
              75013 Paris
            </li>
            <?php $players_per_team = $MAX_PLAYERS / $MAX_TEAMS; echo "<li>$MAX_PLAYERS inscrits maximum, soit $MAX_TEAMS équipes de $players_per_team personnes</li>\n";?>
            <li>9 matchs d'1 heure, 15 points, répartis sur <?php echo count($DATES) ?> dates</li>
            <li>Un punch de bienvenue et une Beer Race</li>
            <li>Un (des) verre(s) d'après match au <a href='http://goo.gl/maps/qn518'>Fleurus</a> à tarif préférentiel !</li>
            <li>Pour plus d'information contactez-nous à l'adresse <a href='mailto:summerlove@ahouhpuc.fr'>summerlove@ahouhpuc.fr</a></li>
            <br><div class="fb-like-box" data-href="https://facebook.com/ahouhpuc" data-width="292" data-show-faces="false" data-stream="false" data-show-border="true" data-header="false"></div>
          </ul>
        </div>
      </div>
      <!-- !Principe -->

      <div id='principe' class='box' style='margin-top:10px;float: <?=$puckup['open'] ? 'right' : 'left'?>'>
        <div class='box-header'>Planning & Résultats</div>
        <div class='box-content'>
          <div><a href='https://docs.google.com/spreadsheets/d/1LXYiSBUxw8uzoc1H8KRXK6NecYAB59cyDzXSAtj8swM/' target='_blank'>Édition 2019 : Dessins animés</a></div>
          <div><a href='<?=$BASE_URL?>/planning2018.php' target='_blank'>Édition 2018 : Flower Power</a></div>
          <div><a href='<?=$BASE_URL?>/planning2017.php' target='_blank'>Édition 2017 : SuMEUH Love, le tournoi des bêtes de l'ultimate</a></div>
          <div><a href='<?=$BASE_URL?>/planning2016.php' target='_blank'>Édition 2016 : Voyage dans le temps</a></div>
          <div><a href='http://summerlove.ahouhpuc.fr/planning2015.php' target='_blank'>Édition 2015 : Western</a></div>
          <div>Édition 2014 : Candy</div>
          <div><a href='http://summerlove.ahouhpuc.fr/planning2013.php' target='_blank'>Édition 2013 : Jeux Vidéo</a></div>
          <div>Édition 2012 : Séries TV</div>
          <div>Édition 2011 : Boys & Girls Bands</div>
          <div>Édition 2010 : Super-Héros</div>
          <div>Édition 2009 : Cocktail</div>
          <div>Édition 2008 : Summer Love</div>
        </div>
      </div>


      </div>

      <!-- Listing -->
      <div class='box'>
        <?php
          echo "<div class='box-header'>Les inscrits ($free_places places restantes)</div>\n";
        ?>
        <table id='listing' cellspacing="0" border='1' class='box-content tablesorter'>
          <thead>
          <tr>
            <th style='width: 1px'></th>
            <th>Nom</th>
            <th>Experience</th>
            <th>Club</th>
          </tr>
          </thead>
          <tbody>
          <?php
            if ($puckup['open'] == true) {
              while ($inscrit = $inscrits->fetch_assoc())
              {
                $paid = $inscrit['paid'] == 1 ? '<img src="images/ok.png" width=15px style="vertical-align: middle" title="Paiement reçu" alt="ok">' : '';
                $level = $LEVELS[$inscrit['level']];
                echo "          <tr>
            <td>$paid</td>
            <td style='width:30%'>${inscrit['name']}</td>
            <td style='auto'>$level</td>
            <td style='width:30%'>${inscrit['team']}</td>
          </tr>\n";
              }
            }
          ?>
          </tbody>
        </table>
      </div>
      <!-- !Listing -->

      <!-- Listing -->
      <?php
        if ($waiting_list->num_rows > 0) {
      ?>
      <div class='box' style='margin-top:5px'>
        <div class='box-header'>Liste d'attente</div>
        <table id='listing' cellspacing="0" border='1' class='box-content'>
          <tr>
            <th>Nom</th>
            <th>Experience</th>
            <th>Club</th>
          </tr>
          <?php
            while ($inscrit = $waiting_list->fetch_assoc())
            {
              $level = $LEVELS[$inscrit['level']];
              echo "          <tr>
            <td style='width:30%'>${inscrit['name']}</td>
            <td style='auto'>$level</td>
            <td style='width:30%'>${inscrit['team']}</td>
          </tr>\n";
            }
          ?>
        </table>
      </div>
      <?php } ?>
      <!-- !Listing -->
      </div>
    </div>
  </body>
</html>

