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
                                <a href="Add-Client-Form.php"><button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button></a>
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
</body>
</html>