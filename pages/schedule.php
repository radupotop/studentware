<?php
/**
 * @file
 * Display schedule
 */
?>
<div id="schedule">

<style type="text/css" media="all">
	html {
		font: normal .75em Tahoma, Verdana, sans-serif;
	}
	table {
		width: 80em;
		margin: 1em auto;
		border-collapse: collapse;
		text-align: center;
	}
	caption {
		font: normal 1.5em Verdana, sans-serif;
		margin: 1em auto 1.6em auto;
	}
	tfoot td {
		border: none;
		text-align: left;
		padding: 1em;
	}
	th, td {
		width: 7%;
		height: 2em;
		border: solid 1px #000;
	}
	td {
		height: 5.6em;
	}
	#ora th {
		font: normal .835em Tahoma, Arial, sans-serif;
	}
	.pauza {
		border-left: solid 3px #000;
	}

	/* STYLE MATERII */
	.tip_1	{ background: #ffc }
	.tip_2	{ background: #ddd }
	.tip_3	{ background: #cff }
	.tip_4	{ background: #cf9 }
	.tip_5	{ background: #fc9 }
</style>

<table>
	<thead>
	<tr id="nr_ora">
		<th rowspan="2"></th>
		<th>1</th>
		<th>2</th>
		<th>3</th>
		<th>4</th>
		<th class="pauza">5</th>
		<th>6</th>
		<th>7</th>
		<th>8</th>
		<th>9</th>
		<th>10</th>
		<th>11</th>
		<th>12</th>
	</tr>
	<tr id="ora">
		<th>08:00 - 08:50</th>
		<th>09:00 - 09:50</th>
		<th>10:00 - 10:50</th>
		<th>11:00 - 11:50</th>
		<th class="pauza">12:10 - 13:00</th>
		<th>13:10 - 14:00</th>
		<th>14:10 - 15:00</th>
		<th>15:10 - 16:00</th>
		<th>16:10 - 17:00</th>
		<th>17:10 - 18:00</th>
		<th>18:10 - 19:00</th>
		<th>19:10 - 20:00</th>
	</tr>
	</thead>

	<tbody>
	<tr id="luni">
		<th class="nume_zi">Luni</th>
		<td colspan="2" class="tip_2">
						Analiză Numerică (Lab)<br>
						Finta Béla<br>
						A 301</td>
		<td colspan="2" class="tip_2">
						Teoria Probabilitatilor (Sem)<br>
						Finta Béla<br>
						R 33</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr id="marti">
		<th class="nume_zi">Marti</th>
		<td colspan="2" class="tip_1">
						Inteligenta Artificiala<br>
						Enachescu Calin<br>
						R 30</td>
		<td colspan="2" class="tip_1">
						Inteligenta Artificiala (Lab)<br>
						Enachescu Calin<br>
						R 30</td>
		<td colspan="2" class="tip_5">
						Proiect Informatică<br>
						Roman Adrian<br>
						R 35</td>
		<td></td>
		<td></td>
		<td colspan="2" class="tip_2">
						Analiză Numerică<br>
						Finta Béla<br>
						R 33</td>
		<td colspan="2" class="tip_2">
						Teoria Probabilitatilor<br>
						Finta Béla<br>
						R 30</td>
	</tr>
	<tr id="miercuri">
		<th class="nume_zi">Miercuri</th>
		<td></td>
		<td></td>
		<td colspan="2" class="tip_3">
						Comunicare educationala (Sem)<br>
						Silvas Alexandra<br>
						B 13</td>
		<td colspan="2" class="tip_1">
						Ingineria Programarii (Lab)<br>
						Radoiu Dumitru<br>
						R 35</td>
		<td colspan="2" class="tip_1">
						Ingineria Programarii<br>
						Radoiu Dumitru<br>
						R 35</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr id="joi">
		<th class="nume_zi">Joi</th>
		<td colspan="2" class="tip_4">
						Baze de date (Lab)<br>
						Leftkovits Szidonia<br>
						R 30</td>
		<td colspan="2" class="tip_4">
						Baze de date<br>
						Iantovics Barna<br>
						R 35</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr id="vineri">
		<th class="nume_zi">Vineri</th>
		<td colspan="4" class="tip_3">
						Practica pedagogica informatica<br>
						Ispas Ioan<br>
						Liceul Unirea, Colegiul Papiu</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	</tbody>
</table>

</div>
