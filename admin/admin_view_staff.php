<?php
session_start();
include "../config/db.php";

// ONLY ADMIN ACCESS
if(!isset($_SESSION['uid']) || $_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit;
}

// Handle deactivation
if (isset($_GET['deactivate'])) {
    $uid = intval($_GET['deactivate']);

    mysqli_query($conn, "UPDATE users SET status='inactive' WHERE UID=$uid");
    mysqli_query($conn, "UPDATE pharmacist SET status='inactive' WHERE PHID=$uid");
    mysqli_query($conn, "UPDATE pathologist SET status='inactive' WHERE PATH_ID=$uid");
    mysqli_query($conn, "UPDATE delivery_agent SET status='inactive' WHERE AGENT_ID=$uid");

    header("Location: admin_view_staff.php?msg=deactivated");
    exit;
}

// Handle activation
if (isset($_GET['activate'])) {
    $uid = intval($_GET['activate']);

    mysqli_query($conn, "UPDATE users SET status='active' WHERE UID=$uid");
    mysqli_query($conn, "UPDATE pharmacist SET status='active' WHERE PHID=$uid");
    mysqli_query($conn, "UPDATE pathologist SET status='active' WHERE PATH_ID=$uid");
    mysqli_query($conn, "UPDATE delivery_agent SET status='active' WHERE AGENT_ID=$uid");

    header("Location: admin_view_staff.php?msg=activated");
    exit;
}

// Fetch all staff except admins
$query = "
SELECT UID, name, email, phone, role, status 
FROM users 
WHERE role IN ('pharmacist', 'pathologist', 'delivery_agent')
ORDER BY role, name
";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Staff</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<h2>Staff Management</h2>
<hr>

<?php if(isset($_GET['msg'])) { ?>
    <div class="alert alert-success">
        <?= ($_GET['msg'] == "deactivated") ? "Staff Deactivated." : "Staff Activated." ?>
    </div>
<?php } ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>UID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['UID']; ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['email']); ?></td>
            <td><?= ucfirst($row['role']); ?></td>

            <td>
                <?php if($row['status'] == "active"){ ?>
                    <span class="badge bg-success">Active</span>
                <?php } else { ?>
                    <span class="badge bg-secondary">Inactive</span>
                <?php } ?>
            </td>

            <td>
                <?php if($row['status'] == "active"){ ?>
                    <a href="?deactivate=<?= $row['UID']; ?>" 
                       class="btn btn-warning btn-sm"
                       onclick="return confirm('Deactivate this staff member?');">
                        Deactivate
                    </a>
                <?php } else { ?>
                    <a href="?activate=<?= $row['UID']; ?>" 
                       class="btn btn-success btn-sm"
                       onclick="return confirm('Activate this staff member?');">
                        Activate
                    </a>
                <?php } ?>
            </td>

        </tr>
        <?php } ?>
    </tbody>
</table>

<a href="admin_dashboard.php" class="btn btn-secondary mt-3">Back To Dashboard</a>

</body>
</html>
