<!--dasbod.php-->

<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tesmoderasi';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['finishTask'])) {
        $taskId = $_POST['taskId'];

        $updateSql = "UPDATE orders SET status = 'Finished' WHERE id = $taskId";
        if ($conn->query($updateSql) === TRUE) {
            $moveSql = "INSERT INTO finished_orders SELECT * FROM orders WHERE id = $taskId";
            if ($conn->query($moveSql) === TRUE) {
                $deleteSql = "DELETE FROM orders WHERE id = $taskId";
                if ($conn->query($deleteSql) !== TRUE) {
                    echo "Error deleting record: " . $conn->error;
                }
            } else {
                echo "Error moving record: " . $conn->error;
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>MODERASI PESANAN</title>
</head>

<body>
    <div class="container mt-5">
        <h1>Moderasi Pesanan</h1>

        <!-- Ongoing Tasks -->
        <h2>Ongoing Tasks</h2>
        <table class='table table-bordered table-striped mt-3 table-dark'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th width='28%'>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th width='15%'>Service</th>
                    <th>Package</th>
                    <th width='15%'>Date</th>
                    <th width='25%'>Note</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<form>";
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["service"] . "</td>";
                        echo "<td>" . $row["package"] . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row["date"])) . "</td>";
                        echo "<td>" . $row["note"] . "</td>";
                        echo "<td class='text-center status-cell' width='15%'>";

                        if ($row["status"] == "Finished") {
                            echo "<button type='button' class='btn btn-success'>Finished</button>";
                        } else {
                            echo "<button type='button' id='pendingButton{$row['id']}' class='btn btn-warning'>Pending</button>";
                        }

                        echo "</td>";
                        echo "</form>";
                        echo "<form method='POST' action='dasbod.php'>";
                        echo "<input type='hidden' name='taskId' value='{$row['id']}'>";
                        echo "<td class='text-center' width='15%'><button type='submit' name='finishTask' class='btn btn-danger btn-finish-task'>Finish Task</button></td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>No ongoing tasks found</p>";
                }

                $sqlFinished = "SELECT * FROM finished_orders";
                $resultFinished = $conn->query($sqlFinished);
                ?>

                <!-- Finished Tasks -->
                <h2>Finished Tasks</h2>
                  <table class='table table-bordered table-striped mt-3 table-dark'>
                        <thead>
                            <tr>
                              <th>ID</th>
                              <th width='28%'>Name</th>
                              <th>Phone Number</th>
                              <th>Email</th>
                              <th width='15%'>Service</th>
                              <th>Package</th>
                              <th width='15%'>Date</th>
                              <th width='25%'>Note</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                        </thead>
                        <tbody> 
                    <?php
                    if ($resultFinished->num_rows > 0) {
                    while ($rowFinished = $resultFinished->fetch_assoc()) {
                        echo "<form>";
                        echo "<tr>";
                        echo "<td>" . $rowFinished["id"] . "</td>";
                        echo "<td>" . $rowFinished["name"] . "</td>";
                        echo "<td>" . $rowFinished["phone"] . "</td>";
                        echo "<td>" . $rowFinished["email"] . "</td>";
                        echo "<td>" . $rowFinished["service"] . "</td>";
                        echo "<td>" . $rowFinished["package"] . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($rowFinished["date"])) . "</td>";
                        echo "<td>" . $rowFinished["note"] . "</td>";
                        echo "<td class='text-center status-cell' width='15%'>";
                        echo "<button type='button' class='btn btn-success'>Finished</button>";
                        echo "</td>";
                        echo "<td class='text-center' width='15%'>...</td>";
                        echo "</tr>";
                        echo "</form>";
                    }

                    echo "</tbody></table>";
                } else {
                    echo "<p>No finished tasks found</p>";
                }

                $conn->close();
                ?>

            </div>

            <!-- Bootstrap Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

            <!-- JavaScript for finishing tasks -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var finishButtons = document.querySelectorAll('.btn-finish-task');
                    finishButtons.forEach(function (button) {
                        button.addEventListener('click', function () {
                            var confirmation = confirm("Are you sure you want to finish this task?");
                            if (confirmation) {
                                this.style.display = 'none';
                            }
                        });
                    });
                });
            </script>
        </body>

        </html>
