<?php
session_start();
require 'includes/connect.php';
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if (strlen($_SESSION['adminid']==0)) {
    header('location:logout.php');
} else{
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="derrick koome kagendo" />
        <title>User Profile | Registration and Login System</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include_once('includes/navbar.php');?>
        <div id="layoutSidenav">
            <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        
<?php 
$id = $_GET['uid'];
$query = mysqli_query($con, "SELECT * FROM clients WHERE id='$id'");
while($result = mysqli_fetch_array($query))
{?>
    <h1 class="mt-4"><?php echo $result['name'];?>'s Profile</h1>
    <div class="card mb-4">
        <div class="card-body">
            <a href="edit-profile.php?uid=<?php echo $result['id'];?>">Edit</a>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <td><?php echo $result['name'];?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo $result['phone'];?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $result['email'];?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo $result['address'];?></td>
                </tr>
                <tr>
                    <th>Area ID</th>
                    <td><?php echo $result['area_id'];?></td>
                </tr>
                <tr>
                    <th>Preferred Package ID</th>
                    <td><?php echo $result['preferred_package_id'];?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo $result['status'];?></td>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>

                    </div>
                </main>
                <?php include('includes/footer.php');?>
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
