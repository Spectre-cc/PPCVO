<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['send'])){
    require 'vendor/autoload.php';
    require('config/config.php');
    require('config/db.php');

    session_start();
    $_SESSION["alert"]=true;

    //Declare recipient variable
    $recepient = $_POST['recipient'];

    //Initialize PHPMailer
    $mail = new PHPMailer(true);

    //Email configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'duenasmauie@gmail.com';
    $mail->Password = 'xvlasglnlqqqnvdt';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('duenasmauie@gmail.com');
    $mail->isHTML(true);

    //Compose email subject and message
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];
    if($recepient == "Clients"){

        //retrieve email addresses
        $query = "SELECT email FROM client;";
        $result = mysqli_query($conn, $query);

        //send emails individualy
        if(mysqli_num_rows($result) > 0) {
            foreach ($result as $data):
                $mail->addAddress($data['email']);
                $mail->send();
            endforeach;
            $alertmessage = urlencode("Emails Sent!");
            header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
            exit();
        } 
    }
    if($recepient == "Personnel"){
        //retrieve email addresses
        $query = "SELECT email FROM user;";
        $result = mysqli_query($conn, $query);
        
        //send emails individualy
        if(mysqli_num_rows($result) > 0) {
            foreach ($result as $data):
                $mail->addAddress($data['email']);
                $mail->send();
            endforeach;
            $alertmessage = urlencode("Emails Sent!");
            header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
            exit();
        } 
    }
}
else{
    header('Location: ../Index.php');
    exit();
}

?>