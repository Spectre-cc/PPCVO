<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/checksession-admin.php'); ?>
<?php include('functions/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="container-fluid">
                    <div class="containter-fluid d-flex justify-content-center align-items-center m-3">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="containter-fluid justify-content-start align-items-start m-2">
                        <div class="container-fluid  border-bottom border-danger">
                            <h3>Number of Registered Animals</h3>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="ChartRegisteredAnimals" ></canvas>
                        </div>
                        <?php 
                            $query = "
                            SELECT 
                                barangays.brgy_name,
                                COUNT(animals.animalID) as 'regAnimals'
                            FROM
                                clients,
                                clients_addresses,
                                barangays,
                                animals
                            WHERE
                                clients.addressID = clients_addresses.addressID
                                AND
                                clients_addresses.barangayID = barangays.barangayID
                                AND
                                clients.clientID = animals.clientID
                                AND
                                animals.regNumber IS NOT NULL
                            GROUP BY
                                barangays.brgy_name
                            ";
                            $result = mysqli_query($conn, $query);

                            if(mysqli_num_rows($result) > 0){
                                $barangay = array();
                                $regAnimals = array();

                                foreach ($result as $data):
                                    $barangay[] = $data['brgy_name'];
                                    $regAnimals[] = $data['regAnimals'];
                                endforeach;
                            }else{
                                echo "No records matching your query were found.";
                            }
                        ?>
                        <script>
                            const barangay =  <?php echo json_encode($barangay); ?>;
                            const regAnimals = <?php echo json_encode($regAnimals); ?>;

                            let backgroundcolor = [];
                            let bordercolor = [];

                            for (let i = 0; i< barangay.length; i++) {
                                let r = Math.floor(Math.random() * 255);
                                let g = Math.floor(Math.random() * 255);
                                let b = Math.floor(Math.random() * 255);
                                backgroundcolor.push('rgba('+r+','+g+','+b+',0.2)');
                                bordercolor.push('rgb('+r+','+g+','+b+')');
                            }

                            const data1 = {
                                labels: barangay,
                                datasets: [{
                                    label: 'Number of Registered Animals',
                                    data: regAnimals,
                                    backgroundColor: backgroundcolor,
                                    borderColor: bordercolor,
                                    borderWidth: 1
                                }]
                            };

                            const config1 = {
                                type: 'bar',
                                data: data1,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    }
                                }
                            };

                            const regAnimalsPerBarangay = new Chart(
                                document.getElementById('ChartRegisteredAnimals'),
                                config1
                            );
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>