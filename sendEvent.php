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
<h2>Imposta evento</h2>
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$evento = $_POST['evento']; $disattiva = $_POST['disattiva']; $attiva = $_POST['attiva'];
$myconn = @pg_connect($connstring);
$query = "SELECT ID FROM evento ORDER BY ID DESC LIMIT 1";
$result = pg_query($myconn,$query);
$numrows = pg_num_rows($result);
if ($numrows == 1) {
    $resrow = pg_fetch_row($result);
    $currentEvent = $resrow[0];
}
if ($evento != "") {
	$query = "INSERT INTO evento(NOME) VALUES ('$evento')";
	if(false === pg_query($myconn, $query)) {
		exit("Errore: impossibile eseguire la query." . pg_result_error($myconn));
	}
	pg_close($myconn);
	echo "Nuovo evento creato.<br/>";
}
if ($disattiva == "Disattiva prenotazioni") {
	$query = "UPDATE evento SET disattivato = 1 WHERE ID = '$currentEvent'";
	if(false === pg_query($myconn, $query)) {
		exit("Errore: impossibile eseguire la query." . pg_result_error($myconn));
	}
	pg_close($myconn);
	echo "Prenotazioni disabilitate.<br/>";
}
if ($attiva == "Attiva prenotazioni") {
	$query = "UPDATE evento SET disattivato = 0 WHERE ID = '$currentEvent'";
	if(false === pg_query($myconn, $query)) {
		exit("Errore: impossibile eseguire la query." . pg_result_error($myconn));
	}
	pg_close($myconn);
	echo "Prenotazioni abilitate.<br/>";
}
pg_close($myconn);
?>
</div>
</body>
</html>