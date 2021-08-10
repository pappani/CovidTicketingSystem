<?php
session_start();
if(!isset($_SESSION['email'])) {
header("Location: index.php");
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
<h2>Cerca utente</h2>
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
if ($_POST['cognome'] != "") {
	$query = "SELECT * FROM biglietti WHERE COGNOME = '$_POST[cognome]' AND EVENTO = '$_POST[evento]' ORDER BY NOME ASC";
}
if ($_POST['email'] != "") {
	$query = "SELECT * FROM biglietti WHERE EMAIL = '$_POST[email]' AND EVENTO = '$_POST[evento]' ORDER BY NOME ASC";
}
if ($_POST['cellulare'] != "") {
	$query = "SELECT * FROM biglietti WHERE CELLULARE = '$_POST[cellulare]' AND EVENTO = '$_POST[evento]' ORDER BY NOME ASC";
}
$myconn=@pg_connect($connstring);

$result=pg_query($myconn,$query);
pg_close($myconn);
$numrows = pg_num_rows($result);

if ($numrows == 0){
  echo "Utente non trovato.";
}
else
{
  echo '<table style="width:60%"> <tr>';
  echo "<b><th>Nome</th><th>Cognome</th><th>Email</th><th>Cellulare</th><th>Nascita</th><th>Evento</th><th>Privacy</th><th>Covid1</th><th>Covid2</th><th>Covid3</th><th>Presente</th><th>Segna Presente</th></b></tr>";
    
  for ($x = 0; $x < $numrows; $x++){
    $resrow = pg_fetch_row($result);
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

	echo "<tr>";
	echo "<td>" . $nome . "</td>";
    echo "<td>" . $cognome . "</td>";
	echo "<td>" . $email . "</td>";
	echo "<td>" . $cellulare . "</td>";
	echo "<td>" . $nascita . "</td>";
	echo "<td>" . $evento . "</td>";
	echo "<td>" . $privacy . "</td>";
	echo "<td>" . $covid1 . "</td>";
	echo "<td>" . $covid2 . "</td>";
	echo "<td>" . $covid3 . "</td>";
    echo "<td>" . $presente . "</td>";
	echo "<td>" . "<button onClick=\"window.location.href='check.php?email=" . $email . "&evento=" . $evento . "';\">X</button>" . "</td>";
	echo "</tr>";
  }
  echo "</table>";
}
?>
</div>
</body> </html> 