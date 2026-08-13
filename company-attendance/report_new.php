<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$date = "";

if (isset($_POST['search'])) {
    $date = $_POST['attendance_date'];
    $sql = "SELECT attendance.*, employees.employee_name, employees.employee_code FROM attendance INNER JOIN employees ON attendance.employee_id = employees.employee_id WHERE attendance.attendance_date='$date' ORDER BY attendance.attendance_id DESC";
} else {
    $sql = "SELECT attendance.*, employees.employee_name, employees.employee_code FROM attendance INNER JOIN employees ON attendance.employee_id = employees.employee_id ORDER BY attendance.attendance_id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
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
        .box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); }
        .search-bar { display: flex; gap: 10px; align-items: center; margin-bottom: 15px; }
        input { padding: 10px; width: 250px; border: 1px solid #cbd5e1; border-radius: 6px; }
        button { background: #2563eb; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 6px; }
        .print-btn { background: #16a34a; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #2563eb; color: white; padding: 10px; }
        td { border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: center; }
        .present { color: #16a34a; font-weight: bold; }
        .absent { color: #dc2626; font-weight: bold; }
        .leave { color: #f59e0b; font-weight: bold; }
        .weekoff { color: #2563eb; font-weight: bold; }
        .holiday { color: #7c3aed; font-weight: bold; }
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
            <a href="leave.php">📝 Leave Requests</a>
            <a href="report.php" class="active">📊 Reports</a>
            <a href="logout.php">🔓 Logout</a>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h1>Attendance Report</h1>
            </div>

            <div class="box">
                <form method="POST" class="search-bar">
                    <label>Select Date</label>
                    <input type="date" name="attendance_date" value="<?php echo $date; ?>">
                    <button type="submit" name="search">Search</button>
                    <button type="button" class="print-btn" onclick="window.print()">Print</button>
                </form>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Employee Code</th>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $statusClass = "";
                            if ($row['status'] == "Present") $statusClass = "present";
                            if ($row['status'] == "Absent") $statusClass = "absent";
                            if ($row['status'] == "Leave") $statusClass = "leave";
                            if ($row['status'] == "Weekly Off") $statusClass = "weekoff";
                            if ($row['status'] == "Holiday") $statusClass = "holiday";
                    ?>
                        <tr>
                            <td><?php echo $row['attendance_id']; ?></td>
                            <td><?php echo $row['employee_code']; ?></td>
                            <td><?php echo $row['employee_name']; ?></td>
                            <td><?php echo $row['attendance_date']; ?></td>
                            <td class="<?php echo $statusClass; ?>"><?php echo $row['status']; ?></td>
                        </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="5">No Attendance Records Found</td>
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
