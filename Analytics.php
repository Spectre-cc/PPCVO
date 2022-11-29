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
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
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
                                AND
                                animals.regDate > DATE_SUB(NOW(),INTERVAL 1 YEAR)
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
                            const barangay01 =  <?php echo json_encode($barangay); ?>;
                            const regAnimals = <?php echo json_encode($regAnimals); ?>;

                            var backgroundcolor = [];
                            var bordercolor = [];

                            for (let i = 0; i< regAnimals.length; i++) {
                                let r = Math.floor(Math.random() * 255);
                                let g = Math.floor(Math.random() * 255);
                                let b = Math.floor(Math.random() * 255);
                                backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                bordercolor.push('rgb('+r+','+g+','+b+')');
                            }

                            const data01 = {
                                labels: barangay01,
                                datasets: [
                                    {
                                        label: 'Number of Registered Animals',
                                        data: regAnimals,
                                        backgroundColor: backgroundcolor,
                                        borderColor: bordercolor,
                                        borderWidth: 1
                                    }
                                ]
                            };

                            const config01 = {
                                type: 'bar',
                                data: data01,
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
                                config01
                            );
                        </script>
                    </div>
                    <div class="container-fluid d-flex justify-content-center align-items-center shadow rounded-5 my-3 p-3">
                        <div class="container me-1 w-50">
                            <div class="container-fluid  border-bottom border-danger">
                                <h3>Cat Population</h3>
                            </div>
                            <div class="w-100" style="height: 40vh">
                                <canvas id="CatPopulation" ></canvas>
                            </div>
                            <?php 
                                $query = "
                                SELECT
                                    barangays.brgy_name,
                                    COUNT(Cats.animalID) as 'NumberOfCats'
                                FROM
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals Cats
                                                            ON clients.clientID = Cats.clientID
                                                                INNER JOIN classifications CatClass
                                                                    ON Cats.classificationID = CatClass.classificationID
                                WHERE
                                    CatClass.species LIKE  '%feline%'
                                GROUP BY
                                    barangays.brgy_name
                                ";
                                $result = mysqli_query($conn, $query);

                                if(mysqli_num_rows($result) > 0){
                                    $barangay = array();
                                    $NumberOfCats = array();

                                    foreach ($result as $data):
                                        $barangay[] = $data['brgy_name'];
                                        $NumberOfCats[] = $data['NumberOfCats'];
                                    endforeach;
                                }else{
                                    echo "No records matching your query were found.";
                                }
                            ?>
                            <script>
                                const barangay02 =  <?php echo json_encode($barangay); ?>;
                                const NumberOfCats = <?php echo json_encode($NumberOfCats); ?>;

                                var backgroundcolor = [];
                                var bordercolor = [];

                                for (let i = 0; i< NumberOfCats.length; i++) {
                                    let r = Math.floor(Math.random() * 255);
                                    let g = Math.floor(Math.random() * 255);
                                    let b = Math.floor(Math.random() * 255);
                                    backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                    bordercolor.push('rgb('+r+','+g+','+b+')');
                                }

                                const data02 = {
                                    labels: barangay02,
                                    datasets: [
                                        {
                                            label: 'Number of Cats',
                                            data: NumberOfCats,
                                            backgroundColor: backgroundcolor,
                                            borderColor: bordercolor,
                                            hoverOffset: 4
                                        }
                                    ]
                                };

                                const config02 = {
                                    type: 'pie',
                                    data: data02,
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false
                                    }
                                };

                                const CatPopulation = new Chart(
                                    document.getElementById('CatPopulation'),
                                    config02
                                );
                            </script>
                        </div>
                        <div class="container w-50">
                            <div class="container-fluid  border-bottom border-danger">
                                <h3>Dog Population</h3>
                            </div>
                            <div class="w-100" style="height: 40vh">
                                <canvas id="DogPopulation" ></canvas>
                            </div>
                            <?php 
                                $query = "
                                SELECT
                                    barangays.brgy_name,
                                    COUNT(Dogs.animalID) as 'NumberOfDogs'
                                FROM
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals Dogs
                                                            ON clients.clientID = Dogs.clientID
                                                                INNER JOIN classifications DogClass
                                                                    ON Dogs.classificationID = DogClass.classificationID
                                WHERE
                                    DogClass.species LIKE  '%canine%'
                                GROUP BY
                                    barangays.brgy_name
                                ";
                                $result = mysqli_query($conn, $query);

                                if(mysqli_num_rows($result) > 0){
                                    $barangay = array();
                                    $NumberOfDogs = array();

                                    foreach ($result as $data):
                                        $barangay[] = $data['brgy_name'];
                                        $NumberOfDogs[] = $data['NumberOfDogs'];
                                    endforeach;
                                }else{
                                    echo "No records matching your query were found.";
                                }
                            ?>
                            <script>
                                const barangay03 =  <?php echo json_encode($barangay); ?>;
                                const NumberOfDogs = <?php echo json_encode($NumberOfDogs); ?>;

                                var backgroundcolor = [];
                                var bordercolor = [];

                                for (let i = 0; i< NumberOfCats.length; i++) {
                                    let r = Math.floor(Math.random() * 255);
                                    let g = Math.floor(Math.random() * 255);
                                    let b = Math.floor(Math.random() * 255);
                                    backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                    bordercolor.push('rgb('+r+','+g+','+b+')');
                                }

                                const data03 = {
                                    labels: barangay03,
                                    datasets: [
                                        {
                                            label: 'Number of Dogs',
                                            data: NumberOfDogs,
                                            backgroundColor: backgroundcolor,
                                            borderColor: bordercolor,
                                            hoverOffset: 4
                                        }
                                    ]
                                };

                                const config03 = {
                                    type: 'pie',
                                    data: data03,
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false
                                    }
                                };

                                const DogPopulation = new Chart(
                                    document.getElementById('DogPopulation'),
                                    config03
                                );
                            </script>
                        </div>
                    </div>
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <div class="container-fluid  border-bottom border-danger">
                            <h3>Number of Vaccinated Animals</h3>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="VaccinatedAnimals" ></canvas>
                        </div>
                        <?php 
                            $query = "
                            SELECT
                                barangays.brgy_name,
                                COUNT(animals.animalID) as 'NumberOfVaccinatedAnimals'
                            FROM
                                clients
                                    INNER JOIN clients_addresses
                                        ON clients.addressID = clients_addresses.addressID
                                            INNER JOIN barangays
                                                ON clients_addresses.barangayID = barangays.barangayID
                                                    INNER JOIN animals
                                                        ON clients.clientID = animals.clientID
                                                            INNER JOIN walk_in_transactions
                                                                ON animals.animalID = walk_in_transactions.animalID
                            WHERE
                                walk_in_transactions.ctID = 2   
                                AND
                                walk_in_transactions.disease LIKE  '%rabies%'
                                AND
                                walk_in_transactions.date > DATE_SUB(NOW(),INTERVAL 1 YEAR)
                            GROUP BY
                                barangays.brgy_name 
                            ";
                            $result = mysqli_query($conn, $query);

                            if(mysqli_num_rows($result) > 0){
                                $barangay = array();
                                $vaccAnimal = array();

                                foreach ($result as $data):
                                    $barangay[] = $data['brgy_name'];
                                    $VaccinatedAnimals[] = $data['NumberOfVaccinatedAnimals'];
                                endforeach;
                            }else{
                                echo "No records matching your query were found.";
                            }
                        ?>
                        <script>
                            const barangay04 =  <?php echo json_encode($barangay); ?>;
                            const VaccinatedAnimals = <?php echo json_encode($VaccinatedAnimals); ?>;

                            var backgroundcolor = [];
                            var bordercolor = [];

                            for (let i = 0; i< VaccinatedAnimals.length; i++) {
                                let r = Math.floor(Math.random() * 255);
                                let g = Math.floor(Math.random() * 255);
                                let b = Math.floor(Math.random() * 255);
                                backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                bordercolor.push('rgb('+r+','+g+','+b+')');
                            }

                            const data04 = {
                                labels: barangay04,
                                datasets: [
                                    {
                                        label: 'Number of Vaccinated Animals',
                                        data: VaccinatedAnimals,
                                        backgroundColor: backgroundcolor,
                                        borderColor: bordercolor,
                                        borderWidth: 1
                                    }
                                ]
                            };

                            const config04 = {
                                type: 'bar',
                                data: data04,
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

                            const NumberOfVaccinatedAnimals = new Chart(
                                document.getElementById('VaccinatedAnimals'),
                                config04
                            );
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
