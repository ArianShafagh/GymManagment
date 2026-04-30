<?php
session_start();
include '../../config/db.php';
if(!isset($_SESSION['user_email'])) {
    header("Location: Login.php");
    exit();
}
$email = $_SESSION['user_email'];
$user_res = $conn->query("SELECT * FROM users WHERE email='$email'");
$user = $user_res->fetch_assoc();
$user_id = $user['id'];

// Fetch health conditions
$health_res = $conn->query("SELECT * FROM health_conditions WHERE user_id='$user_id'");
$health = $health_res->fetch_assoc();

// Fetch entries
$entries_res = $conn->query("SELECT COUNT(*) as count FROM gym_entries WHERE user_id='$user_id'");
$entries = $entries_res->fetch_assoc();
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
            <a class="navbar-brand d-flex flex-row align-items-end me-lg-5 ms-lg-5 me-sm-5 ms-sm-5" href="home.html">
                <img src="../assets/download.png" alt="logo">
                <p class="bbh-bartle-regular text-danger fst-italic">Dashboard</p>
            </a>
            <button class="navbar-toggler position-static me-lg-5 ms-lg-5 me-sm-5 ms-sm-5" type="button" data-toggle="collapse" data-target="#DashboardNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-around" id="DashboardNav">
                <ul class="navbar-nav d-flex flex-lg-row flex-md-column mt-3 ">
                <li class="nav-item justify-content-center me-lg-5 mb-md-2">
                    <a href="Home.html" class="anton-regular btn btn-outline-danger border-0 fs-3">Home</a>
                </li>
                <li class="nav-item me-lg-5 mb-md-2">
                    <a href="About.html" class="anton-regular btn btn-outline-danger border-0 fs-3">About</a>
                </li>
                <li class="nav-item me-lg-5 mb-md-2">
                    <a href="Contact.html" class="anton-regular btn btn-outline-danger border-0 fs-3">Contact</a>
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
                            <li class="list-group-item active" style="cursor: pointer;" onclick="showSection('profile')">Profile & Account</li>
                            <li class="list-group-item" style="cursor: pointer;" onclick="showSection('security')">Privacy & Security</li>
                            <li class="list-group-item" style="cursor: pointer;" onclick="showSection('entrance')">Gym Entrance (QR)</li>
                            <li class="list-group-item" style="cursor: pointer;" onclick="showSection('support')">Support & Tickets</li>
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
                                <h4 class="mt-4">Health Conditions</h4>
                                <div class="mb-3">
                                    <label>Medical Notes (Allergies, injuries)</label>
                                    <textarea class="form-control" name="medical_notes"><?php echo isset($health['medical_notes']) ? htmlspecialchars($health['medical_notes']) : ''; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Save Profile changes</button>
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
                                <h4 class="mt-4">Two-Factor Authentication</h4>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="enable_2fa" value="1" <?php echo ($user['two_fa_pin']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Enable 4-Digit Security PIN for Logins</label>
                                </div>
                                <div class="mb-3">
                                    <label>4-Digit PIN</label>
                                    <input type="text" class="form-control" name="two_fa_pin" maxlength="4" value="<?php echo htmlspecialchars($user['two_fa_pin'] ?? ''); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Update Security</button>
                            </form>
                            <h4 class="mt-5">Login History</h4>
                            <table class="table table-striped mt-3">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>IP Address</th>
                                        <th>Device</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $log_res = $conn->query("SELECT * FROM login_history WHERE user_id='$user_id' ORDER BY attempt_time DESC LIMIT 5");
                                    while($log = $log_res->fetch_assoc()) {
                                        echo "<tr><td>{$log['attempt_time']}</td><td>{$log['ip_address']}</td><td>{$log['device_info']}</td></tr>";
                                    }
                                    if($log_res->num_rows == 0) echo "<tr><td colspan='3'>No login history found.</td></tr>";
                                    ?>
                                </tbody>
                            </table>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ticket_res = $conn->query("SELECT * FROM tickets WHERE user_id='$user_id' ORDER BY created_at DESC");
                                    while($ticket = $ticket_res->fetch_assoc()) {
                                        echo "<tr>
                                            <td>#{$ticket['id']}</td>
                                            <td>{$ticket['subject']}</td>
                                            <td>{$ticket['status']}</td>
                                            <td>{$ticket['created_at']}</td>
                                        </tr>";
                                    }
                                    if($ticket_res->num_rows == 0) echo "<tr><td colspan='4'>You have no tickets.</td></tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                

                
                

            </div>
        </section>


    <script src="../bootstrap/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/bootstrap.min.js"></script>
    <script>
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.dashboard-section');
            sections.forEach(sec => sec.style.display = 'none');
            
            // Show requested section
            document.getElementById('section-' + sectionId).style.display = 'block';
            
            // Update active state in sidebar
            const tabs = document.querySelectorAll('#dashboardTabs .list-group-item');
            tabs.forEach(tab => tab.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>