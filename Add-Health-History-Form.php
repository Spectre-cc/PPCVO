<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Add Health History</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form action="" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Health History</h2>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="birthdate">Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="case">Case History / Complaint</label>
                            <textarea name="case" id="case" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="name">Prescription</label>
                            <textarea name="prescription" id="prescription" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="treatment">Treatment</label>
                            <textarea name="treatment" id="treatment" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="name">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="veterinarian">Veterinarian</label>
                            <input class="form-control m-0 inputbox" type="text" id="veterinarian" placeholder="..." required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-success w-50" type="submit" id="submit" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>