<?php
session_start();
include("db.php");

if (!isset($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$message = '';

if (isset($_POST['approve_leave']) || isset($_POST['reject_leave'])) {
    $leave_id = mysqli_real_escape_string($conn, $_POST['leave_id']);
    $status = isset($_POST['approve_leave']) ? 'Approved' : 'Rejected';

    mysqli_query($conn, "UPDATE leave_requests SET status='$status' WHERE leave_id='$leave_id'");
    $_SESSION['leave_message'] = "Leave request $status successfully.";
    header("Location: leave.php");
    exit();
}

if (isset($_SESSION['leave_message'])) {
    $message = $_SESSION['leave_message'];
    unset($_SESSION['leave_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Leave Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #1e3a8a; color: white; padding: 24px 20px; }
        .sidebar h2 { margin-bottom: 6px; font-size: 24px; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 12px 14px; margin-bottom: 8px; border-radius: 8px; }
        .sidebar a:hover, .sidebar a.active { background: #2563eb; }
        .main-content { flex: 1; padding: 25px; }
        .topbar { background: white; padding: 18px 22px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); margin-top: 20px; }
        input, select, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #cbd5e1; border-radius: 6px; }
        button { background: #2563eb; color: white; border: none; padding: 12px; width: 100%; cursor: pointer; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #2563eb; color: white; padding: 10px; }
        td { border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: center; }
        .action-btn { padding: 6px 10px; border: none; border-radius: 6px; cursor: pointer; color: white; margin: 2px; }
        .approve { background: #16a34a; }
        .reject { background: #dc2626; }
        .message { padding: 10px 12px; margin-bottom: 12px; background: #ecfdf3; color: #166534; border: 1px solid #86efac; border-radius: 8px; }
        @media (max-width: 900px) { .admin-layout { flex-direction: column; } .sidebar { width: 100%; } }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2>ABC Company</h2>
            <p>Admin Panel</p>
            <a href="dashboard.php">🏠 Dashboard</a>
            <a href="attendance.php">📅 Attendance</a>
            <a href="employee.php">👨 Employees</a>
            <a href="leave.php" class="active">📝 Leave Requests</a>
            <a href="report.php">📊 Reports</a>
            <a href="logout.php">🔓 Logout</a>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h1>Leave Requests</h1>
            </div>

            <div class="box">
                <?php if (!empty($message)) { ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php } ?>
                <h3>Leave Requests List</h3>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $sql = "SELECT leave_requests.*, employees.employee_name FROM leave_requests INNER JOIN employees ON leave_requests.employee_id=employees.employee_id ORDER BY leave_id DESC";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['leave_id']; ?></td>
                            <td><?php echo $row['employee_name']; ?></td>
                            <td><?php echo $row['leave_type']; ?></td>
                            <td><?php echo $row['from_date']; ?></td>
                            <td><?php echo $row['to_date']; ?></td>
                            <td><?php echo $row['reason']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="leave_id" value="<?php echo $row['leave_id']; ?>">
                                    <button type="submit" name="approve_leave" class="action-btn approve">Approve</button>
                                    <button type="submit" name="reject_leave" class="action-btn reject">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </main>
    </div>
</body>
</html>