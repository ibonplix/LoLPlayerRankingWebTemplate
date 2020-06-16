<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta content="text/html; charset=windows-1252" http-equiv="content-type">
	<meta content="Tomates, verdes, fritos, FannieFlagg, Kathy" name="keywords">
	<script type="text/javascript" src="scripts/scripts.js"></script>
    <link rel="stylesheet" href="estilos/estilos.css" type="text/css" media="all">
    <title>LeagueOfLegendsRanking</title>
  </head>
  <body>
	<h1>LeagueOfLegendsRanking</h1>
		<img id="logokantoikoa" src="imagenes/pp.jpg" style="border-radius:40px;">
			<div id="header">
				<ul class="nav">
					<li><a href="index.php" style="color:#E38968;">Ladder</a>
					</li>
				</ul>
			</div>
			<?php
			#error_reporting(0);
			require_once ('simple_html_dom.php');
				echo '<table id="table" style="width:100%">';
				echo ' <tr>';
				echo 	'<th style="display:none;">ORDEN</th>';
				echo 	'<th style="display:none;">numlps</th>';
				echo	'<th onclick="sortTable(2)"><a href="#" style="color:#9e9d9d; text-decoration:none;">PLAYER</a></th>';
				echo	'<th onclick="sortTable(3)"><a href="#" style="color:#9e9d9d; text-decoration:none;">CUENTA</a></th>';
				echo	'<th onclick="sortcolumnas(1),sortTable(0)"><a href="#" style="color:#9e9d9d; text-decoration:none;">RANK</a></th>';
				echo	'<th onclick="sortcolumnas(1),sortTable(0)"><a href="#" style="color:#9e9d9d; text-decoration:none;">ELO</th>';
				echo	'<th onclick="sortcolumnas(6)"><a href="#" style="color:#9e9d9d; text-decoration:none;">PARTIDAS</a></th>';
				echo	'<th onclick="sortcolumnas(7)"><a href="#" style="color:#9e9d9d; text-decoration:none;">GANADAS</a></th>';
				echo	'<th onclick="sortcolumnas(8)"><a href="#" style="color:#9e9d9d; text-decoration:none;">PERDIDAS</a></th>';
				echo	'<th onclick="sortcolumnas(10)"><a href="#" style="color:#9e9d9d; text-decoration:none;">WINRATE</a></th>';
				echo	'<th style="display:none;">WINRATE2</th>';
				echo	'<th>POROFESSOR</th>';
				echo	'<th>OPGG</th>';
				echo '</tr>';
			function player($nickname, $player) {
				$nickreplaced=str_replace(" ","%20",$nickname);
				$urlbase="https://www.leagueofgraphs.com/en/summoner/euw/";
				$url=$urlbase. '' .$nickreplaced;
				$html = file_get_contents($url);
				$ingameweb = "http://www.lolskill.net/game/EUW/";
				$ingamehtml=$ingameweb. '' .$nickreplaced;
				$porofessorweb="https://porofessor.gg/es/live/euw/";
				$porofessorurl=$porofessorweb. '' .$nickreplaced;
				$htmlingame=file_get_contents($ingamehtml);
				$domHtml = str_get_html($html);
				$liga=$domHtml->find('div[class=leagueTier]')[0];
				$liga1=$liga->plaintext;
				$rango=substr($liga1,38,1);
				$opggbase="https://euw.op.gg/summoner/userName=";
				$opgg=$opggbase.''.$nickreplaced;
				$orden="unranked";
				if ($rango == "D"){
					$ligarango=substr($liga1,46,3);
					if ($ligarango == "I  "){
						$orden="AA";
					}elseif ($ligarango == "II "){
						$orden="AB";
					}elseif ($ligarango == "III"){
						$orden="AC";
					}elseif ($ligarango == "IV "){
						$orden="AD";
					}
				}elseif ($rango == "P"){
					$ligarango=substr($liga1,47,3);
					if ($ligarango == "I  "){
						$orden="BA";
					}elseif ($ligarango == "II "){
						$orden="BB";
					}elseif ($ligarango == "III"){
						$orden="BC";
					}elseif ($ligarango == "IV "){
						$orden="BD";
					}
				}elseif ($rango == "G"){
					$ligarango=substr($liga1,43,3);
					if ($ligarango == "I  "){
						$orden="CA";
					}elseif ($ligarango == "II "){
						$orden="CB";
					}elseif ($ligarango == "III"){
						$orden="CC";
					}elseif ($ligarango == "IV "){
						$orden="CD";
					}
				}elseif ($rango == "S"){
					$orden="D";
					$ligarango=substr($liga1,45,3);
					if ($ligarango == "I  "){
						$orden="DA";
					}elseif ($ligarango == "II "){
						$orden="DB";
					}elseif ($ligarango == "III"){
						$orden="DC";
					}elseif ($ligarango == "IV "){
						$orden="DD";
					}
				}elseif ($rango == "B"){
					$ligarango=substr($liga1,45,3);
					if ($ligarango == "I  "){
						$orden="EA";
					}elseif ($ligarango == "II "){
						$orden="EB";
					}elseif ($ligarango == "III"){
						$orden="EC";
					}elseif ($ligarango == "IV "){
						$orden="ED";
					}
				}elseif ($rango == "I"){
					if ($ligarango == "I  "){
						$orden="FA";
					}elseif ($ligarango == "II "){
						$orden="FB";
					}elseif ($ligarango == "III"){
						$orden="FC";
					}elseif ($ligarango == "IV "){
						$orden="FD";
					}
				}
				$ligaupper=strtoupper($liga);
				if ($orden == "unranked"){
					$ligaupper="UNRANKED";
					$ganadas="0";
					$perdidas="0";
					$jugadas="0";
					$winrate="0";
				}else{
					$lps=$domHtml->find('div[class=league-points]')[0];
					$ganadas=$domHtml->find('span[class=winsNumber]')[0];
					$perdidas=$domHtml->find('span[class=lossesNumber]')[0];
					$ganadasnum= (int)$ganadas->plaintext;
					$perdidasnum= (int)$perdidas->plaintext;
					$jugadas=$ganadasnum+$perdidasnum;
					$winrate=(int)((100*$ganadasnum)/$jugadas);
					$lpsnumsolo=substr($lps,58,2);
					$lpigual0=substr($lpsnumsolo,0,1);

					if ($lpigual0 == "0"){
						$lpsfinal=(int)$lpigual0;
					}else{
						$lpsfinal=(int)$lpsnumsolo;
					}
				}
				$color="#E38968";
				$ingame="queso";
				$element="queso";
				$domingameHtml = str_get_html($htmlingame);
				foreach($domingameHtml->find('h3') as $element){
						if ($element=="<h3>Summoner's Rift</h3>"){
							$color="green";
						}
				}		
				echo '<tr>';
				echo '<td style="display:none;">' . $orden . '</td>';
				echo '<td style="display:none;">' . $lpsfinal . '</td>';
		        echo '<td>'.$player.'</td>';
				echo '<td>'.$nickname.'</td>';
				echo	'<td><img src="imagenes/'.$orden.'.png" height="49" width="43"></td>';
				echo	'<td><b>'.$ligaupper. '' .$lps.'</b></td>';
				echo	'<td>'. $jugadas . '</td>';
				echo	'<td style="color:green;">' . $ganadasnum .'</td>';
				echo	'<td style="color:red;">' . $perdidasnum .'</td>';
				echo	'<td>' . $winrate .'%</td>';
				echo	'<td style="display:none;">' . $winrate .'</td>';
				echo    '<td><a href="'.$porofessorurl.'" target="_blank" style="color:'.$color.'; text-decoration:none;">POROFESSOR</a></td>';
				echo	'<td><a href="'.$opgg.'" target="_blank" style="color:#9e9d9d; ">OP.GG</a></td>';
				echo  '</tr>';
			}
	  		#Sintax for adding new players to the web. Use the function "player" with two parameters: the account name, and any text(player name), just keep adding lines with the function after the last one.
			#player("Accountname", "Name");
	  		#EXAMPLE: 
	   		player("Werlyb", "Jorge");
			
			echo'</table>';
			?>
			<script>
				function sortcolumnas(n){
				  var table, rows, switching, i, x, y, shouldSwitch;
				  table = document.getElementById("table");
				  switching = true;
				  /*Make a loop that will continue until
				  no switching has been done:*/
				  while (switching) {
					//start by saying: no switching is done:
					switching = false;
					rows = table.rows;
					/*Loop through all table rows (except the
					first, which contains table headers):*/
					for (i = 1; i < (rows.length - 1); i++) {
					  //start by saying there should be no switching:
					  shouldSwitch = false;
					  /*Get the two elements you want to compare,
					  one from current row and one from the next:*/
					  x = rows[i].getElementsByTagName("TD")[n];
					  y = rows[i + 1].getElementsByTagName("TD")[n];
					  //check if the two rows should switch place:
					  if (Number(x.innerHTML) < Number(y.innerHTML)) {
						//if so, mark as a switch and break the loop:
						shouldSwitch = true;
						break;
					  }
					}
					if (shouldSwitch) {
					  /*If a switch has been marked, make the switch
					  and mark that a switch has been done:*/
					  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					  switching = true;
					}
				  }
				}
				sortcolumnas(1)
				function sortTable(n) {
				  var table, rows, switching, i, x, y, shouldSwitch;
				  table = document.getElementById("table");
				  switching = true;
				  /*Make a loop that will continue until
				  no switching has been done:*/
				  while (switching) {
					//start by saying: no switching is done:
					switching = false;
					rows = table.rows;
					/*Loop through all table rows (except the
					first, which contains table headers):*/
					for (i = 1; i < (rows.length - 1); i++) {
					  //start by saying there should be no switching:
					  shouldSwitch = false;
					  /*Get the two elements you want to compare,
					  one from current row and one from the next:*/
					  x = rows[i].getElementsByTagName("TD")[n];
					  y = rows[i + 1].getElementsByTagName("TD")[n];
					  //check if the two rows should switch place:
					  if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
						//if so, mark as a switch and break the loop:
						shouldSwitch = true;
						break;
					  }
					}
					if (shouldSwitch) {
					  /*If a switch has been marked, make the switch
					  and mark that a switch has been done:*/
					  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					  switching = true;
					}
				  }
				}
				sortTable(0)
			</script>

  </body>
</html>
