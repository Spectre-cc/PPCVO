<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>

<?php 
  require('functions/config/config.php');
  require('functions/config/db.php');
  $query="SELECT * FROM user WHERE type='personnel'";
  $result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Personnel</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-auto">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2>Personnel</h2>
                            </div>
                            <div class="container-fluid mb-2 text-center">
                                <?php $usertype = urlencode("admin"); ?>
                                <a href="Add-User.php?type=<?php echo $usertype; ?>"><button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button></a>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="medcell text-bg-dark">Name</th>
                                        <th class="medcell text-bg-dark">Email</th>
                                        <th class="largecell text-bg-dark">Contact Number</th>
                                        <th class="medcell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="medcell"><?php echo $data['name']; ?></td>
                                            <td class="medcell"><?php echo $data['email']; ?></td>
                                            <td class="largecell"><?php echo $data['contactNumber']; ?></td>
                                            <td class="med d-flex justify-content-center align-items-center" >
                                                <a href="Update-User-Form.php?user=<?php echo $data['userid']; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="functions/delete-user.php?user=<?php echo $data['userid']; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
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