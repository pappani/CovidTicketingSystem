<?php
session_start();
if(!isset($_SESSION['email'])) {
header("Location: index.php");
die("");
}
?>
<html>
<head>
<title>FP Events</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="icon" href="favicon.ico">
<style>
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
</style>
</head>
<body>
<div>
<h1>FP Events</h1>
<hr>
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$myconn=@pg_connect($connstring);
$time = date("Y-m-d H:i:s");
if (!isset($_GET['email']) || !isset($_GET['evento'])) die("<h2>Utente NON confermato</h2>QR Code non valido.");

$email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
$evento = filter_var($_GET['evento'], FILTER_SANITIZE_STRING);
$email = pg_escape_string($myconn, $email);
$evento = pg_escape_string($myconn, $evento);

$query1 = "SELECT * FROM iscrittiEventoCorrente WHERE EMAIL = '$_GET[email]' AND evento  = '$_GET[evento]' AND presente = '1'";
$query = "UPDATE iscrittiEventoCorrente SET presente = '1', data_conferma = '$time' WHERE email = '$_GET[email]' AND evento = '$_GET[evento]'";
$query2 = "SELECT * FROM iscrittiEventoCorrente WHERE email = '$_GET[email]' AND evento = '$_GET[evento]'";
$result1 = pg_query($myconn, $query1) or die(pg_result_error($myconn));
if (pg_num_rows($result1) != 0) {
	$resrow = pg_fetch_row($result1);
	$data = $resrow[12];
	$timestamp = strtotime($data) + 60*60*2;
	$timestamp = strftime('%d-%m-%y %H:%M', $timestamp);
	echo "<h2>Utente GIÀ confermato.</h2>Questo utente è GIÀ stato confermato in data $timestamp <br/>";
	$nome = $resrow[0];
    $cognome = $resrow[1];
    $email = $resrow[2];
	$cellulare = $resrow[3];
	$nascita = $resrow[4];
	$evento = $resrow[5];
	$privacy = $resrow[6];
	$covid1 = $resrow[7];
	$covid2 = $resrow[8];
	$covid3 = $resrow[9];
	$presente = $resrow[10];
	echo '<br/><table style="width:60%"> <tr>';
	echo "<b><th>Nome</th><th>Cognome</th><th>Nascita</th><th>Cellulare</th><th>Email</th><th>Evento</th><th>Privacy</th><th>Covid1</th><th>Covid2</th><th>Covid3</th><th>Presente</th></b></tr>";
	echo "<tr>";
	echo "<td>" . $nome . "</td>";
	echo "<td>" . $cognome . "</td>";
	echo "<td>" . $nascita . "</td>";
	echo "<td>" . $cellulare . "</td>";
	echo "<td>" . $email . "</td>";
	echo "<td>" . $evento . "</td>";
	echo "<td>" . $privacy . "</td>";
	echo "<td>" . $covid1 . "</td>";
	echo "<td>" . $covid2 . "</td>";
	echo "<td>" . $covid3 . "</td>";
	echo "<td>" . $presente . "</td>";
	echo "</tr>";
	echo "</table>";
	die();
	}
if(false === pg_query($myconn, $query)) {
	exit("Errore: impossibile eseguire la query." . pg_result_error($myconn));
}
$result = pg_query($myconn, $query2) or die(pg_result_error($myconn));
$numrows = pg_num_rows($result);
$resrow = pg_fetch_row($result);
pg_close($myconn);
if ($numrows != 0) {
	echo "<h2>Utente confermato</h2>";
	$minorenne = false;
	$nome = $resrow[0];
	$cognome = $resrow[1];
	$email = $resrow[2];
	$cellulare = $resrow[3];
	$nascita = $resrow[4];
	$nascitaSplit = explode('-', $nascita);
	if ($nascitaSplit[1] > (date('Y') - 18)) $minorenne = true;
	if (($nascitaSplit[1] == (date('Y')) - 18) && ($nascitaSplit[0] > date('m'))) $minorenne = true;
	$evento = $resrow[5];
	$privacy = $resrow[6];
	$covid1 = $resrow[7];
	$covid2 = $resrow[8];
	$covid3 = $resrow[9];
	$presente = $resrow[10];
	echo '<table style="width:60%"> <tr>';
	echo "<b><th>Nome</th><th>Cognome</th><th>Nascita</th><th>Cellulare</th><th>Email</th><th>Evento</th><th>Privacy</th><th>Covid1</th><th>Covid2</th><th>Covid3</th><th>Presente</th></b></tr>";
	echo "<tr>";
	echo "<td>" . $nome . "</td>";
	echo "<td>" . $cognome . "</td>";
	if ($minorenne == true) echo "<td style='color:black; background-color:orange;'>" . $nascita . "</td>";
	else if($minorenne == false) echo "<td>" . $nascita . "</td>";
	echo "<td>" . $cellulare . "</td>";
	echo "<td>" . $email . "</td>";
	echo "<td>" . $evento . "</td>";
	echo "<td>" . $privacy . "</td>";
	echo "<td>" . $covid1 . "</td>";
	echo "<td>" . $covid2 . "</td>";
	echo "<td>" . $covid3 . "</td>";
	echo "<td>" . $presente . "</td>";
	echo "</tr>";
	echo "</table>";
} else die("<h2>Utente NON confermato</h2>QR Code non valido.");

?>
</body>
</html>