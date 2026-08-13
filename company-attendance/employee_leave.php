<?php
session_start();
include("db.php");

if (!isset($_SESSION['email']) || empty($_SESSION['employee_id'])) {
    header("Location: login.html");
    exit();
}

if (isset($_POST['submit'])) {
    $employee_id = $_SESSION['employee_id'];
    $leave_type = $_POST['leave_type'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $reason = $_POST['reason'];

    $sql = "INSERT INTO leave_requests (employee_id, leave_type, from_date, to_date, reason, status) VALUES ('$employee_id', '$leave_type', '$from_date', '$to_date', '$reason', 'Pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Leave request submitted successfully');</script>";
    } else {
        echo "<script>alert('Error submitting leave request');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employee Leave</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #1f2937; }
        .container { width: 90%; max-width: 900px; margin: 40px auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 6px 18px rgba(0,0,0,0.05); }
        input, select, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #cbd5e1; border-radius: 6px; }
        button { background: #2563eb; color: white; border: none; padding: 12px; width: 100%; cursor: pointer; border-radius: 6px; }
        .top { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #2563eb; color: white; padding: 10px; }
        td { border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: center; }
        .approved { color: #16a34a; font-weight: bold; }
        .rejected { color: #dc2626; font-weight: bold; }
        .pending { color: #f59e0b; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="top">
            <h2>Employee Leave Request</h2>
            <p>Welcome, <?php echo $_SESSION['employee_name']; ?></p>
        </div>

        <form method="POST">
            <label>Leave Type</label>
            <select name="leave_type" required>
                <option>Casual Leave</option>
                <option>Sick Leave</option>
                <option>Paid Leave</option>
                <option>Emergency Leave</option>
            </select>

            <label>From Date</label>
            <input type="date" name="from_date" required>

            <label>To Date</label>
            <input type="date" name="to_date" required>

            <label>Reason</label>
            <textarea name="reason" rows="4" required></textarea>

            <button type="submit" name="submit">Submit Leave Request</button>
        </form>

        <h3>Your Leave Requests</h3>
        <table>
            <tr>
                <th>Leave Type</th>
                <th>From</th>
                <th>To</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
            <?php
            $employee_id = $_SESSION['employee_id'];
            $history_sql = "SELECT * FROM leave_requests WHERE employee_id='$employee_id' ORDER BY leave_id DESC";
            $history_result = mysqli_query($conn, $history_sql);
            while ($history_row = mysqli_fetch_assoc($history_result)) {
                $status_class = strtolower($history_row['status']);
            ?>
                <tr>
                    <td><?php echo $history_row['leave_type']; ?></td>
                    <td><?php echo $history_row['from_date']; ?></td>
                    <td><?php echo $history_row['to_date']; ?></td>
                    <td><?php echo $history_row['reason']; ?></td>
                    <td class="<?php echo $status_class; ?>"><?php echo $history_row['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
