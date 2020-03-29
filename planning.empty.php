<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link rel="shortcut icon" href="http://www.ahouhpuc.fr/site/images/favicon.ico" />
  <title>Summer Love - by Ah Ouh Puc</title>
</head>
<body style='width:75%'>
  <style type='text/css'>
    td
    {
      text-align:center;
    }
    .score
    {
      background-color: lightgrey;
      width:35px;
    }
    .black
    {
      width: 1px;
      background-color: black;
    }
  </style>
<?php
   $team['classement'] = Array('style' => 'background-color:lightgrey', 'name' => 'Classement');
   $team['rouge'] = Array('style' => 'background-color:red', 'name' => 'rouge');
   $team['jaune'] = Array('style' => 'background-color:gold', 'name' => 'jaune');
   $team['bleue'] = Array('style' => 'background-color:DodgerBlue', 'name' => 'bleue');
   $team['orange'] = Array('style' => 'background-color:orange', 'name' => 'orange');
   $team['verte'] = Array('style' => 'background-color:green', 'name' => 'verte');
   $team['blanche'] = Array('style' => 'background-color:white', 'name' => 'blanche');
   $team['violette'] = Array('style' => 'background-color:orchid', 'name' => 'violette');
   $team['noire'] = Array('style' => 'background-color:black;color:white', 'name' => 'noire');
   $planning['juillet']['09'] = Array(
                              'h1' => Array(
                                 't1' => Array('bleue', 'blanche'), 's1' => Array('  ', '  '),
                                 't2' => Array('rouge', 'verte'), 's2' => Array('  ', '  '),
                                 't3' => Array('jaune', 'violette'), 's3' => Array('  ', '  '),
                                 't4' => Array('orange', 'noire'), 's4' => Array('  ', '  ')
                                ),
                              'h2' => Array(
                                 't1' => Array('rouge', 'bleue'), 's1' => Array('  ', '  '),
                                 't2' => Array('orange', 'jaune'), 's2' => Array('  ', '  '),
                                 't3' => Array('noire', 'violette'), 's3' => Array('  ', '  '),
                                 't4' => Array('blanche', 'verte'), 's4' => Array('  ', '  ')
                                )
       );
   $planning['juillet'][16] = Array(
                              'h1' => Array(
                                 't1' => Array('noire', 'jaune'), 's1' => Array('  ', '  '),
                                 't2' => Array('bleue', 'verte'), 's2' => Array('  ', '  '),
                                 't3' => Array('blanche', 'violette'), 's3' => Array('  ', '  '),
                                 't4' => Array('orange', 'rouge'), 's4' => Array('  ', '  ')
                                ),
                              'h2' => Array(
                                 't1' => Array('noire', 'verte'), 's1' => Array('  ', '  '),
                                 't2' => Array('bleue', 'jaune'), 's2' => Array('  ', '  '),
                                 't3' => Array('orange', 'violette'), 's3' => Array('  ', '  '),
                                 't4' => Array('blanche', 'rouge'), 's4' => Array('  ', '  ')
                                )
                              );
   $planning['juillet'][23] = Array(
                              'h1' => Array(
                                 't1' => Array('noire', 'rouge'), 's1' => Array('  ', '  '),
                                 't2' => Array('bleue', 'violette'), 's2' => Array('  ', '  '),
                                 't3' => Array('blanche', 'orange'), 's3' => Array('  ', '  '),
                                 't4' => Array('verte', 'jaune'), 's4' => Array('  ', '  ')
                                ),
                              'h2' => Array(
                                 't1' => Array('noire', 'blanche'), 's1' => Array('  ', '  '),
                                 't2' => Array('bleue', 'orange'), 's2' => Array('  ', '  '),
                                 't3' => Array('rouge', 'jaune'), 's3' => Array('  ', '  '),
                                 't4' => Array('violette', 'verte'), 's4' => Array('  ', '  ')
                                )
       );
   $planning['juillet'][30] = Array(
                              'h1' => Array(
                                 't1' => Array('noire','bleue'),
                                 's1' => Array('  ', '  '),
                                 's2' => Array('  ', '  '),
                                 't2' => Array('blanche','jaune')
                                ),
                              'h2' => Array(
                                 't1' => Array('violette','rouge'),
                                 's1' => Array('  ', '  '),
                                 's2' => Array('  ', '  '),
                                 't2' => Array('orange','verte')
                                )
       );
   $planning['aout'][06] = Array(
                              'h1' => Array(
                                 't1' => Array('classement','classement'),
                                 's1' => Array('  ', '  '),
                                 's2' => Array('  ', '  '),
                                 't2' => Array('classement','classement')
                                ),
                              'h2' => Array(
                                 't1' => Array('classement','classement'),
                                 's1' => Array('  ', '  '),
                                 's2' => Array('  ', '  '),
                                 't2' => Array('classement','classement')
                                )
       );
   $planning['aout'][13] = Array(
                              'h1' => Array(
                                 't1' => Array('classement','classement'),
                                 's1' => Array('  ', '  '),
                                 's2' => Array('  ', '  '),
                                 't2' => Array('classement','classement')
                                ),
                              'h2' => Array(
                                 't1' => Array('classement', 'classement'),
                                 's1' => Array('  ', '  '),
                                 's2' => Array('  ', '  '),
                                 't2' => Array('classement', 'classement')
                                )
       );
?>
  <table border=1 cellspacing=0 style='width:100%'>
    <thead>
      <tr>
        <th rowspan=2>Jour</th>
        <th rowspan=2>Heure</th>
        <th colspan=4>Terrain 1</th>
        <th class='black'></th>
        <th colspan=4>Terrain 2</th>
        <th class='black'></th>
        <th colspan=4>Terrain 3</th>
        <th class='black'></th>
        <th colspan=4>Terrain 4</th>
      </tr>
      <tr>
        <th>Équipe</th>
        <th colspan=2>score</th>
        <th>Équipe</th>
        <th class='black'></th>
        <th>Équipe</th>
        <th colspan=2>score</th>
        <th>Équipe</th>
        <th class='black'></th>
        <th>Équipe</th>
        <th colspan=2>score</th>
        <th>Équipe</th>
        <th class='black'></th>
        <th>Équipe</th>
        <th colspan=2>score</th>
        <th>Équipe</th>
      </tr>
    </thead>
    <tbody>
<?php
  $first = true;
  foreach ($planning as $month => $days) {
    foreach ($days as $day => $time) {
      if ($first == false) {
        echo "<tr><td colspan=10></td></tr>";
      } else {
        $first = false;
      }
      echo<<<END
      <tr>
        <td rowspan=2>Jeudi $day $month</td>
        <td>19h30 - 20h30</td>
        <td style="{$team[$time['h1']['t1'][0]]['style']}">{$team[$time['h1']['t1'][0]]['name']}</td>
        <td class='score'>{$time['h1']['s1'][0]}</td><td class='score'>{$time['h1']['s1'][1]}</td>
        <td style="{$team[$time['h1']['t1'][1]]['style']}">{$team[$time['h1']['t1'][1]]['name']}</td>
        <td class='black'></td>
        <td style="{$team[$time['h1']['t2'][0]]['style']}">{$team[$time['h1']['t2'][0]]['name']}</td>
        <td class='score'>{$time['h1']['s2'][0]}</td><td class='score'>{$time['h1']['s2'][1]}</td>
        <td style="{$team[$time['h1']['t2'][1]]['style']}">{$team[$time['h1']['t2'][1]]['name']}</td>
END;
      if (isset($time['h1']['t3'])) {
        echo<<<END
        <td class='black'></td>
        <td style="{$team[$time['h1']['t3'][0]]['style']}">{$team[$time['h1']['t3'][0]]['name']}</td>
        <td class='score'>{$time['h1']['s3'][0]}</td><td class='score'>{$time['h1']['s3'][1]}</td>
        <td style="{$team[$time['h1']['t3'][1]]['style']}">{$team[$time['h1']['t3'][1]]['name']}</td>
        <td class='black'></td>
        <td style="{$team[$time['h1']['t4'][0]]['style']}">{$team[$time['h1']['t4'][0]]['name']}</td>
        <td class='score'>{$time['h1']['s4'][0]}</td><td class='score'>{$time['h1']['s4'][1]}</td>
        <td style="{$team[$time['h1']['t4'][1]]['style']}">{$team[$time['h1']['t4'][1]]['name']}</td>
END;
      }
      echo "</tr><tr>";
      echo<<<END
        <td>20h50 - 21h50</td>
        <td style="{$team[$time['h2']['t1'][0]]['style']}">{$team[$time['h2']['t1'][0]]['name']}</td>
        <td class='score'>{$time['h2']['s1'][0]}</td><td class='score'>{$time['h2']['s1'][1]}</td>
        <td style="{$team[$time['h2']['t1'][1]]['style']}">{$team[$time['h2']['t1'][1]]['name']}</td>
        <td class='black'></td>
        <td style="{$team[$time['h2']['t2'][0]]['style']}">{$team[$time['h2']['t2'][0]]['name']}</td>
        <td class='score'>{$time['h2']['s2'][0]}</td><td class='score'>{$time['h2']['s2'][1]}</td>
        <td style="{$team[$time['h2']['t2'][1]]['style']}">{$team[$time['h2']['t2'][1]]['name']}</td>
END;
      if (isset($time['h2']['t3'])) {
        echo<<<END
        <td class='black'></td>
        <td style="{$team[$time['h2']['t3'][0]]['style']}">{$team[$time['h2']['t3'][0]]['name']}</td>
        <td class='score'>{$time['h2']['s3'][0]}</td><td class='score'>{$time['h2']['s3'][1]}</td>
        <td style="{$team[$time['h2']['t3'][1]]['style']}">{$team[$time['h2']['t3'][1]]['name']}</td>
        <td class='black'></td>
        <td style="{$team[$time['h2']['t4'][0]]['style']}">{$team[$time['h2']['t4'][0]]['name']}</td>
        <td class='score'>{$time['h2']['s4'][0]}</td><td class='score'>{$time['h2']['s4'][1]}</td>
        <td style="{$team[$time['h2']['t4'][1]]['style']}">{$team[$time['h2']['t4'][1]]['name']}</td>
END;
      }

      echo "</tr>";
    }
  }
?>
<!--
      <tr><td colspan=10>&nbsp;</td></tr>
      <tr><td colspan=10 style='background-color:black'></td></tr>
      <tr>
        <td rowspan=4>Jeudi 13 aout</td>
        <td rowspan=2>19h30</td>
        <td colspan=4>Place 3 &amp; 4</td>
        <td colspan=4>Place 5 &amp; 6</td>
      </tr>
      <tr>
        <td style='background-color:orange'>Strip Fighter</td>
        <td class=score>7</td>
        <td class=score>13</td>
        <td style='background-color:red'>Callahan and Conquer: Red Alert</td>
        <td style='background-color:green'>Back Piggies</td>
        <td class=score>9</td>
        <td class=score>13</td>
        <td style='background-color:DodgerBlue'>Sonic Boom</td>
      </tr>
      <tr>
        <td rowspan=2>20h45</td>
        <td colspan=8 class=score>Finale</td>
      </tr>
      <tr>
        <td colspan=3 style='background-color:black;color:white'>Darksiders</td>
        <td>7</td>
        <td>8</td>
        <td colspan=3 style='background-color:white'>Cours Lapin... Swing Crétin</td>
      </tr>
-->
    </tbody>
  </table>

<?php
  class Team {
    public $color;
    public $won = 0;
    public $lost = 0;
    public $diff = 0;
    function __construct($tcolor) {
      $this->color = $tcolor;
    }
  }
  $classement = [];
  foreach ($team as $color => $unused) {
    if ($color != 'classement') {
      $classement[$color] = new Team($color);
    }
  }
  foreach ($planning as $month => $days) {
    if ($month != 'juillet') {
      break;
    }
    foreach ($days as $hours) {
      foreach ($hours as $hour) {
        foreach ([1,2,3,4] as $m) {
          $s0 = trim($hour["s$m"][0]);
          $s1 = trim($hour["s$m"][1]);
          if (isset($hour["t$m"]) && !empty($s0) && !empty($s1)) {
            $classement[$hour["t$m"][0]]->diff += ($s0 - $s1);
            $classement[$hour["t$m"][1]]->diff += ($s1 - $s0);
            if ($s0 > $s1) {
              $classement[$hour["t$m"][0]]->won++;
              $classement[$hour["t$m"][1]]->lost++;
            } else if ($s1 > $s0) {
              $classement[$hour["t$m"][1]]->won++;
              $classement[$hour["t$m"][0]]->lost++;
            }
          }
        }
      }
    }
  }
?>
 
  <span>
  <h2>Classement de Poule</h2>
  <table cellspacing=0 border=1 style='width:35%'>
    <thead>
      <tr>
        <th></th>
        <th>#</th>
        <th>Équipe</th>
        <th>Gagné</th>
        <th>Perdu</th>
        <th>Diff</th>
      </tr>
    </thead>
    <tbody>
<?php
  function compare_team($t1, $t2) {
    if ($t1->won == $t2->won) {
      return ($t2->diff - $t1->diff);
    }
    return $t2->won - $t1->won;
  }
  usort($classement, 'compare_team');
  $i = 1;
  foreach ($classement as $t) {
    $tname = $team[$t->color]['name'];
    $tstyle = $team[$t->color]['style'];
    if ($i == 1) {
       $poule = "<td rowspan=4>Poule Haute</td>";
    } else if ($i == 5) {
       $poule = "<td rowspan=4>Poule Basse</td>";
    } else {
      $poule = '';
    }
    echo<<<END
      <tr>
        $poule
        <td>$i</td>
        <td style='$tstyle'>$tname</td>
        <td>$t->won</td>
        <td>$t->lost</td>
        <td>$t->diff</td>
      </tr>
END;
    ++$i;
  }
?>
    </tbody>
  </table>
  </span>
  <span>
    <h2>Tableau Final</h2>
    <table cellspacing=0 border=1 style='display:inline-table'>
      <tr><th colspan=3>1<sup>er</sup> tour</th></tr>
      <tr><th>Places</th><th>#</th><th style='width:150px'>Équipe</th></tr>
      <tr>
        <td rowspan=4>1 à 4</td>
        <td rowspan=2>A</td>
<!-- --><td>1<sup>er</sup> contre 4<sup>e</sup></td><!-- -->
<!--        <td style='<?=$team['blanche']['style']?>'><?=$team['blanche']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['noire']['style']?>'><?=$team['noire']['name']?></td>-->
      </tr>
      <tr>
        <td rowspan=2>B</td>
<!-- --><td>2<sup>e</sup> contre 3<sup>e</sup></td><!-- -->
 <!--       <td style='<?=$team['jaune']['style']?>'><?=$team['jaune']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['rouge']['style']?>'><?=$team['rouge']['name']?></td>-->
      </tr>
      <tr>
        <td rowspan=4>5 à 8</td>
        <td rowspan=2>C</td>
<!-- --><td>5<sup>e</sup> contre 8<sup>e</sup></td><!-- -->
 <!--       <td style='<?=$team['orange']['style']?>'><?=$team['orange']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['verte']['style']?>'><?=$team['verte']['name']?></td>-->
      </tr>
      <tr>
        <td rowspan=2>D</td>
<!-- --><td>6<sup>e</sup> contre 7<sup>e</sup></td><!-- -->
 <!--       <td style='<?=$team['bleue']['style']?>'><?=$team['bleue']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['violette']['style']?>'><?=$team['violette']['name']?></td>-->
      </tr>
    </table>
    <table cellspacing=0 border=1 style='display:inline-table;vertical-align:top'>
      <tr><th colspan=3>Matchs de classement final</th></tr>
      <tr><th>Places</th><th>#</th><th style='width:150px'>Équipe</th></tr>
      <tr>
        <td rowspan=2>1 et 2</td>
        <td rowspan=2>E</td>
            <td>Vainqueur A contre vainqueur B</td>
 <!--       <td style='<?=$team['blanche']['style']?>'><?=$team['blanche']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['rouge']['style']?>'><?=$team['rouge']['name']?></td>-->
      </tr>
      <tr>
        <td rowspan=2>3 et 4</td>
        <td rowspan=2>F</td>
            <td>Perdant A contre perdant B</td>
 <!--       <td style='<?=$team['noire']['style']?>'><?=$team['noire']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['jaune']['style']?>'><?=$team['jaune']['name']?></td>-->
      </tr>
      <tr>
        <td rowspan=2>5 et 6</td>
        <td rowspan=2>G</td>
            <td>Vainqueur C contre vainqueur D</td>
 <!--       <td style='<?=$team['orange']['style']?>'><?=$team['orange']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['violette']['style']?>'><?=$team['violette']['name']?></td>-->
      </tr>
      <tr>
        <td rowspan=2>7 et 8</td>
        <td rowspan=2>H</td>
            <td>Perdant C contre perdant D</td>
 <!--       <td style='<?=$team['verte']['style']?>'><?=$team['verte']['name']?></td>-->
      </tr>
      <tr>
 <!--       <td style='<?=$team['bleue']['style']?>'><?=$team['bleue']['name']?></td>-->
      </tr>
    </table>

    <table cellspacing=0 border=1 style='display:inline-table;vertical-align:top'>
      <thead>
        <tr><th colspan=2><img src='images/coupe.png' height=10px> Classement Final <img src='images/coupe.png' height=10px></th></tr>
        <tr>
          <th>Place</th>
          <th style='width:150px'>Équipe</th>
        </tr>
      </thead>
      <tbody>
<?php
  $classement = [
    "<img src='images/coupe.png' height=10px> 1<sup>er</sup>" => '',
    '2<sup>e</sup>'=>'',
    '3<sup>e</sup>'=>'',
    '4<sup>e</sup>'=>'',
    '5<sup>e</sup>'=>'',
    '6<sup>e</sup>'=>'',
    '7<sup>e</sup>'=>'',
    '8<sup>e</sup>'=>''
  ];
  foreach ($classement as $place => $color) {
        echo '<tr><td>'. $place . '</td><td style="' . $team[$color]['style'] . '">' . $team[$color]['name'] . "</td></tr>\n";
  }
?>
      </tbody>
    </table>
  </span>

  <br><br>
</body>
</html>
