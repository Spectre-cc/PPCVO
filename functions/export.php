<?php
    if(isset($_POST['client-list'])){
        require('./config/config.php');
        require('./config/db.php');
        $query="
        SELECT 
            * 
        FROM 
            clients
                INNER JOIN
                    clients_addresses
                        ON clients.addressID = clients_addresses.addressID
                            INNER JOIN barangays
                                ON clients_addresses.barangayID = barangays.barangayID
                        
        ";
        $result = mysqli_query($conn,$query);
?>
        <table data-cols-width="13,13,13,13,13,30,13,13,15" id="tableExport">
            <tr>
                <th colspan="9" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Client List</th>
            </tr>
            <tr>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">First Name</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Middle Name</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Last Name</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Birthdate</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Sex</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Address</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Barangay</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Contact No.</th>
                <th data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Email</th>
            </tr>
            <?php foreach ($result as $data): ?>
                <tr>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['fName']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['mName']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['lName']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['birthdate']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['sex']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['Specific_add']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['brgy_name']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['cNumber']; ?></td>
                    <td data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
<?php    
        echo '
            <script type="text/javascript" src="html2excel/tableToExcel.js"></script>';
        echo "
            <script>
            TableToExcel.convert(document.getElementById('tableExport'), {
                name: 'client-list.xlsx',
                sheet: {
                name: 'Client List'
                }
            });
            </script>
        ";
        
        header('Location: ../View-Client-List.php');
        exit();
    } 
?>