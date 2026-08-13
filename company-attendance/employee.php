<?php
session_start();
include("db.php");

if (!isset($_SESSION['email']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employees</title>
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
        input, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #cbd5e1; border-radius: 6px; }
        button { width: 100%; background: #2563eb; color: white; padding: 12px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1d4ed8; }
        .action-link { display: inline-block; padding: 6px 10px; margin: 2px; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .action-link.edit { background: #dbeafe; color: #1d4ed8; }
        .action-link.delete { background: #fee2e2; color: #b91c1c; }
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
            <a href="employee.php" class="active">👨 Employees</a>
            <a href="leave.php">📝 Leave Requests</a>
            <a href="report.php">📊 Reports</a>
            <a href="logout.php">🔓 Logout</a>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h1>Employee Management</h1>
            </div>

            <div class="box">
                <h3>Add Employee</h3>
                <form action="employee_add.php" method="POST">
                    <label>Employee Code</label>
                    <input type="text" name="employee_code" required>

                    <label>Employee Name</label>
                    <input type="text" name="employee_name" required>

                    <label>Department</label>
                    <select name="department">
                        <option>HR</option>
                        <option>IT</option>
                        <option>Finance</option>
                        <option>Marketing</option>
                        <option>Sales</option>
                    </select>

                    <label>Phone</label>
                    <input type="text" name="phone" required>

                    <label>Email</label>
                    <input type="email" name="email" required>

                    <label>Joining Date</label>
                    <input type="date" name="joining_date" required>

                    <label>Password</label>
                    <input type="password" name="password" required>

                    <button type="submit">Add Employee</button>
                </form>
            </div>

            <div class="box" style="margin-top:20px;">
                <h3>Employee List</h3>
                <table style="width:100%; border-collapse:collapse; margin-top:10px;">
                    <tr>
                        <th style="background:#2563eb; color:white; padding:10px;">Code</th>
                        <th style="background:#2563eb; color:white; padding:10px;">Name</th>
                        <th style="background:#2563eb; color:white; padding:10px;">Department</th>
                        <th style="background:#2563eb; color:white; padding:10px;">Phone</th>
                        <th style="background:#2563eb; color:white; padding:10px;">Email</th>
                        <th style="background:#2563eb; color:white; padding:10px;">Actions</th>
                    </tr>
                    <?php
                    $emp_query = mysqli_query($conn, "SELECT * FROM employees ORDER BY employee_id DESC");
                    while ($emp = mysqli_fetch_assoc($emp_query)) {
                    ?>
                    <tr>
                        <td style="padding:10px; border-bottom:1px solid #e5e7eb; text-align:center;"><?php echo $emp['employee_code']; ?></td>
                        <td style="padding:10px; border-bottom:1px solid #e5e7eb; text-align:center;"><?php echo $emp['employee_name']; ?></td>
                        <td style="padding:10px; border-bottom:1px solid #e5e7eb; text-align:center;"><?php echo $emp['department']; ?></td>
                        <td style="padding:10px; border-bottom:1px solid #e5e7eb; text-align:center;"><?php echo $emp['phone']; ?></td>
                        <td style="padding:10px; border-bottom:1px solid #e5e7eb; text-align:center;"><?php echo $emp['email']; ?></td>
                        <td style="padding:10px; border-bottom:1px solid #e5e7eb; text-align:center;">
                            <a href="employee_edit.php?id=<?php echo $emp['employee_id']; ?>" class="action-link edit">Edit</a>
                            <a href="employee_delete.php?id=<?php echo $emp['employee_id']; ?>" onclick="return confirm('Delete this employee?')" class="action-link delete">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </main>
    </div>
</body>
</html>