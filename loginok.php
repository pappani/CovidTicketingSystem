<?php
session_start();
if(!isset($_SESSION['email'])) {
header("Location: login.php");
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
Login completato.<br/>
Benvenuto nell'area riservata <br/><br/>
<button onClick="window.location.href='logout.php';">Logout</button><br/><br/>
<button onClick="window.location.href='showAll.php';">Mostra tutti gli utenti</button><br/><br/>
<button onClick="window.location.href='showToday.php';">Mostra utenti evento corrente</button><br/><br/>
<button onClick="window.location.href='showPresent.php';">Mostra utenti presenti evento corrente</button><br/><br/>
<button onClick="window.location.href='search.php';">Cerca utente</button><br/><br/>
<button onClick="window.location.href='setEvent.php';">Imposta evento</button><br/><br/>
<button onClick="window.location.href='showEvents.php';">Lista eventi</button><br/><br/>
</div>
</body>
</html>