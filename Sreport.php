<?php
session_start();

ini_set("include_path", '/home/whnefewm/public_html/php.ini' . ini_get("include_path"));

require 'includes/connect.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if (strlen($_SESSION['adminid'] == 0)) {
    header('location:logout.php');
} else { }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manage Financial Reports | Admin Panel</title>
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
                   <h1 class="mt-4">Issue Reports</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Reports</li>
</ol>

<div class="form">
    <h2>View Issue Reports</h2>
    <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th><strong>S.No</strong></th>
                <th><strong>Technician</strong></th>
                <th><strong>Issue ID</strong></th>
                <th><strong>Details</strong></th>
                <th><strong>Images</strong></th>
                <th><strong>Date</strong></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sel_query = "
                SELECT 
                    reports.id,
                    reports.issue_id,
                    reports.details,
                    reports.images,
                    reports.created_at,
                    users.name AS technician_name
                FROM 
                    reports
                JOIN 
                    issues ON reports.issue_id = issues.id
                JOIN 
                    users ON issues.assigned_to = users.id
                ORDER BY 
                    reports.id DESC;
            ";
            $result = mysqli_query($con, $sel_query);
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td align="center"><?php echo $count; ?></td>
                    <td align="center"><?php echo htmlspecialchars($row["technician_name"]); ?></td>
                    <td align="center"><?php echo $row["issue_id"]; ?></td>
                    <td align="center"><?php echo nl2br(htmlspecialchars($row["details"])); ?></td>
                    <td align="center"><?php echo htmlspecialchars($row["images"]); ?></td>
                    <td align="center"><?php echo $row["created_at"]; ?></td>
                </tr>
            <?php $count++;
            } ?>
        </tbody>
    </table>
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
