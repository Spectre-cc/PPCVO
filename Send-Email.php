<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-personel.php'); ?>
<?php include('./functions/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <title>Send Announcement</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                <form method="POST" action="functions/sendemail.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Send Announcement</h2>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="recepient">Recipient</label>
                            <select class="form-select m-0 inputbox text-start" id="recipient" name="recipient" required>
                                <option value="Clients">Clients</option>
                                <option value="Personnel">Personnel</option>                                                        
                            </select>
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
                            <button class="btn btn-primary w-50" type="submit" name="send" id="send"><i class="fa-solid fa-envelope"></i> Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>