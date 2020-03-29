<?php

require_once('settings.php');
require_once('sql.php');

function doTeams($pid = null) {
//  return getTeams($pid);
  global $MAX_PLAYERS, $MAX_TEAMS, $sldb;
  if (!$pid) {
    $puckup = select($sldb, 'id', 'puckup', null, 'id DESC', '1')->fetch_assoc();
    $pid = $puckup['id'];
  }
  $players = select($sldb, '*', 'player', "waiting IS FALSE AND pid=$pid", 'gender ASC, level DESC, RAND(), firstname ASC');
  $nbPlayers = $players->num_rows;
//  $MAX_PLAYER_PER_TEAM = $MAX_PLAYERS / $MAX_TEAMS;
//  $nbTeams = floor($nbPlayers / $MAX_PLAYER_PER_TEAM + ($nbPlayers % $MAX_PLAYER_PER_TEAM != 0 ? 1 : 0));
  $nbTeams = $MAX_TEAMS;
  $nbPlayersPerTeam = (int) ($nbPlayers / $nbTeams);
  $sparePlayers = $nbPlayers % $nbTeams;
  $teams = Array();
  for ($i = 1; $i <= $nbTeams; ++$i) {
    $teams[$i] = Array();
  }
  $cteam = 1;
  while ($player = $players->fetch_assoc()) {
    sql_update($sldb, 'player', "color=$cteam", "id=$player[id]");
    $teams[$cteam][] = $player;
    $cteam = ($cteam + 1 > $nbTeams ? 1 : $cteam + 1);
  }
  return $teams;
}

function getTeams($pid = NULL) {
  global $sldb;
  if (!$pid) {
    $puckup = select($sldb, 'id', 'puckup', null, 'id DESC', '1')->fetch_assoc();
    $pid = $puckup['id'];
  }
  $players = select($sldb, '*', 'player', "waiting IS FALSE AND pid=$pid", 'color ASC, gender, level, firstname');
  $teams = [];
  while ($player = $players->fetch_assoc()) {
    $teams[$player['color']][$player['id']] = $player;
  }
  return $teams;
}

function sendMail($teams, $pdate) {
  global $TEAM_COLORS;
  foreach ($teams as $key => $team) {
    $content = "Bonjour à tous,

Quelques infos pour le prochain PUCk Up :

- Début des matchs à 19h30, venez à 19h afin de vous échauffer correctement !
- Dans chaque équipe une personne possède un (*) à coté de son nom, il s'agit du capitaine !
- Essayez d'avoir un tshirt de la couleur de votre équipe si vous voulez éviter les chasubles qui puent.
- J'ai fait 4 mailings (un par équipe). Vous pouvez reply-all si vous voulez contacter votre équipe.
- Si vous avez des questions, suggestions, … n'hésitez pas à contacter Tic (pasquet.syl@gmail.com) et/ou moi-même (unicorn777@gmail.com / 06.78.30.64.24).
- Planning des matchs :
 19h30 -> 20h10 : rouge VS blanc  et  bleu VS jaune
 20h15 -> 20h55 : rouge VS bleu   et  blanc VS jaune
 21h00 -> 21h45 : rouge VS jaune  et  blanc VS bleu
- After au Fleurus !

===============

";
    $content .= "Équipe " . $TEAM_COLORS[$key][0] ."\n";
    $content .= "----------------\n";
    $recipients[$key] = '';
    $first = true;
    foreach ($team as $player) {
      if ($first == false) {
        $recipients[$key] .= ', ';
      }
      $recipients[$key] .= '"' . $player['firstname'] . ' ' . $player['name'] . '" <' . $player['mail'] . '>';
      $content .= "- " . $player['firstname'];
      if (!empty($player['nickname'])) {
        $content .= ' `' . $player['nickname'] . '`';
      }
      $content .= ' ' . $player['name'] . ' (' . $player['team'] . ")\n";
    }
    $content .= "\n\n";
    $content .= "Ultimatement vôtre.\n";
    $headers = 'From: summerlove@ahouhpuc.fr' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    $subject = '[Summer Love ' . date('Y', strtotime($pdate)) . '] Équipe ' . $TEAM_COLORS[$key][0];
    /*
    echo "<pre>" .
         "Subject: $subject\n" .
          "To: $to" .
          "</pre>";
    */
    //mail($to, $subject, $content, $headers);
    mail("unicorn777@gmail.com", $subject, $content . "\n\n" . $to , $headers);
  }
}

?>
