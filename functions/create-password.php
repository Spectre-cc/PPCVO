<?php
    if(isset($_POST['create-password'])){
        require('config/config.php');
        require('config/db.php');
        $selector = $_POST['selector'];
        $validator = $_POST['validator'];
        $newpassword = $_POST['newpassword'];
        
        //check if feild is empty
        if(empty($newpassword)){
            $alertmessage = urlencode("Please enter valid password!");
            header('Location: Create-New-Password-Personnel.php?selector='.$selector.'&validator'.$validator.'&alertmessage='.$alertmessage);
            exit();
        }

        //check if token is expired
        $currentdate = date("U");

        //check if non-expired selector exist
        //prepare statement before execution
        $query="SELECT * FROM passwordreset WHERE selector=? AND expiration>=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL Error1!");
            header('Location: Create-New-Password-Personnel.php?selector='.$selector.'&validator'.$validator.'&alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $selector, $currentdate);
            mysqli_stmt_execute($stmt);
            
            //get result
            $result = mysqli_stmt_get_result($stmt);
            //check for a match
            if(!$row = mysqli_fetch_assoc($result)){
                $alertmessage = urlencode("Token Expired! Please resubmit a request.");
                header('Location: ../Index.php?alertmessage='.$alertmessage);
                exit();
            }
            else{
                $tokenbin = hex2bin($validator);
                $tokencheck = password_verify($tokenbin, $row['token']); 

                if($tokencheck === false){
                    $alertmessage = urlencode("Token does not match! Please resubmit a request.");
                    header('Location: ../Index.php?alertmessage='.$alertmessage);
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
                        if(!$row = mysqli_fetch_assoc($result)){
                            $alertmessage = urlencode("Account not found! Please resubmit a request!");
                            header('Location: ../Index.php?alertmessage='.$alertmessage);
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

                                mysqli_stmt_bind_param($stmt, "ss", $hashednewpassword, $tokenemail);
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
                                    header('Location: Index.php?alertmessage='.$alertmessage);
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
        header('Location: ../Index.php');
        exit();
    }
?>