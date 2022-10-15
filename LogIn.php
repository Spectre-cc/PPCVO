<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Log In</title>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
        <form action="" class="bg-light needs-validation p-4 rounded-4 w-25 h-auto align-items-center">
            <div class="container text-center">
                <img class="login-logo img-fluid" src="style/assets/images/PPCVIO-Logo-trnsprnt.png" alt="" >
            </div>
            <div class="form-group was-validated">
                <label for="" class="form-label m-0" for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                <input class="form-control m-0 inputbox" type="email" id="email" placeholder="example@email.com" required>
                <div class="invalid-feedback m-0">Please enter valid email address...</div>
            </div>
            <div class="form-group was-validated">
                <label for="" class="form-label m-0" for="password"><i class="fa-solid fa-key"></i> Password</label>
                <input class="form-control inputbox m-0" type="password" id="password" placeholder="*****" required>
                <div class="invalid-feedback m-0">Please enter valid password...</div>
                <div class="container-fluid text-end"><a class="link-success" href="Password-Recovery.html">forgot password?</a></div>
            </div>
            <div class="form-group pt-3 container-fluid text-center">
                <input class="btn btn-primary w-50" type="submit" id="submit" value="Log In">
            </div>
        </form>
    </div>
</body>
</html>