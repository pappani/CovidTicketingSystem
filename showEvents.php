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
<h2>Lista degli eventi</h2>
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$myconn=@pg_connect($connstring);
$query = "SELECT * FROM evento ORDER BY ID DESC";
$result=pg_query($myconn,$query);
pg_close($myconn);
$numrows = pg_num_rows($result);

if ($numrows == 0){
  echo "<br/>Database vuoto!";
}
else
{
  echo '<br/><table style="width:60%"> <tr>';
  echo "<b><th>ID</th><th>Nome</th><th>Prenotazione disattivata?</th></b></tr>";
    
  for ($x = 0; $x < $numrows; $x++){
    $resrow = pg_fetch_row($result);
	$id = $resrow[0];
    $nome = $resrow[1];
    $prenotazione = $resrow[2];
	echo "<tr>";
	echo "<td>" . $id . "</td>";
    echo "<td>" . $nome . "</td>";
	echo "<td>" . $prenotazione . "</td>";
	echo "</tr>";
  }
  echo "</table>";
}
?>
</div>
</body> </html> 