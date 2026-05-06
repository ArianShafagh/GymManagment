<?php
ob_start();
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}
include '../../../config/db.php';

// Fetch all users with health conditions
$users_res = $conn->query("
    SELECT u.*, h.medical_notes, h.health_status 
    FROM users u 
    LEFT JOIN health_conditions h ON u.id = h.user_id 
    ORDER BY u.id DESC
");
$users = $users_res->fetchAll(PDO::FETCH_ASSOC);

// Fetch all tickets
$tickets_res = $conn->query("
    SELECT t.*, u.first_name, u.last_name, u.email 
    FROM tickets t 
    JOIN users u ON t.user_id = u.id 
    ORDER BY t.created_at DESC
");

// Fetch gym entries
$entries_res = $conn->query("
    SELECT g.*, u.first_name, u.last_name, u.email 
    FROM gym_entries g 
    JOIN users u ON g.user_id = u.id 
    ORDER BY g.scan_time DESC 
    LIMIT 100
");
$tickets = $tickets_res->fetchAll(PDO::FETCH_ASSOC);
$entries = $entries_res->fetchAll(PDO::FETCH_ASSOC);

// Stats
$total_users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch(PDO::FETCH_ASSOC)['c'];
$total_entries_today = $conn->query("SELECT COUNT(*) as c FROM gym_entries WHERE DATE(scan_time) = CURDATE()")->fetch(PDO::FETCH_ASSOC)['c'];
$open_tickets = $conn->query("SELECT COUNT(*) as c FROM tickets WHERE status='Open'")->fetch(PDO::FETCH_ASSOC)['c'];

// Handle ticket view (if ?ticket_id is set)
$viewing_ticket = null;
$ticket_messages = [];
if (isset($_GET['ticket_id'])) {
    $tid = intval($_GET['ticket_id']);
    $vt = $conn->prepare("SELECT t.*, u.first_name, u.last_name, u.email FROM tickets t JOIN users u ON t.user_id = u.id WHERE t.id = ? LIMIT 1");
    $vt->execute([$tid]);
    $viewing_ticket = $vt->fetch(PDO::FETCH_ASSOC);
    if ($viewing_ticket) {
        $msg_stmt = $conn->prepare("SELECT * FROM ticket_messages WHERE ticket_id = ? ORDER BY created_at ASC");
        $msg_stmt->execute([$tid]);
        $ticket_messages = $msg_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Handle user edit view
$editing_user = null;
if (isset($_GET['edit_user'])) {
    $uid = intval($_GET['edit_user']);
    $eu = $conn->prepare("SELECT u.*, h.medical_notes, h.health_status FROM users u LEFT JOIN health_conditions h ON u.id = h.user_id WHERE u.id = ? LIMIT 1");
    $eu->execute([$uid]);
    $editing_user = $eu->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bull Gym</title>
    <link rel="title icon" href="../../assets/download.png">
    <link rel="stylesheet" href="../../bootstrap/bootstrap.min.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=BBH+Bartle&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin/dashboard.css">
</head>
<body>
    <!-- ADMIN NAVBAR -->
    <nav class="navbar navbar-expand-lg admin-nav px-4 py-2">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <img src="../../assets/download.png" alt="logo" style="width: 40px; height: 40px;" class="me-2">
            ADMIN PANEL
        </a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-muted me-3" style="font-size: 13px;"><i class='bx bx-user'></i> <?php echo $_SESSION['admin_user']; ?></span>
            <a href="../../pages/admin/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        <!-- STATS ROW -->
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $total_users; ?></h3>
                    <p>Total Members</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $total_entries_today; ?></h3>
                    <p>Gym Entries Today</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $open_tickets; ?></h3>
                    <p>Open Tickets</p>
                </div>
            </div>
        </div>

        <!-- TAB BUTTONS -->
        <div class="d-flex gap-2 mb-4 flex-wrap">
            <button class="tab-btn active" onclick="showTab('members')"><i class='bx bx-group'></i> Members</button>
            <button class="tab-btn" onclick="showTab('email')"><i class='bx bx-envelope'></i> Send Email</button>
            <button class="tab-btn" onclick="showTab('tickets')"><i class='bx bx-support'></i> Tickets</button>
            <button class="tab-btn" onclick="showTab('entries')"><i class='bx bx-log-in'></i> Gym Entries</button>
        </div>

        <!-- ===================== MEMBERS TAB ===================== -->
        <div id="tab-members" class="admin-tab">
            <?php if ($editing_user): ?>
                <!-- EDIT USER FORM -->
                <div class="admin-card mb-4">
                    <h5 style="color: #dc3545; font-family: 'Anton';">Edit Member: <?php echo htmlspecialchars($editing_user['first_name'] . ' ' . $editing_user['last_name']); ?></h5>
                    <form action="../../actions/admin/admin_update_user.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $editing_user['id']; ?>">
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="text-muted" style="font-size:12px;">Email (read-only)</label>
                                <input type="text" class="form-control form-control-dark" value="<?php echo htmlspecialchars($editing_user['email']); ?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted" style="font-size:12px;">Subscription</label>
                                <select name="subscription_type" class="form-control form-control-dark">
                                    <option value="Pro+" <?php echo $editing_user['subscription_type']=='Premium'?'selected':''; ?>>Pro+</option>
                                    <option value="Classic" <?php echo $editing_user['subscription_type']=='VIP'?'selected':''; ?>>Classic</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted" style="font-size:12px;">Duration (months)</label>
                                <input type="number" name="duration_months" class="form-control form-control-dark" value="<?php echo $editing_user['duration_months']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted" style="font-size:12px;">Start Date</label>
                                <input type="date" name="start_date" class="form-control form-control-dark" value="<?php echo $editing_user['start_date']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted" style="font-size:12px;">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-dark" value="<?php echo $editing_user['end_date']; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted" style="font-size:12px;">Payment Method</label>
                                <input type="text" name="payment_method" class="form-control form-control-dark" value="<?php echo htmlspecialchars($editing_user['payment_method']); ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted" style="font-size:12px;">2FA Method</label>
                                <select name="two_fa_method" class="form-control form-control-dark">
                                    <option value="none" <?php echo $editing_user['two_fa_method']=='none'?'selected':''; ?>>None</option>
                                    <option value="email" <?php echo $editing_user['two_fa_method']=='email'?'selected':''; ?>>Email</option>
                                    <option value="google_auth" <?php echo $editing_user['two_fa_method']=='google_auth'?'selected':''; ?>>Google Auth</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted" style="font-size:12px;">Health Status</label>
                                <select name="health_status" class="form-control form-control-dark">
                                    <option value="healthy" <?php echo ($editing_user['health_status'] ?? 'healthy')=='healthy'?'selected':''; ?>>OK — Healthy</option>
                                    <option value="attention" <?php echo ($editing_user['health_status'] ?? '')=='attention'?'selected':''; ?>>Attention Needed</option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <label class="text-muted" style="font-size:12px;">Medical Notes</label>
                                <textarea name="medical_notes" class="form-control form-control-dark" rows="2"><?php echo htmlspecialchars($editing_user['medical_notes'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-danger btn-sm">Save Changes</button>
                            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm ms-2">Cancel</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <div class="admin-table">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subscription</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>2FA</th>
                            <th>Health</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><span class="badge"><?php echo $u['subscription_type']; ?></span></td>
                            <td><?php echo $u['start_date']; ?></td>
                            <td><?php echo $u['end_date']; ?></td>
                            <td><?php echo $u['two_fa_method'] ?: 'none'; ?></td>
                            <td><?php 
                                $hs = $u['health_status'] ?? 'healthy';
                                if ($hs === 'attention') {
                                    echo '<span class="badge bg-warning text-dark" title="'.htmlspecialchars($u['medical_notes'] ?? '').'"><i class="bx bx-error"></i> Attention</span>';
                                } else {
                                    echo '<span class="badge bg-success"><i class="bx bx-check"></i> OK</span>';
                                }
                            ?></td>
                            <td>
                                <a href="dashboard.php?edit_user=<?php echo $u['id']; ?>" class="btn btn-outline-warning btn-sm py-0 px-2"><i class='bx bx-edit'></i></a>
                                <a href="../../actions/admin/admin_delete_user.php?id=<?php echo $u['id']; ?>" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="return confirm('Delete this user?');"><i class='bx bx-trash'></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===================== EMAIL TAB ===================== -->
        <div id="tab-email" class="admin-tab" style="display:none;">
            <div class="admin-card" style="max-width: 600px;">
                <h5 style="color: #dc3545; font-family: 'Anton';">Send Email to Member</h5>
                <form action="../../actions/admin/admin_send_email.php" method="POST">
                    <div class="mb-3">
                        <label class="text-muted" style="font-size:12px;">Select Member</label>
                        <select name="to_email" class="form-control form-control-dark" required>
                            <option value="">-- Choose a member --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?php echo htmlspecialchars($u['email']); ?>"><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name'] . ' (' . $u['email'] . ')'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted" style="font-size:12px;">Subject</label>
                        <input type="text" name="subject" class="form-control form-control-dark" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted" style="font-size:12px;">Message</label>
                        <textarea name="message" class="form-control form-control-dark" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Send Email</button>
                </form>
            </div>
        </div>

        <!-- ===================== TICKETS TAB ===================== -->
        <div id="tab-tickets" class="admin-tab" style="display:none;">
            <?php if ($viewing_ticket): ?>
                <!-- TICKET DETAIL VIEW -->
                <div class="admin-card mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 style="color: #dc3545; font-family: 'Anton'; margin:0;">
                            Ticket #<?php echo $viewing_ticket['id']; ?>: <?php echo htmlspecialchars($viewing_ticket['subject']); ?>
                        </h5>
                        <div>
                            <form action="../../actions/admin/admin_update_ticket.php" method="POST" class="d-inline">
                                <input type="hidden" name="ticket_id" value="<?php echo $viewing_ticket['id']; ?>">
                                <select name="status" class="form-control-dark d-inline-block" style="width:auto; padding:4px 8px; font-size:12px; border-radius:4px;" onchange="this.form.submit()">
                                    <option value="Open" <?php echo $viewing_ticket['status']=='Open'?'selected':''; ?>>Open</option>
                                    <option value="In Progress" <?php echo $viewing_ticket['status']=='In Progress'?'selected':''; ?>>In Progress</option>
                                    <option value="Closed" <?php echo $viewing_ticket['status']=='Closed'?'selected':''; ?>>Closed</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <p class="" style="font-size:13px;">
                        From: <?php echo htmlspecialchars($viewing_ticket['first_name'] . ' ' . $viewing_ticket['last_name'] . ' (' . $viewing_ticket['email'] . ')'); ?>
                        | Created: <?php echo $viewing_ticket['created_at']; ?>
                    </p>

                    <!-- Messages -->
                    <div style="max-height: 400px; overflow-y: auto; padding: 10px;">
                        <?php foreach ($ticket_messages as $msg): ?>
                            <div class="<?php echo $msg['sender_type'] === 'Admin' ? 'msg-admin' : 'msg-user'; ?>">
                                <small class="text-muted"><?php echo $msg['sender_type']; ?> — <?php echo $msg['created_at']; ?></small>
                                <p class="mb-0 mt-1"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($ticket_messages)): ?>
                            <p class="text-muted text-center">No messages yet.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Reply form -->
                    <form action="../../actions/admin/admin_reply_ticket.php" method="POST" class="mt-3">
                        <input type="hidden" name="ticket_id" value="<?php echo $viewing_ticket['id']; ?>">
                        <textarea name="message" class="form-control form-control-dark mb-2" rows="3" placeholder="Type your reply..." required></textarea>
                        <button type="submit" class="btn btn-danger btn-sm">Send Reply</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary btn-sm ms-2" onclick="showTab('tickets'); return false;">Back to Tickets</a>
                    </form>
                </div>
            <?php endif; ?>

            <div class="admin-table">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $t): 
                            $badge = 'badge-open';
                            if ($t['status'] === 'Closed') $badge = 'badge-closed';
                            elseif ($t['status'] === 'In Progress') $badge = 'badge-progress';
                        ?>
                        <tr>
                            <td><?php echo $t['id']; ?></td>
                            <td><?php echo htmlspecialchars($t['first_name'] . ' ' . $t['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($t['subject']); ?></td>
                            <td><span class="badge <?php echo $badge; ?>"><?php echo $t['status']; ?></span></td>
                            <td><?php echo $t['created_at']; ?></td>
                            <td><a href="dashboard.php?ticket_id=<?php echo $t['id']; ?>" class="btn btn-outline-info btn-sm py-0 px-2"><i class='bx bx-show'></i> View</a></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($tickets)): ?>
                        <tr><td colspan="8" class="text-center text-muted">No tickets found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===================== GYM ENTRIES TAB ===================== -->
        <div id="tab-entries" class="admin-tab" style="display:none;">
            <div class="admin-table">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Email</th>
                            <th>Scan Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entries as $e): ?>
                        <tr>
                            <td><?php echo $e['id']; ?></td>
                            <td><?php echo htmlspecialchars($e['first_name'] . ' ' . $e['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($e['email']); ?></td>
                            <td><?php echo $e['scan_time']; ?></td>
                            <td>
                                <span class="badge <?php echo $e['scan_result']==='Allowed' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $e['scan_result']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($entries)): ?>
                        <tr><td colspan="5" class="text-center text-muted">No gym entries recorded yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../../bootstrap/jquery-3.6.0.min.js"></script>
    <script src="../../bootstrap/bootstrap.min.js"></script>
    <script>
        function showTab(tab) {
            document.querySelectorAll('.admin-tab').forEach(t => t.style.display = 'none');
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById('tab-' + tab).style.display = 'block';
            event.target.closest('.tab-btn').classList.add('active');
        }

        // Auto-show tickets tab if viewing a ticket
        <?php if ($viewing_ticket): ?>
            document.addEventListener('DOMContentLoaded', function() {
                showTicketsTab();
            });
            function showTicketsTab() {
                document.querySelectorAll('.admin-tab').forEach(t => t.style.display = 'none');
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.getElementById('tab-tickets').style.display = 'block';
                document.querySelectorAll('.tab-btn')[2].classList.add('active');
            }
        <?php endif; ?>

        // Auto-show members tab if editing a user
        <?php if ($editing_user): ?>
            document.addEventListener('DOMContentLoaded', function() {
                // Already on members tab by default
            });
        <?php endif; ?>
    </script>
</body>
</html>
