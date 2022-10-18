<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Password Recovery</title>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
        <form action="" class="bg-light needs-validation p-4 rounded-4 align-items-center">
            <div class="container-fluid text-center">
                <h2>Password Recovery</h2>
            </div>
            <div class="form-group was-validated pt-2">
                <label for="" class="form-label" for="email">Email</label>
                <input class="form-control inputbox" type="email" id="email" placeholder="example@email.com" required>
                <div class="invalid-feedback">Please enter valid email address...</div>
            </div>
            <div class="form-group pt-3 container-fluid text-center">
                <input class="btn btn-primary w-50" type="submit" id="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>