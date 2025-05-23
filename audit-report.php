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
    // for deleting client
    if (isset($_GET['id'])) {
        $clientid = $_GET['id'];
        $msg = mysqli_query($con, "DELETE FROM clients WHERE id='$clientid'");
        if ($msg) {
            echo "<script>alert('Data deleted');</script>";
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

    <title>Manage Invoices | Registration and Login System</title>
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
                    <h1 class="mt-4">Invoices and Payments</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Invoices & Payments</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Invoice & Payment Details
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client Name</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Issued By (User ID)</th>
                                        <th>Created At</th>
                                        <th>Payment Method</th>
                                        <th>Transaction Ref</th>
                                        <th>Paid Amount</th>
                                        <th>Paid At</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client Name</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Issued By (User ID)</th>
                                        <th>Created At</th>
                                        <th>Payment Method</th>
                                        <th>Transaction Ref</th>
                                        <th>Paid Amount</th>
                                        <th>Paid At</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                    $query = mysqli_query($con, "
                                        SELECT 
                                            invoices.id AS invoice_id,
                                            clients.name AS client_name,
                                            invoices.amount,
                                            invoices.due_date,
                                            invoices.status,
                                            invoices.issued_by,
                                            invoices.created_at,
                                            payments.method,
                                            payments.transaction_ref,
                                            payments.amount AS paid_amount,
                                            payments.paid_at
                                        FROM invoices
                                        LEFT JOIN clients ON invoices.client_id = clients.id
                                        LEFT JOIN payments ON payments.invoice_id = invoices.id
                                    ");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['invoice_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                        <td><?php echo $row['amount']; ?></td>
                                        <td><?php echo $row['due_date']; ?></td>
                                        <td><?php echo ucfirst($row['status']); ?></td>
                                        <td><?php echo $row['issued_by']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><?php echo $row['method'] ?? '-'; ?></td>
                                        <td><?php echo $row['transaction_ref'] ?? '-'; ?></td>
                                        <td><?php echo $row['paid_amount'] ?? '-'; ?></td>
                                        <td><?php echo $row['paid_at'] ?? '-'; ?></td>
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
