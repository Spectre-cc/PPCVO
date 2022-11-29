<?php 
    if(!empty($_GET['alertmessage'])){
        echo '
        <script>
        alert("'.$_GET['alertmessage'].'")
        </script>
        ';
    }

    session_start();
    if(!empty($_SESSION['type'])){
        if($_SESSION['type'] == "personnel"){
            header('Location: View-Client-List.php');
            exit();
        }elseif($_SESSION['type'] == "admin"){
            header('Location: Analytics.php');
            exit();
        }else{
            echo '
            <script>
            alert("Invalid user type!")
            </script>
            ';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Log In</title>
</head>
<body class="ploginbg">
    <nav class="navbar bg-light bg-gradient bg-opacity-50 shadow">
        <div class="container-fluid">
            <div class="navbar-brand">
                <a class="navbar-brand topnav text-light fw-bold">
                    <img class="img-fluid rounded-circle shadow" width="40" height="auto" src="inc/style/assets/images/PPCVIO-Logo-wht.png" alt="" >
                    Puerto Princesa City Veterinary Office 
                </a>
            </div>
            <button type="button" class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#PersonnelLogIn" data-bs-whatever="@mdo"><i class="fa-solid fa-right-to-bracket"></i> Log In</button>
        </div>  
    </nav>
    <div class="text-center h-100" style="margin-top: 2vh; margin-bottom: 2vh;">
            <h1 class="h1 text-light topnav">Follow us on Facebook <i class="fa-solid fa-flag fa-sm"></i></h1>
            <iframe class="rounded-5 shadow"  src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100069074864948&tabs=timeline&width=500&height=550&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="500" height="550" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
    </div>

    <div class="modal fade" id="PersonnelLogIn" tabindex="-1" aria-labelledby="PersonnelLogIn" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-primary text-light">
                    <h1 class="modal-title fs-5 " id="PersonnelLogIn"><i class="fa-solid fa-person fa-lg"></i> Personnel</h1>
                </div>
                <form method="POST" action="functions/login-personnel.php" class="needs-validation"> 
                    <div class="modal-body">
                        <div class="form-group was-validated">
                            <label for="" class="form-label m-0" for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                            <input class="form-control m-0 inputbox" name="email" type="email" id="email" placeholder="example@email.com" required>
                            <div class="invalid-feedback m-0">Please enter valid email address...</div>
                        </div>
                        <div class="form-group was-validated">
                            <label for="" class="form-label m-0" for="password"><i class="fa-solid fa-key"></i> Password</label>
                            <input class="form-control inputbox m-0" name="password" type="password" id="password" placeholder="*****" required>
                            <div class="invalid-feedback m-0">Please enter valid password...</div>
                            <div class="container-fluid text-end">
                                <a class="link-primary" href="" data-bs-toggle="modal" data-bs-target="#PersonnelPwdReset" data-bs-whatever="@mdo">forgot password?</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary w-75 shadow" type="submit" id="login-personnel" name="login-personnel"><i class="fa-solid fa-right-to-bracket"></i> Log In</button>
                        <div class="container-fluid text-center">
                            <a class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#AdminLogIn" data-bs-whatever="@mdo"><i class="fa-solid fa-user-tie"></i> Admin</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AdminLogIn" tabindex="-1" aria-labelledby="AdminLogIn" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-primary text-light">
                    <h1 class="modal-title fs-5 " id="AdminLogIn"><i class="fa-solid fa-user-tie fa-lg"></i> Admin</h1>
                </div>
                <form method="POST" action="functions/login-admin.php" class="needs-validation"> 
                    <div class="modal-body">
                        <div class="form-group was-validated">
                            <label for="" class="form-label m-0" for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                            <input class="form-control m-0 inputbox" name="email" type="email" id="email" placeholder="example@email.com" required>
                            <div class="invalid-feedback m-0">Please enter valid email address...</div>
                        </div>
                        <div class="form-group was-validated">
                            <label for="" class="form-label m-0" for="password"><i class="fa-solid fa-key"></i> Password</label>
                            <input class="form-control inputbox m-0" name="password" type="password" id="password" placeholder="*****" required>
                            <div class="invalid-feedback m-0">Please enter valid password...</div>
                            <div class="container-fluid text-end">
                                <a class="link-primary" href="" data-bs-toggle="modal" data-bs-target="#AdminPwdReset" data-bs-whatever="@mdo">forgot password?</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary w-75 shadow" type="submit" id="login-admin" name="login-admin"><i class="fa-solid fa-right-to-bracket"></i> Log In</button>
                        <div class="container-fluid text-center">
                            <a class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#PersonnelLogIn" data-bs-whatever="@mdo"><i class="fa-solid fa-person fa-lg"></i> Personnel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="PersonnelPwdReset" tabindex="-1" aria-labelledby="PersonnelPwdReset" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-secondary text-light">
                    <h1 class="modal-title fs-5 " id="PersonnelPwdReset"><i class="fa-solid fa-arrows-rotate fa-lg"></i> Personnel Password Reset</h1>
                </div>
                <form method="POST" action="functions/passwordreset-personnel.php" class="needs-validation"> 
                    <div class="modal-body">
                        <div class="form-group was-validated">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control inputbox" type="email" id="email" name="email" placeholder="example@email.com" required>
                            <div class="invalid-feedback">Please enter valid email address...</div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary w-75 shadow" type="submit" id="password-reset" name="password-reset"><i class="fa-solid fa-arrows-rotate"></i> Reset</button>
                        <div class="container-fluid text-center">
                            <a class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#PersonnelLogIn" data-bs-whatever="@mdo"><i class="fa-solid fa-arrow-left fa-lg"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AdminPwdReset" tabindex="-1" aria-labelledby="AdminPwdReset" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-secondary text-light">
                    <h1 class="modal-title fs-5 " id="AdminPwdReset"><i class="fa-solid fa-arrows-rotate fa-lg"></i> Admin Password Reset</h1>
                </div>
                <form method="POST" action="functions/passwordreset-admin.php" class="needs-validation"> 
                    <div class="modal-body">
                        <div class="form-group was-validated">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control inputbox" type="email" id="email" name="email" placeholder="example@email.com" required>
                            <div class="invalid-feedback">Please enter valid email address...</div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary w-75 shadow" type="submit" id="password-reset" name="password-reset"><i class="fa-solid fa-arrows-rotate"></i> Reset</button>
                        <div class="container-fluid text-center">
                            <a class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#PersonnelLogIn" data-bs-whatever="@mdo"><i class="fa-solid fa-arrow-left fa-lg"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>