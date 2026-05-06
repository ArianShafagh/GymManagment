<?php
session_start();
include '../../config/db.php';
if(!isset($_SESSION['user_email'])) {
    header("Location: Login.php");
    exit();
}
$email = $_SESSION['user_email'];
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_id = $user['id'];

// Fetch health conditions
$hstmt = $conn->prepare("SELECT * FROM health_conditions WHERE user_id = ? LIMIT 1");
$hstmt->execute([$user_id]);
$health = $hstmt->fetch(PDO::FETCH_ASSOC);

// Fetch entries
$est = $conn->prepare("SELECT COUNT(*) as count FROM gym_entries WHERE user_id = ?");
$est->execute([$user_id]);
$entries = $est->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="title icon" href="../assets/download.png">
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/main.css">

    <!-- BOX ICONS -->
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/3.0.4/fonts/animations.min.css' rel='stylesheet'>
    
    
    
    <!-- LINKING THE FONT  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=BBH+Bartle&display=swap" rel="stylesheet"> 
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-black p-2 border-bottom border-danger pb-3">
            <!-- Logo -->
            <a class="navbar-brand d-flex flex-row align-items-end me-lg-5 ms-lg-5 me-sm-5 ms-sm-5" href="home.php">
                <img src="../assets/download.png" alt="logo">
                <p class="bbh-bartle-regular text-danger fst-italic">Dashboard</p>
            </a>
            <button class="navbar-toggler position-static me-lg-5 ms-lg-5 me-sm-5 ms-sm-5" type="button" data-toggle="collapse" id="DashboardNavToggle" data-target="#DashboardNav" aria-controls="DashboardNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-around" id="DashboardNav">
                        <ul class="navbar-nav d-flex flex-lg-row flex-md-column mt-3 ">
                <li class="nav-item justify-content-center me-lg-5 mb-md-2">
                    <a href="home.php" class="anton-regular btn btn-outline-danger border-0 fs-3">Home</a>
                </li>
                <li class="nav-item me-lg-5 mb-md-2">
                    <a href="About.html" class="anton-regular btn btn-outline-danger border-0 fs-3">About</a>
                </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section class="d-flex justify-content-center align-items-center" style="height: 80vh;">
            <div class="container-fluid">
                <div class="monitor d-flex flex-row">
                    <div class="listOfOptions p-4 w-25 align-items-start">
                        <h2 class="anton-regular text-center mb-4">Account Settings</h2>
                        <ul class="list-group" id="dashboardTabs">
                            <li class="list-group-item active" style="cursor: pointer;" onclick="showSection('profile', this)">Profile & Account</li>
                            <li class="list-group-item" style="cursor: pointer;" onclick="showSection('security', this)">Privacy & Security</li>
                            <li class="list-group-item" style="cursor: pointer;" onclick="showSection('entrance', this)">Gym Entrance (QR)</li>
                            <li class="list-group-item" style="cursor: pointer;" onclick="showSection('support', this)">Support & Tickets</li>
                            <li class="list-group-item"><a href="Logout.php" class="text-danger text-decoration-none">Logout</a></li>
                        </ul>
                    </div>
                    <!-- Content Panels -->
                    <div class="contentArea p-4 w-75 bg-white text-dark rounded-3 ms-4" style="overflow-y: auto; max-height: 70vh;">
                        
                        <!-- PROFILE SECTION -->
                        <div id="section-profile" class="dashboard-section">
                            <h2 class="anton-regular mb-4">Profile & Account Management</h2>
                            <form action="../actions/update_profile.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Email (Read-only)</label>
                                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Subscription Plan (Read-only)</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['subscription_type']); ?>" readonly>
                                    <small class="text-muted">for changes, please contact support.</small>
                                </div>
                                <div class="mb-3">
                                    <input type="checkbox" name="health_prob" id="health_prob" <?php echo ($health && $health['medical_notes']) ? 'checked' : ''; ?>>
                                    <label for="health_prob">I have health conditions</label>
                                </div>
                                <div class="mb-3" id="medical_notes" style="display: none;">
                                    <label>Medical Notes (Allergies, injuries)</label>
                                    <textarea class="form-control" name="medical_notes"><?php echo isset($health['medical_notes']) ? htmlspecialchars($health['medical_notes']) : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Current Payment Method</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['payment_method']); ?>" readonly>
                                    <small class="text-muted">Simulated payment details from signup.</small>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Save Profile changes</button>
                            </form>
                        </div>

                        <!-- SECURITY SECTION -->
                        <div id="section-security" class="dashboard-section" style="display: none;">
                            <h2 class="anton-regular mb-4">Privacy & Security</h2>
                            <form action="../actions/update_security.php" method="POST">
                                <h4>Change Password</h4>
                                <div class="mb-3">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" name="new_password">
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Update Password</button>
                            </form>

                            <hr class="my-4">

                            <h4>Two-Step Verification</h4>
                            <p class="text-muted">Add an extra layer of security to your account.</p>

                            <form action="../actions/setup_2fa.php" method="POST">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="two_fa_method" value="none" id="2fa_none" <?php echo ($user['two_fa_method'] === 'none' || !$user['two_fa_method']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="2fa_none">
                                        <strong>Disabled</strong> — No two-step verification
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="two_fa_method" value="email" id="2fa_email" <?php echo ($user['two_fa_method'] === 'email') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="2fa_email">
                                        <i class='bx bx-envelope' style="color:#dc3545;"></i>
                                        <strong>Email Verification</strong> — A 6-digit code will be sent to your email on every login
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="two_fa_method" value="google_auth" id="2fa_google" <?php echo ($user['two_fa_method'] === 'google_auth') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="2fa_google">
                                        <i class='bx bx-shield-quarter' style="color:#dc3545;"></i>
                                        <strong>Google Authenticator</strong> — Use the Google/Microsoft Authenticator app
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-danger mt-2">Save 2FA Settings</button>
                            </form>

                            <?php if ($user['two_fa_method'] === 'google_auth' && $user['totp_secret']): ?>
                            <?php include '../../config/totp.php'; ?>
                            <div class="mt-4 p-3 border rounded bg-light">
                                <h5>Google Authenticator Setup</h5>
                                <p class="text-muted mb-2">Scan this QR code with Google Authenticator or Microsoft Authenticator:</p>
                                <div class="text-center">
                                    <img src="<?php echo TOTP::getQRCodeUrl($user['email'], $user['totp_secret']); ?>" alt="QR Code" class="img-fluid border rounded p-1">
                                </div>
                                <p class="text-center mt-2"><small>Secret key: <code><?php echo $user['totp_secret']; ?></code></small></p>
                            </div>
                            <?php endif; ?>
                            <h4 class="mt-5">Login History</h4>
                            <div style="max-height: 250px; overflow-y: auto;" class="border rounded bg-light">
                                <table class="table table-striped mb-0">
                                    <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                                        <tr>
                                            <th>Time</th>
                                            <th>IP Address</th>
                                            <th>Device</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $log_stmt = $conn->prepare("SELECT * FROM login_history WHERE user_id = ? ORDER BY attempt_time DESC");
                                        $log_stmt->execute([$user_id]);
                                        $logs = $log_stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if (count($logs) > 0) {
                                            foreach ($logs as $log) {
                                                echo "<tr><td>{$log['attempt_time']}</td><td>{$log['ip_address']}</td><td>{$log['device_info']}</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>No login history found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ENTRANCE SECTION -->
                        <div id="section-entrance" class="dashboard-section" style="display: none;">
                            <h2 class="anton-regular mb-4">Gym Entrance System</h2>
                            <div class="text-center mt-4">
                                <h4>Your Entrance QR Code</h4>
                                <p class="text-muted">Scan this code at the turnstile to enter.</p>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=USER_<?php echo $user_id; ?>_<?php echo time(); ?>" alt="QR Code" class="img-fluid border p-2 rounded">
                                <p class="mt-3">Status: <strong class="text-success">Active</strong></p>
                            </div>
                            <h4 class="mt-5">Your Stats</h4>
                            <p>Total Visits Recorded: <strong><?php echo $entries['count']; ?></strong></p>
                        </div>

                        <!-- SUPPORT SECTION -->
                        <div id="section-support" class="dashboard-section" style="display: none;">
                            <h2 class="anton-regular mb-4">Support & Tickets</h2>
                            <?php if(isset($_GET['view_ticket'])): 
                                $tid = intval($_GET['view_ticket']);
                                $vt = $conn->prepare("SELECT * FROM tickets WHERE id = ? AND user_id = ? LIMIT 1");
                                $vt->execute([$tid, $user_id]);
                                $viewing_ticket = $vt->fetch(PDO::FETCH_ASSOC);
                                if($viewing_ticket):
                                    $msg_stmt = $conn->prepare("SELECT * FROM ticket_messages WHERE ticket_id = ? ORDER BY created_at ASC");
                                    $msg_stmt->execute([$tid]);
                                    $msg_res = $msg_stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                                <div class="mb-3">
                                    <a href="Account.php" class="btn btn-outline-secondary btn-sm">← Back to Tickets</a>
                                </div>
                                <h4>Ticket #<?php echo $viewing_ticket['id']; ?>: <?php echo htmlspecialchars($viewing_ticket['subject']); ?></h4>
                                <p>Status: <span class="badge <?php echo $viewing_ticket['status'] === 'Closed' ? 'bg-success' : 'bg-warning text-dark'; ?>"><?php echo $viewing_ticket['status']; ?></span></p>

                                <div style="max-height: 400px; overflow-y: auto; margin-bottom: 20px;">
                                    <?php foreach($msg_res as $m): ?>
                                        <div style="margin-bottom: 15px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                                            <strong><?php echo $m['sender_type']; ?>:</strong>
                                            <p style="margin: 5px 0;"><?php echo nl2br(htmlspecialchars($m['message'])); ?></p>
                                            <small style="color: gray;"><?php echo $m['created_at']; ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <?php if($viewing_ticket['status'] !== 'Closed'): ?>
                                <form action="../actions/reply_ticket.php" method="POST">
                                    <input type="hidden" name="ticket_id" value="<?php echo $viewing_ticket['id']; ?>">
                                    <div class="mb-3">
                                        <textarea class="form-control" name="message" rows="3" placeholder="Type your reply..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Send Reply</button>
                                </form>
                                <?php else: ?>
                                <div class="alert alert-info">This ticket is closed. If you need further assistance, please open a new ticket.</div>
                                <?php endif; ?>
                                
                            <?php else: echo "<p>Ticket not found.</p><a href='Account.php' class='btn btn-outline-secondary'>Back</a>"; endif; ?>
                            <?php else: ?>
                            <button class="btn btn-outline-danger mb-4" onclick="document.getElementById('newTicketForm').style.display='block'">+ Create New Ticket</button>
                            
                            <form id="newTicketForm" action="../actions/create_ticket.php" method="POST" style="display: none;" class="mb-4 p-3 border rounded">
                                <h4>Submit a Ticket</h4>
                                <div class="mb-3">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" name="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label>Message</label>
                                    <textarea class="form-control" name="message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Ticket</button>
                            </form>

                            <h4>Your Tickets</h4>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ticket_stmt = $conn->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC");
                                    $ticket_stmt->execute([$user_id]);
                                    $tickets = $ticket_stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if (count($tickets) > 0) {
                                        foreach ($tickets as $ticket) {
                                            echo "<tr>
                                            <td>#{$ticket['id']}</td>
                                            <td>" . htmlspecialchars($ticket['subject']) . "</td>
                                            <td>{$ticket['status']}</td>
                                            <td>{$ticket['created_at']}</td>
                                            <td><a href='?view_ticket={$ticket['id']}' class='btn btn-sm btn-info text-white'>View</a></td>
                                        </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>You have no tickets.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </section>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../js/Account.js"></script>
</body>
</html>