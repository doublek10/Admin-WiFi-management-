<?php
session_start();
require 'includes/connect.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (strlen($_SESSION['adminid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="derrick koome kagendo" />
        <title>Location | Registration and Login System</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include_once('includes/navbar.php'); ?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php'); ?>
            <div id="layoutSidenav_content">
                <main>
                        <!-- Areas and Clients Section -->
                        <h1 class="mt-4">Areas and Clients</h1>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Area Name</th>
                                            <th>Area Description</th>
                                            <th>Client Name(s)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $area_query = mysqli_query($con, "
                                            SELECT a.id AS area_id, a.name AS area_name, a.description, 
                                                   GROUP_CONCAT(c.name SEPARATOR ', ') AS client_names
                                            FROM areas a
                                            LEFT JOIN clients c ON a.id = c.area_id
                                            GROUP BY a.id
                                        ");
                                        while ($area = mysqli_fetch_array($area_query)) {
                                            $clients = $area['client_names'] ? $area['client_names'] : 'No clients';
                                            echo "<tr>
                                                    <td>{$area['area_name']}</td>
                                                    <td>{$area['description']}</td>
                                                    <td>{$clients}</td>
                                                  </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </main>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>
