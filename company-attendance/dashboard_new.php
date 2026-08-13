<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$today = date("Y-m-d");

$total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees");
$total = mysqli_fetch_assoc($total_query)['total'];

$present_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM attendance WHERE attendance_date='$today' AND status='Present'");
$present = mysqli_fetch_assoc($present_query)['total'];

$absent_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM attendance WHERE attendance_date='$today' AND status='Absent'");
$absent = mysqli_fetch_assoc($absent_query)['total'];

$leave_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM attendance WHERE attendance_date='$today' AND status='Leave'");
$leave = mysqli_fetch_assoc($leave_query)['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: #1e3a8a; color: white; padding: 24px 20px; }
        .sidebar h2 { margin-bottom: 6px; font-size: 24px; }
        .sidebar p { color: #bfdbfe; margin-bottom: 24px; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 12px 14px; margin-bottom: 8px; border-radius: 8px; }
        .sidebar a:hover, .sidebar a.active { background: #2563eb; }
        .main-content { flex: 1; padding: 25px; }
        .topbar { background: white; padding: 18px 22px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .cards { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 20px; }
        .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); }
        .card h3 { color: #64748b; margin-bottom: 8px; }
        .number { font-size: 28px; font-weight: bold; }
        .blue { color: #2563eb; }
        .green { color: #16a34a; }
        .red { color: #dc2626; }
        .orange { color: #f59e0b; }
        .box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #2563eb; color: white; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: center; }
        .present { color: #16a34a; font-weight: bold; }
        .absent { color: #dc2626; font-weight: bold; }
        .leave { color: #f59e0b; font-weight: bold; }
        @media (max-width: 900px) { .admin-layout { flex-direction: column; } .sidebar { width: 100%; } .cards { grid-template-columns: 1fr 1fr; } }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2>ABC Company</h2>
            <p>Admin Panel</p>
            <a href="dashboard.php" class="active">🏠 Dashboard</a>
            <a href="attendance.php">📅 Attendance</a>
            <a href="employee.php">👨 Employees</a>
            <a href="leave.php">📝 Leave Requests</a>
            <a href="report.php">📊 Reports</a>
            <a href="logout.php">🔓 Logout</a>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <div>
                    <h1>Admin Dashboard</h1>
                    <p>Manage attendance, employees, leave requests, and reports.</p>
                </div>
                <div><?php echo date("d M Y"); ?></div>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>Total Employees</h3>
                    <div class="number blue"><?php echo $total; ?></div>
                </div>
                <div class="card">
                    <h3>Present Today</h3>
                    <div class="number green"><?php echo $present; ?></div>
                </div>
                <div class="card">
                    <h3>Absent Today</h3>
                    <div class="number red"><?php echo $absent; ?></div>
                </div>
                <div class="card">
                    <h3>Leave Today</h3>
                    <div class="number orange"><?php echo $leave; ?></div>
                </div>
            </div>

            <div class="box">
                <h2>Today's Attendance</h2>
                <table>
                    <tr>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $sql = "SELECT attendance.*, employees.employee_name, employees.department FROM attendance INNER JOIN employees ON attendance.employee_id = employees.employee_id WHERE attendance.attendance_date='$today'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['employee_name']; ?></td>
                            <td><?php echo $row['department']; ?></td>
                            <td><?php echo $row['attendance_date']; ?></td>
                            <td class="<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></td>
                        </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="4">No Attendance Marked Today</td>
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
