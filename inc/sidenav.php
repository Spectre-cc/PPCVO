            <!-- Sidebar -->
            <div class="sidenav container-fluid text-center rounded-4 col-2 pt-4 px-0 me-2">
                <div class="container text-center px-2 ">
                    <img class="sidebar-logo img-fluid" src="inc\style\assets\images\PPCVIO-Logo-wht.png" alt="" >
                </div>
                <div class="container list-group text-center px-2 ">
                    <a href="View-User-Account.php" class="btn btn-outline-light border-0 rounded-pill p-0 mt-3" style="text-decoration: none;"><i class="fa-solid fa-user"></i> Good day, <?php echo $_SESSION['fName']?></a>
                    <hr class="horizontal-rule p-0 mb-3">
                    <a href="View-Client-List.php" class="btn btn-outline-light mb-2 rounded-pill shadow"><i class="fa-solid fa-address-book"></i> Clients</a>
                    <a href="Send-Email.php" class="btn btn-outline-light  mb-2 rounded-pill shadow"><i class="fa-solid fa-envelope"></i> Send Announcement</a>
                    <div class="dropdown">
                        <button class="btn btn-outline-light my-1 w-100 dropdown-toggle rounded-pill shadow text-wrap" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-file-arrow-down"></i> Export
                        </button>
                        <ul class="text-center dropdown-menu w-100 rounded">
                            <li><a class="dropdown-item rounded-pill" href="Export-Client-List.php"><i class="fa-solid fa-list"></i> Client List</a></li>
                            <li><a href="Export-BAI-Reports.php" class="dropdown-item rounded-pill"><i class="fa-solid fa-file-excel"></i> Monthly Reports</a></li>
                        </ul>
                    </div>
                    <hr class="horizontal-rule p-0 my-3">
                    <a href="functions/logout.php" class="btn btn-outline-light rounded-pill"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
                </div>
            </div>
            <!-- Sidebar -->