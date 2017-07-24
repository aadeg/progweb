<?php

require_once('core/init.php');

use \Email\EmailSender;

$addrs = array(
    array(
	"email" => "andreagiove@outlook.com",
	"name" => "Andrea Giove"
    ));
$subj = 'Incedio';
$body = 'Siamo pronti a collaborare con le Regioni nel censimento dei danni e la verifica delle condizioni per dichiarare lo Stato di eccezionale avversità atmosferica". Lo annuncia il ministro delle Politiche agricole, Maurizio Martina, circa la situazione di siccità in atto. Sono state attivate misure di contrasto all\'emergenza. "Sono 3 - spiega - gli assi di intervento: attivazione del fondo di solidarietà nazionale, aumento degli anticipi dei fondi europei Pac, 700 mln per il piano rafforzamento delle infrastrutture irrigue';

if (!EmailSender::send($addrs, $subj, $body)){
    echo EmailSender::getErrorMsg();
} else {
    echo 'Send';
}

/*
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; 
$mail->SMTPAuth = true;
$mail->Username = 'pweb1617@gmail.com';
$mail->Password = 'andrea96';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('pweb1617@gmail.com', 'SimpleTicket');
$mail->addAddress('andreagiove@outlook.com', 'Andrea Giove');

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the body';

if(!$mail->send()) {
    echo 'Message could not be sent sadjkasdkjasd.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

echo 'HERE';
*/
?>
