<?php namespace Models\Classes;


use http\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailService
{
    public function sendEmail(string $email, string $tokenValue)
    {
        require '../vendor/autoload.php';
        $link = "http://zap.local/Connexion/Authentication/Email/Connect?token=$tokenValue";
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp-mail.outlook.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'joshua10@hotmail.fr';
            $mail->Password = getenv("my-pass");
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('joshua10@hotmail.fr', 'Zapper');
            $mail->addAddress($email, sess("name"));

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Email verification';
            $mail->Body    = "If this email has been sent to you it is for " .
                "your second factor authentication on zapper.com. To verify " .
                "your connexion, simply click on the link below. <br><a href=$link>Click me</a>";
            $mail->send();
        } catch (Exception $e) {
            return;
        }
    }
}
