<?php
session_start();
// elimina le variabili di sessione impostate
$_SESSION = array();
// elimina la sessione
session_destroy();
echo "<h2>Disconnessione riuscita</h2>"
?>