<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require('config/config.php');
    require('config/db.php');

    if(isset($_POST['password-reset'])){
        //database connectionn

        //input
        $email = $_POST['email'];

        //check if email exist in database
        //prepare statement before execution
        $query="SELECT email FROM user WHERE email=? AND type='personnel'";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL Error");
            header('Location: ../Password-Reset-Personnel.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            
            //get result
            $result = mysqli_stmt_get_result($stmt);
            //check for a match
            if($row = mysqli_fetch_assoc($result)<1){
                $alertmessage = urlencode("Email does not exist!");
                header('Location: ../Password-Reset-Personnel.php?alertmessage='.$alertmessage);
                exit();
            }
        }

        //create selector and token
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        $url = "http://localhost/PPCVO/Create-New-Password-Personnel.php?selector=".$selector."&validator=".bin2hex($token);

        //token expires in 1 hour
        $expires = date("U")+1800;

        //delete any existing token for inputted email before creating new
        //prepare statement before execution
        $query="DELETE FROM passwordreset WHERE pwdresetemail=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL Error");
            header('Location: ../Password-Reset-Personnel.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            //Insert new token into database
            //prepare statement before execution
            $query="INSERT INTO passwordreset (pwdresetemail, selector, token, expiration	
            ) VALUES (?,?,?,?)";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL Error2");
                header('Location: ../Password-Reset-Personnel.php?alertmessage='.$alertmessage);
                exit();
            }
            else{
                //hash token before insert
                $hashedtoken = password_hash($token, PASSWORD_DEFAULT);
                
                mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedtoken, $expires);
                mysqli_stmt_execute($stmt);
            }

        }
        //close statements and connections
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        //use phpmailer to send email
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

        $recepient = $email;
        $subject = 'Password Reset';
        $message = '<p>We received a password reset request.</p>';
        $message .= '<p>The link to reset your password is:</p>';
        $message .= '<a href="'.$url.'">'.$url.'</a>';
        $message .= '<br>';
        $message .= '<p>If you did not make this request, you can ignore this email.';

        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();

        $alertmessage = urlencode("Password Request Sent! Please check your email.");
        header('Location: ../Password-Reset-Personnel.php?alertmessage='.$alertmessage);
        exit();
    }
    else if(isset($_POST['create-password'])){
        $selector = $_POST['selector'];
        $validator = $_POST['validator'];
        $newpassword = $_POST['password'];
        
        //check if feild is empty
        if(empty($newpassword)){
            $alertmessage = urlencode("Please enter valid password!");
            header('Location: LogIn-Personnel.php?selector='.$selector.'&validator'.$validator.'&alertmessage='.$alertmessage);
            exit();
        }

        //check if toke is expired
        $currentdate = date("U");

        //check if non-expired selector exist
        //prepare statement before execution
        $query="SELECT * FROM passwordreset WHERE selector=? AND expiration>=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL Error!");
            header('Location: Create-New-Password-Personnel.php?selector='.$selector.'&validator'.$validator.'&alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentdate);
            mysqli_stmt_execute($stmt);
            
            //get result
            $result = mysqli_stmt_get_result($stmt);
            //check for a match
            if(!$row = mysqli_fetch_assoc($result)<1){
                $alertmessage = urlencode("Please resubmit a request!");
                header('Location: ../LogIn-Personnel.php?alertmessage='.$alertmessage);
                exit();
            }
            else{
                $tokenbin = hex2bin($validator);
                $tokencheck = password_verify($tokenbin, $row['token']); 

                if($tokencheck === false){
                    $alertmessage = urlencode("Please resubmit a request!");
                    header('Location: ../LogIn-Personnel.php?alertmessage='.$alertmessage);
                    exit();
                }
                else{
                    $tokenemail = $row['pwdresetemail'];

                    //prepare statement before execution
                    $query="SELECT * FROM user WHERE email=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $query)){
                        $alertmessage = urlencode("SQL Error!");
                        header('Location: Create-New-Password-Personnel.php?selector='.$selector.'&validator'.$validator.'&alertmessage='.$alertmessage);
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "s", $tokenemail);
                        mysqli_stmt_execute($stmt);

                        //get result
                        $result = mysqli_stmt_get_result($stmt);

                        //check for a match
                        if(!$row = mysqli_fetch_assoc($result)<1){
                            $alertmessage = urlencode("Please resubmit a request!");
                            header('Location: ../LogIn-Personnel.php?alertmessage='.$alertmessage);
                            exit();
                        }
                        else{
                            //prepare statement before execution
                            $query="UPDATE user SET password=? WHERE email=?";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $query)){
                                $alertmessage = urlencode("SQL Error!");
                                header('Location: Create-New-Password-Personnel.php?selector='.$selector.'&validator'.$validator.'&alertmessage='.$alertmessage);
                                exit();
                            }
                            else{
                                //hash password before insert
                                $hashednewpassword = password_hash($newpassword, PASSWORD_DEFAULT);

                                mysqli_stmt_bind_param($stmt, "s", $hashednewpassword, $tokenemail);
                                mysqli_stmt_execute($stmt);

                                //delete any existing token for inputted email before creating new
                                //prepare statement before execution
                                $query="DELETE FROM passwordreset WHERE pwdresetemail=?";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $query)){
                                    $alertmessage = urlencode("SQL Error");
                                    header('Location: Create-New-Password-Personnel.php?selector='.$selector.'&validator'.$validator.'&alertmessage='.$alertmessage);
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt, "s", $tokenemail);
                                    mysqli_stmt_execute($stmt);
                                    $alertmessage = urlencode("New password has been successfully created!");
                                    header('Location: LogIn-Personnel.php?alertmessage='.$alertmessage);
                                    exit();
                                }
                            }   
                        }
                    }
                }
            }
        }
        //close statements and connections
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else{
        header('Location: ../LogIn-Personnel.php');
        exit();
    }
?>