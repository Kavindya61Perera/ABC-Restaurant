<?php
include("connection.php"); // Ensure this path is correct

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report_type = mysqli_real_escape_string($conn, $_POST['report-type']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start-date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end-date']);

    if ($report_type == 'delivery') {
        $sql = "SELECT * FROM reservation
                WHERE orderType = 'delivery' AND Receive_date >= '$start_date' AND Receive_date <= '$end_date'";
                $countSql = "SELECT COUNT(*) as totalCount FROM reservation
                     WHERE orderType = 'delivery' AND Receive_date >= '$start_date' AND Receive_date <= '$end_date'";
    } else if ($report_type == 'dinein') {
        $sql = "SELECT * FROM reservation
                WHERE orderType = 'dinein' AND Receive_date >= '$start_date' AND Receive_date <= '$end_date'";
                $countSql = "SELECT COUNT(*) as totalCount FROM reservation
                     WHERE orderType = 'dinein' AND Receive_date >= '$start_date' AND Receive_date <= '$end_date'";
    } else {
        die('Invalid report type');
    }

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    $reservations = $result->fetch_all(MYSQLI_ASSOC);
    
    $countResult = mysqli_query($conn, $countSql);
    if (!$countResult) {
        die('Error: ' . mysqli_error($conn));
    }

    $countRow = $countResult->fetch_assoc();
    $totalCount = $countRow['totalCount'];
    
    // Calculate total amount
    $totalAmount = 0;
    foreach ($reservations as $res) {
        $totalAmount += $res['Total_Price'] ?? 0; // Use null coalescing operator for safety
    }
} else {
    die('Invalid request method');
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reservation Report</title>
    <style>
        body {
            background: url('Image/bc2.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 2em;
            color: #ffffff;
        }
        h2 {
            font-size: 2em;
            color: #000000;
        }
        section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        tfoot {
            font-weight: bold;
            background-color: #f4f4f4;
        }
        .back-button {
            display: inline-block;
            background-color: rgb(136, 27, 87);
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: rgb(182, 48, 122);
        }
    </style>
</head>
<body>
    <header>
        <h1>Reservation Report</h1>
        <p>Report for reservation type: <?php echo htmlspecialchars($report_type ?? ''); ?></p>
    </header>

    <section>
        <h2>Report Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Order Type</th>
                    <th>Branch Type</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Number of Persons</th>
                    <th>Food Type</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reservations)): ?>
                    <?php foreach ($reservations as $res): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($res['Res_id'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['Cus_name'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['Receive_date'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['Receive_time'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['orderType'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['branchType'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['deliveryAddress'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['Tel_no'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['Number_person'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['foodType'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($res['Quantity'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="11">No reservations found for the specified criteria.</td></tr>
                <?php endif; ?>
            </tbody>
            <?php if (!empty($reservations)): ?>
                <tfoot>
                    <tr>
                        <td colspan="10"><strong>Total Amount:</strong></td>
                        <td><strong><?php echo number_format($totalAmount, 2); ?></strong></td>
                    </tr>
                </tfoot>
                <tfoot>
                    <tr>
                        <td colspan="10"><strong>Total Number of Reservations:</strong></td>
                        <td><strong><?php echo htmlspecialchars($totalCount ?? 0); ?></strong></td>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
        <button type="button" class="back-button" onclick="goToAdminPage('admin.php')"><i class="fa-solid fa-arrow-left"></i> 
        <span>Back</span>
    </button>
    </section>
</body>

<script type="text/javascript">
function goToAdminPage(page) {
      window.location.href = page;
  }
  </script>

</html>
