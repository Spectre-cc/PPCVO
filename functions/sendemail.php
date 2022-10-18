<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['send'])){
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'duenasmauie@gmail.com';
    $mail->Password = 'xvlasglnlqqqnvdt';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('duenasmauie@gmail.com');

    $mail->addAddress($_POST['recepient']);
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];

    $mail->send();

    header('Location: ../Send-Email.php');
    exit();
}
else{
    header('Location: ../LogIn-Personnel.php');
    exit();
}

?>