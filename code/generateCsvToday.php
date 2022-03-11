<?php
session_start();
if(isset($_SESSION['email'])) {
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$myconn=@pg_connect($connstring);
$query = "SELECT * FROM iscrittiEventoCorrente";
$result=pg_query($myconn,$query);
pg_close($myconn);
$numrows = pg_num_rows($result);

if ($numrows == 0){
  echo "Database vuoto!";
}
$now = date_create()->format('d-m-Y-H-i-s');
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=EventoCorrente-' . $now . '.csv');  
$output = fopen("php://output", "w");  
fputcsv($output, array('ID', 'Nome', 'Cognome', 'Email', 'Cellulare', 'Nascita', 'Evento', 'Privacy', 'Covid1', 'Covid2', 'Covid3', 'Presente', 'Data Prenotazione', 'Data Conferma'));  
while($row = pg_fetch_assoc($result))  
{  
    fputcsv($output, $row);  
}  
fclose($output);  
} else {header("Location: index.php");}
?>