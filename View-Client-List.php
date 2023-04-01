<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-personel.php'); ?>
<?php include('./functions/alert.php'); ?>

<?php 
  if(isset($_POST['search-client'])){
    $search = '%'.mysqli_real_escape_string($conn,$_POST['string']).'%';
    $query = "
    SELECT 
	    clientsA.clientID, 
	    clientsA.fullName, 
	    clientsA.fname 
    FROM 
        (SELECT clients.clientID, CONCAT(clients.fName, ' ', clients.mName, ' ', clients.lName) as 'fullName', clients.fname FROM clients) as clientsA
    WHERE
        clientsA.fullName LIKE ?
    ORDER BY 
        clientsA.fullName ASC;
    ";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $query)){
        $alertmessage = urlencode("SQL error!");
        header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
        exit();
      }
      else{
        mysqli_stmt_bind_param($stmt, "s", $search);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
      }
  }else{
    $query="SELECT clientID, CONCAT(fName, ' ', mName, ' ', lName) as 'fullName', fname FROM clients ORDER BY fullName ASC";
    $result = mysqli_query($conn,$query);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <title>Client List</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container">
                        <div class="container text-center pt-3">
                            <h2>Client Records</h2>
                            <div class="container-fluid d-flex justify-content-center text-center">
                                <form class="w-50 d-flex justify-content-center" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="w-100 d-flex justify-content-center bg-white border border-secondary rounded-pill">
                                        <input class="form-control search bg-transparent" style="border:0;" type="search" name="string" id="string" placeholder="Search for client...">
                                        <button class="btn btn-secondary text-light searchbtn border" type="submit" name="search-client" id="search-client"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid my-2">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#DPDisclaimer" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <div class="container-fluid d-flex justify-content-center align-items-center text-center">
                                <table class="table table-condensed table-bordered table-hover text-start w-75">
                                    <thead>
                                        <th class="largecell text-bg-dark">Name</th>
                                        <th class="autocell bg-dark textCenter"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="largecell"><?php echo $data['fullName']; ?></td>
                                            <td class="autocell d-flex justify-content-center align-items-center" >
                                                <a href="View-Client-Record.php?clientID=<?php echo $data['clientID']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-eye"></i> View Client Information</button></a>
                                                <a href="View-Animals-Owned.php?clientID=<?php echo $data['clientID']; ?>&clientname=<?php echo $data['fname']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-paw"></i> View Animals Owned</button></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="DPDisclaimer" tabindex="-1" aria-labelledby="DPDisclaimerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-warning text-light">
                    <h1 class="modal-title fs-5 " id="DPDisclaimerLabel"><i class="fa-solid fa-circle-info fa-lg"></i> Data Privacy Disclaimer</h1>
                </div>
                <div class="modal-body">
                    <p>
                    DATA PRIVACY DISCLAIMER <br><br>

This data privacy disclaimer is provided in compliance with Republic Act No. 10173 or the Data Privacy Act of 2012 and its implementing rules and regulations.<br><br>

The information that we collect from you may include your personal information such as your name, address, email address, and contact number. We collect this information solely for the purpose of providing you with the products and services that you have requested.<br><br>

We respect your right to privacy and will only use your personal information for the purposes for which it was collected. We will not sell, rent, or disclose your personal information to third parties without your consent, except as required by law.<br><br>

We implement reasonable and appropriate security measures to protect your personal information against unauthorized access, use, or disclosure. We retain your personal information for as long as necessary to fulfill the purposes for which it was collected, unless a longer retention period is required by law.<br><br>

You have the right to access, modify, or erase your personal information that we have collected, subject to the limitations provided by law. You may also file a complaint if you believe that your personal information has been mishandled or improperly disclosed.<br><br>

By using our products and services, you acknowledge that you have read and understood this data privacy disclaimer and consent to the collection, use, and disclosure of your personal information as described herein.<br><br>

If you have any questions or concerns about our data privacy practices, please contact us at ppcvo@gmail.com.    
                    </p>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button class="btn btn-success w-25" data-bs-toggle="modal" data-bs-target="#AddClient" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Accept</button>
                    <button class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddClient" tabindex="-1" aria-labelledby="AddClientLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-5 " id="AddClientLabel"><i class="fa-solid fa-circle-info fa-lg"></i> Client Information</h1>
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
                            <label class="form-label m-0" for="address">Address</label>                            
                            <input class="form-control m-0 inputbox" type="text" id="address" name="address" placeholder="Enter address...">
                        </div>
                        <div class="form-group">
                            <label for="barangay" class="form-label m-0">Barangay</label>
                            <input class="form-control m-0 inputbox" list="datalistOptions" id="barangay" name="barangay" placeholder="Enter barangay..." required>
                                <datalist id="datalistOptions">
                                <?php 
                                    $query="SELECT brgy_name FROM barangays ORDER BY brgy_name ASC";
                                    $result = mysqli_query($conn,$query);
                                    foreach($result as $data) :
                                ?>
                                    <option value="<?php echo $data['brgy_name']; ?>">
                                <?php 
                                    endforeach; 
                                ?>
                                </datalist>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="cNumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" name="cNumber" id="cNumber" placeholder="Enter contact number..." maxlength="50">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="contactnumber">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" name="email" placeholder="Enter email...">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" id="add-client" name="add-client"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="reset" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>