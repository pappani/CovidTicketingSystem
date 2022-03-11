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
<form action="sendSearch.php" method="post">
Cognome<br><input type="text" name="cognome"><br><br>
Email<br><input type="text" name="email"><br><br>
Cellulare<br><input type="text" name="cellulare"><br><br>
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$myconn=@pg_connect($connstring);
$query = "SELECT * FROM evento ORDER BY ID DESC LIMIT 1";
$result = pg_query($myconn,$query);
pg_close($myconn);
$numrows = pg_num_rows($result);
if ($numrows == 1) {
    $resrow = pg_fetch_row($result);
    $evento = $resrow[1];
}
echo "Evento: " . $evento;
echo '<br/><input type="hidden" name="evento" value="' . $evento . '">';
?>
<input type="submit" name="send" value="Cerca"/>
</form>
</div>
</body> </html> 