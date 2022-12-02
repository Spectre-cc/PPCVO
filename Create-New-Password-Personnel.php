<?php include('./functions/alert.php'); ?>
<?php 
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];

    //check if selector and validator are empty
    if(empty($selector || empty($validator))){
        $alertmessage = urlencode("Could not validate your request!");
        header('Location: LogIn-Personnel.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //check if selector and validator are valid hexadecimal
        if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){

        }
        else{
            $alertmessage = urlencode("Invalid token and validator!");
            header('Location: LogIn-Personnel.php?alertmessage='.$alertmessage);
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <title>Create New Password</title>
</head>
<body class="ploginbg">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
        <form method="POST" action="functions/passwordreset-personnel.php" class="bg-light needs-validation p-4 rounded-4 align-items-center">
            <div class="container-fluid text-center">
                <h2>Create New Password</h2>
            </div>
            <div class="form-group was-validated pt-2">
                <input type="hidden" name="selector" id="selector" value="<?php echo $selector; ?>">
                <input type="hidden" name="validator" id="validator" value="<?php echo $validator; ?>">
                <input class="form-control inputbox" type="password" id="newpassword" name="newpassword" placeholder="Enter new password..." required>
                <div class="invalid-feedback">Please enter valid password...</div>
            </div>
            <div class="form-group pt-3 container-fluid text-center">
                <input class="btn btn-primary w-50" type="submit" id="create-password" name="create-password" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>