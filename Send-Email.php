<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Send Announcement</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-auto">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                <form method="POST" action="functions/sendemail.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Send Announcement</h2>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="recepient">Recepient</label>
                            <input class="form-control m-0 inputbox" type="email" name="recepient" id="recepient" placeholder="Enter email..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="subject">Subject</label>
                            <input class="form-control m-0 inputbox" type="text" name="subject" id="subject" placeholder="Enter email subject..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="message">Message</label>
                            <textarea class="form-control m-0 inputbox" name="message" id="message" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-primary w-50" type="submit" name="send" id="send" value="Send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>