<?php include('functions/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Password Reset</title>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
        <form method="POST" action="functions/passwordreset-personnel.php" class="bg-light needs-validation p-4 rounded-4 align-items-center">
            <div class="container-fluid text-center">
                <h3>Request password reset</h2>
            </div>
            <div class="form-group was-validated">
                <label class="form-label" for="email">Email</label>
                <input class="form-control inputbox" type="email" id="email" name="email" placeholder="example@email.com" required>
                <div class="invalid-feedback">Please enter valid email address...</div>
            </div>
            <div class="form-group pt-3 container-fluid text-center">
                <input class="btn btn-primary w-50" type="submit" id="password-reset" name="password-reset" value="Send">
            </div>
        </form>
    </div>
</body>
</html>