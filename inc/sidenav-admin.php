            <!-- Sidebar -->
            <div class="sidenav container-fluid text-center rounded-4 col-2 pt-4 px-0 me-2">
                <div class="container text-center px-2">
                    <img class="sidebar-logo img-fluid" src="inc\style\assets\images\PPCVIO-Logo-wht.png" alt="" >
                </div>
                <div class="container list-group text-center px-2">
                <hr class="horizontal-rule p-0 my-3">
                    <a href="Analytics.php" class="btn btn-light bg-transparent text-white my-1"><i class="fa-solid fa-chart-line"></i> Analytics</a>
                    <div class="dropdown">
                        <button class="btn btn-light bg-transparent text-white my-1 w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-users"></i> Users
                        </button>
                        <ul class="text-center dropdown-menu">
                            <li><a class="dropdown-item" href="View-Users.php?type=personnel"><i class="fa-solid fa-person"></i> Personnel</a></li>
                            <li><a class="dropdown-item" href="View-Users.php?type=admin"><i class="fa-solid fa-user-tie"></i> Admin</a></li>
                        </ul>
                    </div>
                    <a href="View-Veterinarian.php" class="btn btn-light bg-transparent text-white my-1"><i class="fa-solid fa-user-doctor"></i> Veterinarians</a>
                    <hr class="horizontal-rule p-0 my-3">
                    <a href="functions/logout.php" class="btn btn-light bg-transparent text-white my-1"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
                </div>
            </div>
            <!-- Sidebar -->