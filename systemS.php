<?php 
session_start();

require 'includes/connect.php';

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (strlen($_SESSION['adminid']) == 0) {
    header('location:logout.php');
} else {
    // for deleting user
    if (isset($_GET['id'])) {
        $userid = $_GET['id'];
        $msg = mysqli_query($con, "DELETE FROM users WHERE id='$userid'");
        if ($msg) {
            echo "<script>alert('User deleted');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="derrick koome kagemdo" />

    <style>
        #datatablesSimple {
            width: 100%;
            border-collapse: collapse;
        }

        #datatablesSimple th,
        #datatablesSimple td {
            text-align: center;
            padding: 12px;
            border: 1px solid #ddd;
        }

        #datatablesSimple th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        #datatablesSimple tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #datatablesSimple tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>

    <title>Manage Users | Registration and Login System</title>
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Manage Users</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Users</li>
                    </ol>

                    <div class="mb-3">
                        <a href="adduser" class="btn btn-primary">Add</a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            User Details
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                    $ret = mysqli_query($con, "SELECT * FROM users");
                                    while ($row = mysqli_fetch_array($ret)) { ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['role']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><?php echo $row['updated_at']; ?></td>
                                        <td>
                                            <a href="user-profile?uid=<?php echo $row['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="clients.php?id=<?php echo $row['id']; ?>" onClick="return confirm('Do you really want to delete');">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script> 
</body>
</html>
<?php } ?>
