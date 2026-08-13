<?php
session_start();
include("db.php");

if (!isset($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

if (isset($_POST['save'])) {
    $employee_id = $_POST['employee_id'];
    $attendance_date = $_POST['attendance_date'];
    $status = $_POST['status'];

    $check = mysqli_query($conn, "SELECT * FROM attendance WHERE employee_id='$employee_id' AND attendance_date='$attendance_date'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Attendance already marked for this employee today.');</script>";
    } else {
        $sql = "INSERT INTO attendance(employee_id,attendance_date,status) VALUES('$employee_id','$attendance_date','$status')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Attendance Saved Successfully');</script>";
        } else {
            echo "<script>alert('Error Saving Attendance');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Attendance Management</title>
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
        input, select { width: 100%; padding: 10px; margin-top: 8px; margin-bottom: 15px; border: 1px solid #cbd5e1; border-radius: 6px; }
        button { background: #2563eb; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #2563eb; color: white; padding: 10px; }
        td { border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: center; }
        @media (max-width: 900px) { .admin-layout { flex-direction: column; } .sidebar { width: 100%; } }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2>ABC Company</h2>
            <p>Admin Panel</p>
            <a href="dashboard.php">🏠 Dashboard</a>
            <a href="attendance.php" class="active">📅 Attendance</a>
            <a href="employee.php">👨 Employees</a>
            <a href="leave.php">📝 Leave Requests</a>
            <a href="report.php">📊 Reports</a>
            <a href="logout.php">🔓 Logout</a>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h1>Attendance Management</h1>
            </div>

            <div class="box">
                <h3>Mark Attendance</h3>
                <form method="POST">
                    <label>Employee</label>
                    <select name="employee_id" required>
                        <option value="">Select Employee</option>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM employees");
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['employee_id']; ?>">
                                <?php echo $row['employee_code'] . " - " . $row['employee_name']; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>

                    <label>Date</label>
                    <input type="date" name="attendance_date" value="<?php echo date('Y-m-d'); ?>" required>

                    <label>Status</label>
                    <select name="status">
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Leave">Leave</option>
                        <option value="Weekly Off">Weekly Off</option>
                        <option value="Holiday">Holiday</option>
                    </select>

                    <button type="submit" name="save">Save Attendance</button>
                </form>
            </div>

            <div class="box">
                <h3>Attendance Records</h3>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $sql = "SELECT attendance.*, employees.employee_name FROM attendance INNER JOIN employees ON attendance.employee_id=employees.employee_id ORDER BY attendance.attendance_id DESC";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['attendance_id']; ?></td>
                            <td><?php echo $row['employee_name']; ?></td>
                            <td><?php echo $row['attendance_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
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