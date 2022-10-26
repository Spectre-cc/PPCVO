<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['send'])){
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';
    require('config/config.php');
    require('config/db.php');

    $recepient = $_POST['recipient'];

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'duenasmauie@gmail.com';
    $mail->Password = 'xvlasglnlqqqnvdt';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('duenasmauie@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];

    

    if($recepient == "Clients"){
        //retrieve email addresses
        $query = "SELECT email FROM client;";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {

            foreach ($result as $data):
                $mail->addAddress($data['email']);
                if($mail->send())
                {
                    $alertmessage = urlencode("Emails Sent!");
                    header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
                    exit();
                }
                else{
                    $alertmessage = urlencode("Failed to send emails!");
                    header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
                    exit();
                }
            endforeach;
        } 
    }
    if($recepient == "Personnel"){
        //retrieve email addresses
        $query = "SELECT email FROM user;";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
            while($x = mysqli_fetch_assoc($result)) {
                $mail->addAddress($x['email']);
            }
            if($mail->send())
            {
                $alertmessage = urlencode("Emails Sent!");
                header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
                exit();
            }
            else{
                $alertmessage = urlencode("Failed to send emails!");
                header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
                exit();
            }
        } 
    }
}
else{
    header('Location: ../Index.php');
    exit();
}

?>