<html>
<head>
<title>FP Events</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
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
</style>
</head>
<body style="background-color:white;">
<div class="taskbar">
<br/>
<img src="logo.png" width="333" height="95" alt="FP Events">
<?php
$user = 'USERNAME'; $password="PASSWORD"; $host="HOST"; $database="DATABASE";
$connstring = "CONNSTRING";
$myconn = @pg_connect($connstring);

$nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
$cognome = filter_var($_POST['cognome'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$cellulare = filter_var($_POST['cellulare'], FILTER_SANITIZE_STRING);
$mese = filter_var($_POST['mese'], FILTER_SANITIZE_STRING);
$anno = filter_var($_POST['anno'], FILTER_SANITIZE_STRING);
$evento = filter_var($_POST['evento'], FILTER_SANITIZE_STRING);
$privacy = filter_var($_POST['privacy'], FILTER_SANITIZE_STRING);
$covid1 = filter_var($_POST['covid1'], FILTER_SANITIZE_STRING);
$covid2 = filter_var($_POST['covid2'], FILTER_SANITIZE_STRING);
$covid3 = filter_var($_POST['covid3'], FILTER_SANITIZE_STRING);
$nascita = $mese . '-' . $anno; $time = date("Y-m-d H:i:s");
$nome = pg_escape_string($myconn, $nome);
$cognome = pg_escape_string($myconn, $cognome);
$email = pg_escape_string($myconn, $email);
$cellulare = pg_escape_string($myconn, $cellulare);
$mese = pg_escape_string($myconn, $mese);
$anno = pg_escape_string($myconn, $anno);
$evento = pg_escape_string($myconn, $evento);
$privacy = pg_escape_string($myconn, $privacy);
$covid1 = pg_escape_string($myconn, $covid1);
$covid2 = pg_escape_string($myconn, $covid2);
$covid3 = pg_escape_string($myconn, $covid3);

if ($nome == "" || $cognome == "" || $email == "" || $cellulare == "" || $mese == "" || $anno == "" || $evento == "") die("<hr/></div><div><br/><br/>Non hai inserito tutti i dati necessari.");
if ($privacy != 1 || $covid1 != "No" || $covid2 != "No") die("<hr/></div><div><br/><br/>Le normative di prevenzione al contagio da Covid-19 non ci permettono di confermare la tua richiesta di prenotazione.<br/>Per poter accedere all'evento non devi aver sintomi riconducibili al Covid-19 e nemmeno esserne a venuto a contatto negli scorsi 15 giorni.");

$queryCheck = "SELECT * FROM biglietti WHERE email = '$email' AND evento = '$evento'";
$query = "INSERT INTO biglietti(NOME, COGNOME, EMAIL, CELLULARE, NASCITA, EVENTO, PRIVACY, COVID1, COVID2, COVID3, DATA_PRENOTAZIONE)
		VALUES ('$nome', '$cognome', '$email', '$cellulare', '$nascita', '$evento', '$privacy', '$covid1', '$covid2', '$covid3', '$time')";

$result = pg_query($myconn, $queryCheck) or die("");
if (pg_num_rows($result) != 0) die("<hr/></div><div><h2>Hai già effettuato una prenotazione per questo evento.</h2>La prenotazione è personale.<br/>Se non hai ricevuto la mail contenente il QR Code controlla nella posta indesiderata.");
else if(false === pg_query($myconn, $query)) {
	exit("Errore");
}
pg_close($myconn);
include_once 'qrlib.php';
$codeContents = 'https://fpevents.herokuapp.com/check.php?email=' . $email . '&evento=' . rawurlencode($evento);

$fileName = 'QR_'.md5($codeContents).'.png';

$pngAbsoluteFilePath = $fileName;
define('IMAGE_WIDTH',500);
define('IMAGE_HEIGHT',500);    
// generating qr
if (!file_exists($pngAbsoluteFilePath)) {
    QRcode::png($codeContents, $pngAbsoluteFilePath);
    echo '<hr />';
} else {
    echo '<hr />';
}

pg_close($myconn);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();	//Send using SMTP
    $mail->Host       = 'SMTP_SERVER';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;          
	//$mail->SMTPSecure = "ssl";	//Enable SMTP authentication
    $mail->Username   = 'SMTP_USERNAME';  //SMTP username
    $mail->Password   = 'SMTP_PASSWORD';                     //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 2525;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('EMAIL_FROM', 'FP Events');
    $mail->addAddress($_POST['email']);     //Add a recipient

    //Attachments
    //$mail->addAttachment($pngAbsoluteFilePath);
	
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Prenotazione';
	$mail->AddEmbeddedImage($pngAbsoluteFilePath, 'qr', 'qr.jpg');
	$mail->AddEmbeddedImage('logo.png', 'logo', 'logo.png');
	
    $mail->Body    = "<meta charset='utf-8' /><table bgcolor='#ffffff' style='background:#ffffff; color:#000000; text-align: center;'><tr><td>
		<img src='cid:logo' style='width='333'; height='95';' alt='Logo'><br/><h2>Prenotazione confermata!</h2>Nome<br/><b>$nome</b><br/><br/>Cognome<br/><b>$cognome</b><br/><br/><b>$evento</b><br/><br/></b>
		Mostra questo QR Code all'ingresso: <br/><br/><img width='300' height='300' src='cid:qr'> 
		</p><br/><br/>&nbsp;Ricorda di portare con te un documento e la mascherina.&nbsp;<br/><br/><br/></td></tr></table><br/>";
    $mail->AltBody = "Prenotazione confermata. Mostra questo QR Code all'ingresso";

    $mail->send();
    echo "</div><div><h2>Prenotazione confermata.</h2><br>";
	echo "<b>Riceverai presto un email di conferma<br/>contenente il QR Code da mostrare all'ingresso.</b>";
	//echo '<img width="300" height="300" src="'.$pngAbsoluteFilePath.'" />';
} catch (Exception $e) {
    echo "Errore";
}
?>
</div>
<!-- Federico Pappani - pappani.me -->
</body>
</html>