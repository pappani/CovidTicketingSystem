<html>
<head>
<title>FP Events</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="icon" href="favicon.ico">
<style>
a {
  color: black;
  background-color: transparent;
  text-decoration: none;
}
body {
	color: black;
}
table, th, td {
	border: 1px solid black;
	border-collapse: collapse;
	margin-left: auto;
	margin-right: auto;
	text-align: center;
	word-wrap: break-word;
	max-width: 1000px;
}
.btn {
	margin-top: 10px;
	margin-left: 10px;
	width: 147px;
}
div {
	align-content: center;
	vertical-align: middle;
	text-align: center;
}
tr:nth-child(even) {
	background-color: #f2f2f2
}
.taskbar {
	background-color: #D5D5D5;
}
#cntr {
	color: #1E90FF;
}
</style>
</head>
<body style="background-color:white;">
<div class="taskbar"><br/>
<img src="logo.png" width="333" height="95" alt="FP Events">
<hr/></div><div>
<h2>Prenotazione FP Events</h2>
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$myconn=@pg_connect($connstring);
$query = "SELECT * FROM evento ORDER BY id DESC LIMIT 1";
$result = pg_query($myconn,$query);
pg_close($myconn);
$numrows = pg_num_rows($result);
if ($numrows == 1) {
    $resrow = pg_fetch_row($result);
    $evento = $resrow[1];
	$disattivato = $resrow[2];
}
else
{
	die("<br/><br/>Non è disponibile alcun evento.");
}
if ($disattivato == 1) { die("<br/>Per l'evento $evento abbiamo raggiunto il numero massimo di prenotazioni.<br/><br/>"); }
echo "<b>Evento: " . $evento . "</b>";
echo '<input type="hidden" name="evento" value="' . $evento . '">';
?>
<form action="sendPost.php" method="post">
<div class="row d-flex justify-content-center">
<div class="form-group col-md-6 w-70 p-3 ">
<input type="text" class="form-control" id="nome" name="nome" placeholder="Inserisci nome"><br/>
<input type="text" class="form-control" id="cognome" name="cognome" placeholder="Inserisci cognome"><br/>
<input type="email" class="form-control" id="email" name="email" placeholder="Inserisci email"><br/>
<input type="tel" class="form-control" id="cellulare" name="cellulare" placeholder="Inserisci cellulare"><br/>
Mese e anno di nascita <select name="mese" id="mese">
    <?php
    for ($i = 0; $i < 12; $i++) {
        $value = $i+1;
        echo "<option value='$value'>$value</option>";
    }
    ?>
</select>
<select name="anno" id="anno">
    <?php
	$minYear = date('Y') - 16; $maxYear = date('Y') - 70;
    for ($i = $minYear; $i > $maxYear; $i--) {
        $value = $i;
        echo "<option value='$value'>$value</option>";
    }
    ?>
</select>
<br/><br/>
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$myconn=@pg_connect($connstring);
$query = "SELECT * FROM evento ORDER BY id DESC LIMIT 1";
$result = pg_query($myconn,$query);
pg_close($myconn);
$numrows = pg_num_rows($result);
if ($numrows == 1) {
    $resrow = pg_fetch_row($result);
    $evento = $resrow[1];
}
echo '<input type="hidden" name="evento" value="' . $evento . '">';
?>
Autorizzo il trattamento dei dati personali &nbsp;<input style="transform: scale(1.5);" type="checkbox" name="privacy" onchange="document.getElementById('send').disabled = !this.checked;" value="1"/><br/><br/>
Hai febbre, mal di gola, tosse o sintomi riconducibili al Covid-19? <select name="covid1"><option value="No">No</option><option value="Si">Si</option></select><br/><br/>
Hai avuto contatti con casi accertati covid o casi sospetti negli ultimi 14 giorni? <select name="covid2"><option value="No">No</option><option value="Si">Si</option></select><br/><br/>
Sei stato in ambienti sanitari con casi Covid accertati o all'estero negli ultimi 14 giorni? <select name="covid3"><option value="No">No</option><option value="Si">Si</option></select><br/><br/>
<input class="btn btn-dark" type="submit" id="send" disabled="true" name="send" value="Prenota"/>
</form>
<br/>
<br/>
<br/>
<i style="color:#D5D5D5">&nbsp;&nbsp;Federico Pappani</i>
</div>
</div>
</div>
<br/>
<!-- Federico Pappani - pappani.me -->
</body>
</html> 