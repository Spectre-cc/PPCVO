<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>

<?php 
    $query="SELECT * FROM veterinarian;";
    $result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Veterinarian</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2>Veterinarian</h2>
                            </div>
                            <div class="container-fluid mb-2 text-center">
                                <a href="Add-Veterinarian-Form.php"><button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button></a>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="medcell text-bg-dark">First Name</th>
                                        <th class="medcell text-bg-dark">Middle Name</th>
                                        <th class="medcell text-bg-dark">Last Name</th>
                                        <th class="medcell text-bg-dark">License Number</th>
                                        <th class="medcell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="medcell"><?php echo $data['fName']; ?></td>
                                            <td class="medcell"><?php echo $data['mName']; ?></td>
                                            <td class="medcell"><?php echo $data['lName']; ?></td>
                                            <td class="largecell"><?php echo $data['licenseNo']; ?></td>
                                            <td class="med d-flex justify-content-center align-items-center" >
                                                <a href="Update-Veterinarian-Form.php?vetID=<?php echo $data['vetID']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="functions/delete-veterinarian.php?vetID=<?php echo $data['vetID']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
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
</body>
</html>