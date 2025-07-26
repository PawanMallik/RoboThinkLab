<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.robothinklab.com/login.php");
    exit();
}

if (isset($_POST['update_remark'])) {
    $id = $_POST['submission_id'];
    $remark = $_POST['remark'];
    $stmt = $conn->prepare("UPDATE submissions SET remark = ? WHERE id = ?");
    $stmt->bind_param("si", $remark, $id);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --sidebar-width: 220px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            overflow-x: auto;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: #333;
            color: white;
            padding-top: 20px;
            position: fixed;
            height: 100vh;
            transition: transform 0.3s ease;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #444;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            flex-grow: 1;
            background-color: #f5f5f5;
            width: 100%;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        h2 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            overflow-x: auto;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #eaeaea;
        }

        button {
            background-color: #00AEEF;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        select {
            padding: 5px;
        }

        .menu-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 12px;
            z-index: 1000;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 999;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding-top: 60px;
            }

            .menu-toggle {
                display: block;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<button class="menu-toggle" onclick="toggleSidebar()">☰</button>

<div class="sidebar" id="sidebar">
    <h2>Admin Panel</h2>
    <a class="tab-btn active" data-tab="submissions">📄 Submissions</a>
    <a class="tab-btn" data-tab="approved">🟢 Approved</a>
    <a class="tab-btn" data-tab="rejected">🔴 Rejected</a>
    <a class="tab-btn" data-tab="queries">❓ Queries</a>
    <a href="logout.php">🔒 Logout</a>
</div>

<div class="main-content">

    <!-- Submissions -->
    <div id="submissions" class="section active">
        <h2>All Submissions</h2>
        <?php $result = $conn->query("SELECT * FROM submissions ORDER BY submitted_at DESC"); ?>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th>
                <th>School</th><th>Address</th><th>Message</th><th>Remark</th><th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="POST">
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                    <td><?= $row['gmail'] ?></td>
                    <td><?= $row['country_code'] . ' ' . $row['phone_number'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td><?= $row['school_name'] ?></td>
                    <td><?= $row['address1'] ?><br><?= $row['address2'] ?><br><?= $row['city'] ?>, <?= $row['state'] ?> - <?= $row['zip'] ?></td>
                    <td><?= nl2br($row['message']) ?></td>
                    <td>
                        <select name="remark">
                            <option value="Pending" <?= $row['remark'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Approved" <?= $row['remark'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="Rejected" <?= $row['remark'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="submission_id" value="<?= $row['id'] ?>">
                        <button type="submit" name="update_remark">Save</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Approved -->
    <div id="approved" class="section">
        <h2>Approved Requests</h2>
        <?php $approved = $conn->query("SELECT * FROM submissions WHERE remark = 'Approved' ORDER BY submitted_at DESC"); ?>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>School</th><th>Message</th>
            </tr>
            <?php while ($row = $approved->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                <td><?= $row['gmail'] ?></td>
                <td><?= $row['country_code'] . ' ' . $row['phone_number'] ?></td>
                <td><?= $row['school_name'] ?></td>
                <td><?= nl2br($row['message']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Rejected -->
    <div id="rejected" class="section">
        <h2>Rejected Requests</h2>
        <?php $rejected = $conn->query("SELECT * FROM submissions WHERE remark = 'Rejected' ORDER BY submitted_at DESC"); ?>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>School</th><th>Message</th>
            </tr>
            <?php while ($row = $rejected->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                <td><?= $row['gmail'] ?></td>
                <td><?= $row['country_code'] . ' ' . $row['phone_number'] ?></td>
                <td><?= $row['school_name'] ?></td>
                <td><?= nl2br($row['message']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Queries -->
    <div id="queries" class="section">
        <h2>Contact Queries</h2>
        <?php $qresult = $conn->query("SELECT * FROM queries ORDER BY submitted_at DESC"); ?>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Submitted At</th></tr>
            <?php while ($qrow = $qresult->fetch_assoc()): ?>
            <tr>
                <td><?= $qrow['id'] ?></td>
                <td><?= $qrow['name'] ?></td>
                <td><?= $qrow['email'] ?></td>
                <td><?= $qrow['submitted_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.dataset.tab).classList.add('active');

            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('active');
            }
        });
    });
</script>

</body>
</html>