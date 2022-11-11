<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
  $query="SELECT clientID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM client ORDER BY name ASC";
  $result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Client List</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container">
                        <div class="container text-center pt-3">
                            <h2>Client Records</h2>
                            <div class="container-fluid d-flex justify-content-center text-center">
                                <form class="w-50 d-flex justify-content-center" action="">
                                    <div class="w-100 d-flex justify-content-center bg-white border border-secondary rounded-pill">
                                        <input class="form-control rounded-pill bg-transparent" style="border:0;" type="search" name="string" id="string" placeholder="Search for client...">
                                        <button class="btn btn-transparent text-secondary" type="submit" name="search" id="search"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid my-2">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddClient" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <div class="container-fluid d-flex justify-content-center align-items-center text-center">
                                <table class="table table-condensed table-bordered table-hover text-start w-75">
                                    <thead>
                                        <th class="largecell text-bg-dark">Name</th>
                                        <th class="autocell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="largecell"><?php echo $data['name']; ?></td>
                                            <td class="autocell d-flex justify-content-center align-items-center" >
                                                <a href="View-Client-Record.php?clientid=<?php echo $data['clientID']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-eye"></i> View Client Record</button></a>
                                                <a href="View-Animals-Owned.php?clientid=<?php echo $data['clientID']; ?>&clientname=<?php echo $data['name']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-paw"></i> View Animals Owned</button></a>
                                            </td>
                                        </tr>
                                        <?php 
                                        endforeach; 
                                        mysqli_free_result($result);
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddClient" tabindex="-1" aria-labelledby="AddClientLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-5 " id="AddClientLabel">Add Client</h1>
                </div>
                <form method="POST" action="functions/add-client.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="fName">First Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="fName" id="fName" placeholder="Enter first name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="mname">Middle Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="mName" id="mName" placeholder="Enter middle name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="lName">Last Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="lName" id="lName" placeholder="Enter last name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="birthdate">Birthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="sex">Sex</label>
                            <select class="form-select m-0 inputbox" id="sex" name="sex">                                
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="barangay">Barangay</label>                            
                            <input class="form-control m-0 inputbox" type="text" id="barangay" name="barangay" placeholder="Enter barangay..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="cNumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" name="cNumber" id="cNumber" placeholder="Enter contact number..." maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="contactnumber">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" name="email" placeholder="Enter email..." required>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" id="add-client" name="add-client"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>