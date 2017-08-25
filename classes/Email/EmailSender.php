<?php
namespace Email;

use \Config;

class EmailSender {

    private static $errorMsg;
    
    public static function send($addresses, $subject, $body){
        $mail = self::getPHPMailer();

        foreach ($addresses as $addr){
            $mail->addAddress($addr['email'], $addr['name']);
        }
        $mail->Subject = $subject;
        $mail->Body = $body;

        if ($mail->send())
            return true;
        self::$errorMsg = $mail->ErrorInfo;
        return false;
    }

    private static function getPHPMailer(){
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug  = 1;
        $mail->Host = Config::get('email.host');
        $mail->SMTPAuth = Config::get('email.smtp_auth');
        $mail->Username = Config::get('email.username');
        $mail->Password = Config::get('email.password');
        $mail->SMTPSecure = Config::get('email.tls');
        $mail->Port = Config::get('email.port');
        $mail->CharSet = "UTF-8";

        $mail->setFrom(Config::get('email.default_from'),
                       Config::get('e
mail.default_name'));
        return $mail;
    }

    public static function getErrorMsg(){
        return self::$errorMsg;
    }
}
?>
