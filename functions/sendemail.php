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
    $mail->Password = 'pooctfevajgyounx';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('duenasmauie@gmail.com');
    $mail->isHTML(true);

    //Compose email subject and message
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];
    if($recepient == "Clients"){
        $barangay = $_POST['barangay'];
        if($barangay == "All"){
            //retrieve email addresses
            $query = "SELECT email FROM clients;";
            $result = mysqli_query($conn, $query);
        }else{
            $query = '
                SELECT 
                    clients.email
                FROM 
                    `clients`,
                    `clients_addresses`,
                    `barangays`
                WHERE 
                    clients.addressID = clients_addresses.addressID
                    AND
                    clients_addresses.barangayID = barangays.barangayID
                    AND
                    barangays.brgy_name = ?
            ';
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL error!");
                header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $barangay);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }
        }
        //send emails individualy
        if(mysqli_num_rows($result) > 0) {
            foreach ($result as $data):
                if($data['email']){
                    $mail->addAddress($data['email']); 
                }
            endforeach;
            $mail->send();
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
                if($data['email']){
                    $mail->addAddress($data['email']); 
                }
            endforeach;
            $mail->send();
            $alertmessage = urlencode("Email Sent!");
            header('Location: ../Send-Email.php?alertmessage='.$alertmessage);
            exit();
        } 
    }
}
else{
    header('Location: logout.php?alertmessage='.$alertmessage);
    exit();
}

?>