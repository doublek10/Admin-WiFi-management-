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

    <title>Manage Users | Registration and Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

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

        .form-container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .form-control, .form-select {
            border-radius: 6px;
            padding: 10px;
        }

        .btn-success {
            padding: 10px 20px;
            font-weight: bold;
        }
    </style>
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

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $name = mysqli_real_escape_string($con, $_POST['name']);
                        $email = mysqli_real_escape_string($con, $_POST['email']);
                        $phone = mysqli_real_escape_string($con, $_POST['phone']);
                        $role = mysqli_real_escape_string($con, $_POST['role']);
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                        $insert = mysqli_query($con, "INSERT INTO users(name, email, phone, role, password) VALUES('$name', '$email', '$phone', '$role', '$password')");

                        if ($insert) {
                            echo "<div class='alert alert-success'>User added successfully.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
                        }
                    }
                    ?>

                    <div class="form-container mb-4">
                        <h4>Add New User</h4>
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" required />
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" required />
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" class="form-select" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="accounting">Accounting</option>
                                        <option value="callcenter">Call Center</option>
                                        <option value="response">Response</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required />
                            </div>

                            <button type="submit" class="btn btn-success">Add User</button>
                        </form>
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
