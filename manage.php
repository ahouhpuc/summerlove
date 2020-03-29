<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <title>Summer Love - Administration</title>
</head>
<body>
  <?php
    require_once 'settings.php';
    require_once 'sql.php';
    require_once 'header.php';
    require_once 'team.php';

//    connect();
    /*
     * Move a player to the end of the waiting list.
     * If $rescue_waiting is TRUE take the first player of the waiting list and set him as in.
     * If $mail_rescue is TRUE, send a mail to the rescued player to inform him he's in
     */
    function queue_player($pid, $rescue_waiting = TRUE, $mail_rescue = FALSE) {
      global $sldb;
      if ($sldb->query("UPDATE `player` SET waiting = TRUE, subscribe_date = NOW() WHERE id = $pid") == TRUE) {
        if ($rescue_waiting == TRUE) {
          $wp = $sldb->query("SELECT id, firstname, nickname, lastname FROM `player` WHERE waiting IS TRUE AND pid = $pid ORDER BY subscribe_date ASC LIMIT 1")->fetch_assoc();
          if ($wp != NULL) {
            rescue_player($wp['id']);
          } else {
            info("Aucun joueur sur liste d'attente");
          }
        }
      } else {
        error("Echec de mise sur liste d'attente");
      }
    }
    function rescue_player($pid, $mail = FALSE) {
      global $sldb;
      if ($sldb->query("UPDATE `player` SET waiting = FALSE, subscribe_date = NOW() WHERE id = $pid") == TRUE) {
        if ($mail_rescue == TRUE) {
          // XXX TODO
        }
      } else {
        error("Echec de repêchage de file d'attente du joueur");
      }
    }
  ?>
  <div id='content'>
    <?php
      if (isset($_POST['action'])) {
        if ($_POST['action'] === 'authenticate') {
          require_once('authentication.php');
          if (authenticate($_POST['login'], $_POST['password']) == true) {
            info('Authentification réussie');
          } else {
            error('Mauvais identifiant ou mot de passe incorrect');
          }
        } else if ($_POST['action'] === 'logout') {
          require_once('authentication.php');
          logout();
        }
      }
      if ($_SESSION['login']) {
        if (isset($_POST['action'])) {
          switch ($_POST['action']) {
            case 'doTeams':
              $teams = doTeams(isset($puckup) ? $puckup['id'] : NULL);
              break;
            case 'edit':
              $fields = 'paid = ' . ((int)isset($_POST['paid']));
              $fields .= ', color = ' . ((int)$_POST['team']);
              $fields .= ', level=' . $_POST['level'];
              for ($dispo = 1; $dispo <= 9; ++$dispo) {
                $fields .= ', d' . $dispo . ' = ' . ((int) isset($_POST["d$dispo"]));
              }
              sql_update($sldb, 'player', $fields, "id=${_POST['id']}");
              break;
            case 'queue_player':
              queue_player($_POST['pid']);
              break;
            case 'rescue_player':
              rescue_player($_POST['pid']);
              break;
          }
        }
        $teams = getTeams(isset($puckup) ? $puckup['id'] : NULL);
        $puckup = select($sldb, 'id, date, open', 'puckup', null, 'id DESC', '1')->fetch_assoc();
        if (isset($_POST['action']) && $_POST['action'] === 'switch') {
          if ($_POST['send_mail']) {
            //sendMail($teams, $puckup['date']);
          }
          sql_update($sldb, 'puckup', 'open = !open', 'id=' . $puckup['id']);
          $puckup['open'] = !$puckup['open'];
        }
        $wait_list = $sldb->query('SELECT * FROM `player` WHERE pid = '.$puckup['id'].' AND waiting IS TRUE ORDER BY subscribe_date ASC');
        if ($puckup['open'] == true) {
          $send_mail = /**/''; /**'<input type="checkbox" name="send_mail"> Mailer les joueurs';/**/
          $open_or_close = Array('ouvertes', 'Fermer');
        } else {
          $send_mail = '';
          $open_or_close = Array('fermées', 'Ouvrir');
        }
        echo<<<END
        <div id='content-spacer'>
        <div>Bonjour ${_SESSION['login']}
          <form method='POST' style='float:right'>
            <input type='hidden' name='action' value='logout'>
            <input type='submit' value='Se déconnecter'>
          </form>
        </div>
        <div class='spacer'></div>
        <div class='box'>
          <div class='box-header'>
            Les inscriptions à la Summer Love sont actuellement $open_or_close[0]
          </div>
          <form method='POST' class='box-content'>
            <input type='hidden' name='action' value='switch'>
            <input type='hidden' name='pid' value='${puckup["id"]}'>
            $send_mail
            <input type='submit' style='width:100%;height:40px' value='$open_or_close[1] les inscriptions'>
          </form>
          <form method='POST' class='box-content'>
            <input type='hidden' name='action' value='doTeams'>
            <input type='submit' style='width:100%;height:40px' value='Génerer les équipes'>
          </form>
      </div>
      <div class='box' style='margin-top: 10px'>
        <div style='padding: 10px'>
          <u>Paiements :</u>
          <div>Vert: OK</div>
          <div>Orange: En attente de paiement</div>
          <div>Rouge: Non payé depuis plus d'une semaine</div>
        </div>
      </div>
END;
        $nb_dates = count($DATES);
        $mails = Array();
        $not_paid = Array();
        $not_paida_exp = Array();
        foreach ($teams as $key => $team) {
          $tname = $TEAM_COLORS[$key][0];
          $bg = $TEAM_COLORS[$key][1];
          echo<<<END
        <div class='spacer'></div>
        <div class='box'>
          <div class='box-header' style='background-color:$bg'>Équipe $tname</div>
          <table cellspacing="0" border style='margin:1%;border-collapse:collapse;border: 1px solid #623A92;width:98%' class='box-content'>
            <thead>
            <tr>
              <th rowspan=2>⚤</th>
              <th rowspan=2>Nom</th>
              <th rowspan=2>Niveau</th>
              <th rowspan=2>Postes</th>
              <th rowspan=2>Club</th>
              <th colspan=$nb_dates>Dispo</th>
              <th rowspan=2>Paiement</th>
              <th rowspan=2>Équipe</th>
              <th rowspan=2 style='width:1px'><!-- Save --></th>
              <th rowspan=2 style='width:1px'><!-- Put on Wait List --></th>
            </tr>
            <tr>
END;
            foreach ($DATES as $d => $date) {
              $dispos[$d] = ['M' => 0, 'F'=>0];
              echo "              <th>$date</th>\n";
            }
            echo<<<END
            </tr>
            </thead>
            <tbody>
END;
          $gender = Array('M' => '♂', 'F' => '♀');
          $team_mails = [];
          $not_paid_exp = [];
          foreach ($team as $player) {
            $levels = "<select name='level'>";
            foreach ($LEVELS as $lvl => $lvl_name) {
              $s = ($lvl == $player['level'] ? 'selected' : '');
              $levels .= "<option value='$lvl' $s>$lvl_name</option>";
            }
            $levels .= "</select>";
            $mails[] = $player['mail'];
            $team_mails[] = $player['mail'];
            if ($player['nickname']) {
              $player['nickname'] = "`<i>${player['nickname']}</i>`";
            }
            $cbase = '<input type=checkbox name="d';
            foreach ($DATES as $dispo => $date) {
              if ($player["d$dispo"] == 1)
                $dispos[$dispo][$player['gender']]++;
              $player["d$dispo"] = $cbase . $dispo . '"' . ($player["d$dispo"] == 1 ? /*"&#10003;"*/'checked' : '') . '>';
            }
            if ($player['paid'] == 1) {
              $player['paid'] = '<td style="text-align:center;background-color:green"><input name="paid" type="checkbox" checked></td>';
            } else {
              $not_paid[] = $player['mail'];
              $exp_days = date_diff(new DateTime($player['subscribe_date']), new DateTime('now'), true)->days;
              if ($exp_days >= 7) {
                $not_paid_exp[] = $player['mail'];
              }
              $player['paid'] = "<td title='inscrit le $player[subscribe_date]' style='text-align:center;background-color:" . ($exp_days >= 7 ? 'red' : 'orange') . "'><input name='paid' type='checkbox'></td>";
            }
            echo<<<END
            <tr class='player'>
              <form method='POST'>
              <input type='hidden' name='action' value='edit'>
              <input type='hidden' name='id' value='${player["id"]}'>
              <td style='text-align: center'>${gender[$player['gender']]}</td>
              <td>$player[firstname] $player[nickname] $player[name]<br>$player[mail]</td>
              <td>$levels</td>
              <td>${player['post']}</td>
              <td>${player['team']}</td>
END;
            foreach ($DATES as $id => $date) {
              $pd = $player["d$id"];
              echo "<td style='text-align:center'>$pd</td>";
            }
            echo $player['paid'];
            echo("<td><select name='team'>");
            foreach ($TEAM_COLORS as $tcid => $color) {
              $selected_team = ($key == $tcid ? 'selected' : '');
              echo "<option value='$tcid' $selected_team>$color[0]</option>";
            }
            echo("</select></td>");

            echo<<<END
              <td><input type='submit' value='OK'></td>
              </form>
              <td title='Mettre le joueur sur liste d attente'><form method='POST'>
                <input type='hidden' name='action' value='queue_player'>
                <input type='hidden' name='pid' value='$player[id]'>
                <input type='submit' value='⇩' style='color:darkred'>
              </form></td>
            </tr>
END;
          }
          $team_mails = implode(', ', $team_mails);
          echo<<<END
              <tr>
                <th colspan=5>Total</th>
END;
          foreach ($dispos as $d) {
            echo "<td style='text-align:center' title='$d[M] hommes et $d[F] femmes'>".($d['M']+$d['F'])."</td>";
          }
          echo<<<END
                <td colspan=4></td>
              </tr>
            </tbody>
          </table>
            <div>$team_mails</div>
        </div>

END;
        }
        echo "<div id='wait_list' class='box' style='margin-top: 10px'>
          <div class='box-header'>Liste d'attente</div>
          <div class='box-content'>
            <table cellspacing='0' border style='margin:1%;border-collapse:collapse;border: 1px solid #623A92;width:98%' class='box-content'>
            <thead>
            <tr>
              <th rowspan=2>⚤</th>
              <th rowspan=2>Nom</th>
              <th rowspan=2>Niveau</th>
              <th rowspan=2>Postes</th>
              <th rowspan=2>Club</th>
              <th colspan=$nb_dates>Dispo</th>
              <th colspan=2 rowspan=2>Inscrit le</th>
            </tr>
            <tr>";
            foreach ($DATES as $d => $date) {
              $dispos[$d] = ['M' => 0, 'F'=>0];
              echo "              <th>$date</th>\n";
            }
            echo "</tr>
            </thead>
            <tbody>";
        while ($player = $wait_list->fetch_assoc()) {
          echo "<tr>
              <td>" . $gender[$player['gender']] . "</td>
              <td>
                $player[firstname] " . (empty($player['nickname']) ? '' : "`$player[nickname]`") . " $player[name]
                <br>
                $player[mail]
              </td>
              <td>" . $LEVELS[$player['level']] . "</td>
              <td>$player[post]</td>
              <td>$player[team]</td>";
          foreach ($DATES as $id => $date) {
            echo "<td style='text-align: center'><input type='checkbox' readonly disabled " . ($player["d$id"] ? 'checked' : '') . "></td>";
          }
          echo "
            <td style='text-align:center'>$player[subscribe_date]</td>
            <td style='text-align:center'><form method='POST'>
              <input type='hidden' name='pid' value='$player[id]'>
              <input type='hidden' name='action' value='rescue_player'>
              <input type='submit' value='Repêcher'>
           </form></td>
          </tr>";
        }
        echo "  </tbody>
              </table>
            </div>
          </div><!-- !#wait_list -->"; 
        $mails = implode(', ', $mails);
        echo<<<END
    <div>
    <h3>Inscrits :</h3>
    $mails
    </div>
END;
        $np_count = count($not_paid);
        $mails = implode(', ', $not_paid);
        $np_exp_count = count($not_paid_exp);
        $np_exp_mails = implode(', ', $not_paid_exp);
        echo<<<END
    <br>
    <div>
    <h3>$np_count inscrits n'ayant pas payé :</h3>
    $mails
    </div>
    <div>
      <h3>$np_exp_count inscrits n'ayant pas payé dans la semaine</h3>
      $np_exp_mails
    </div>
END;
      } else {
        echo<<<END
<div id='content-spacer'><div id='authentication' class='box'>
      <div class='box-header'>Authentification</div>
      <form class='box-content' method='POST'>
          <label>Identifiant :</label><input class='input-text' type='text' name='login' value='${_POST["login"]}'>
          <label>Mot de passe :</label><input class='input-text' type='password' name='password' value='${_POST["password"]}'>
          <input type='hidden' name='action' value='authenticate'>
          <input type='submit' value="S'identifier" style='width:100%'>
      </form>
    </div></div>

END;
      }
    ?>
    </div>
  </div>
</body>
</html>
<?php
  sql_disconnect();
?>
