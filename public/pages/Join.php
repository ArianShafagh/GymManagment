<?php
include '../../config/db.php';
include '../../config/Recaptcha_verify.php';

session_start();
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Retrieve form data
    $verifyResponse = isValid($_POST['g-recaptcha-response'] ?? null, 0.5, 'register');
    if ($verifyResponse === false) {
        $errors[] = "Please verify you are not a robot.";
    }
    $name = $_POST['name'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $email = $_POST['email'] ?? '';
    $raw_password = $_POST['password'] ?? '';
    $subscription = $_POST['subscription'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $payment_method = $_POST['paymentMethodes'] ?? '';
    $health_status = $_POST['health_status'] ?? 'healthy';
    $medical_notes = $_POST['medical_notes'] ?? '';

    // Validation

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }

    if (
        strlen($raw_password) < 8 ||
        !preg_match('/[A-Z]/', $raw_password) ||
        !preg_match('/[a-z]/', $raw_password) ||
        !preg_match('/[0-9]/', $raw_password)
    ) {
        $errors[] = "Password must be at least 8 characters and include upper, lower case and a number.";
    }


    // Email check ONLY if email is not empty
    if ($email) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Email is already registered.";
        }
    }

    if (empty($errors)) {
        $start_date = date('Y-m-d');
        if ($duration == '3' || $duration == '6') {
            $end_date = date('Y-m-d', strtotime("+$duration months"));
        } elseif ($duration == '12') {
            $end_date = date('Y-m-d', strtotime("+1 year"));
        }
        $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users 
        (first_name, last_name, date_of_birth, gender, email, password, subscription_type, duration_months, start_date, end_date, payment_method) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        try {
            $conn->beginTransaction();
            $stmt->execute([$name, $lastname, $dob, $gender, $email, $hashed_password, $subscription, $duration, $start_date, $end_date, $payment_method]);
            // Insert health condition
            $new_user_id = $conn->lastInsertId();
            $stmt2 = $conn->prepare("INSERT INTO health_conditions (user_id, health_status, medical_notes) VALUES (?,?,?)");
            $stmt2->execute([$new_user_id, $health_status, $medical_notes]);
            $conn->commit();

            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            echo "<script>alert('Registration successful! Welcome to Bull Gym!'); window.location.href='Account.php';</script>";
            exit();
        } catch (Exception $e) {
            $conn->rollBack();
            echo "<script>alert('Error during registration.');</script>";
        }
    } else {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('Registration failed:\\n$error_message');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join</title>
    <link rel="icon" type="image/png" href="../assets/download.png">
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
    <div class="pageLogin min-vh-100" style="background-image: url(../assets/gym/81814f5d-4384-42d2-820c-3f7c41d1f337.webp); background-size: cover; background-position: center;">
        <!-- logo -->
        <a href="Home.php">
            <section class="logo p-4">
                <img src="../assets/download.png" alt="Logo" class="img-fluid mx-auto d-block" style="width: 150px; height: 150px;">
            </section>
        </a>

        <!-- join page content -->
        <form id="joinForm" action="Join.php" method="POST">
            <section class="login">
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="row w-100">
                        <div class="col-12 col-md-6">
                            <div class="card rounded-5 p-2 w-100">
                                <h2 class="anton-regular text-center mb-4">Personal Information</h2>
                                    <div class="fullname mb-3">
                                        <label  class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your first name" required>
                                        <label  class="form-label" >Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your last name" required>
                                    </div>
                                    <div class="dateofbirth mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob" required>
                                    </div>
                                    <div class="gender mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="" selected disabled>Select your gender</option>
                                            <option value="male">Male</option>      
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="email mb-3">
                                        <label for="email" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="password mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                    </div>

                                    <!-- Health Condition Section -->
                                    <div class="health mb-3">
                                        <label class="form-label fw-bold">Health Condition</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="health_status" value="healthy" id="healthOk" checked onchange="document.getElementById('healthDetails').style.display='none';">
                                            <label class="form-check-label" for="healthOk">
                                                <span class="text-success">✓</span> I am healthy — no conditions
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="health_status" value="attention" id="healthAttention" onchange="document.getElementById('healthDetails').style.display='block';">
                                            <label class="form-check-label" for="healthAttention">
                                                <span class="text-warning">⚠</span> I need specific attention
                                            </label>
                                        </div>
                                        <div id="healthDetails" class="mt-2" style="display: none;">
                                            <textarea class="form-control" name="medical_notes" rows="2" placeholder="Please describe your condition (e.g. asthma, heart condition, injuries...)"></textarea>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card col-6 rounded-5 p-2 w-100">
                                <h2 class="anton-regular text-center mb-4">Payment</h2>
                                    <div class="subscription">
                                        <label for="subscription" class="form-label">Select Subscription Plan</label>
                                        <select class="form-select mb-3" id="subscription" name="subscription" required>
                                            <option value="" selected disabled>Select a plan</option>
                                            <option value="Pro+">Pro+</option>      
                                            <option value="Classic">Classic</option>
                                        </select>
                                    </div>
                                    <div class="duration">
                                        <label for="duration" class="form-label">Select Duration</label>
                                        <select class="form-select mb-3" id="duration" name="duration" required>
                                            <option value="" selected disabled>Select duration</option>
                                            <option value="3">3 Months</option>      
                                            <option value="6">6 Months</option>
                                            <option value="12">12 Months</option>
                                        </select>
                                    </div>
                                    <div class="paymentMethodes">
                                        <label for="paymentMethodes" class="form-label">Select Payment Method:</label><br>

                                        <div class="d-flex flex-wrap gap-3 mt-2">
                                            <label class="form-check d-flex align-items-center">
                                            <input type="radio" class="form-check-input me-2" name="paymentMethodes" value="creditCard" >
                                            Credit Card
                                            <i class='bx bxs-credit-card-alt ms-2' style='color:#818181'></i> 
                                            </label>

                                            <label class="form-check d-flex align-items-center">
                                            <input type="radio" class="form-check-input me-2" name="paymentMethodes" value="paypal">
                                            PayPal
                                            <img src="../assets/paypal.svg" alt="PayPal" class="ms-2" style="width: 30px; height: 30px;">
                                            </label>

                                            <label class="form-check d-flex align-items-center">
                                            <input type="radio" class="form-check-input me-2" name="paymentMethodes" value="cash">
                                            Cash (At front desk)
                                            <i class='bx bxs-currency-notes ms-2' style='color:#818181'></i> 
                                            </label>
                                        </div>
                                        <!-- Credit Card Fields -->
                                        <div id="creditCardFields" class="mt-3" style="display: none;">
                                            <div class="mb-2">
                                                <label class="form-label">Cardholder Name</label>
                                                <input type="text" class="form-control" name="card_name" placeholder="John Doe">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Card Number</label>
                                                <input type="text" class="form-control" name="card_number" placeholder="1234 5678 9012 3456">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">Expiry Date (MM/YY)</label>
                                                    <input type="text" class="form-control" name="card_expiry" placeholder="12/28">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">CVV</label>
                                                    <input type="text" class="form-control" name="card_cvv" placeholder="123">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PayPal Fields -->
                                        <div id="paypalFields" class="mt-3" style="display: none;">
                                            <div class="mb-2">
                                                <label class="form-label">PayPal Email</label>
                                                <input type="email" class="form-control" name="paypal_email" placeholder="you@paypal.com">
                                            </div>
                                            <!-- You can add more verification later if needed -->
                                        </div>

                                        <!-- Cash: No fields needed -->
                                        <div id="cashFields" class="mt-3" style="display: none;">
                                            <p class="text-muted p-4">You'll pay in cash at the front desk. Your account will be pending until payment is confirmed.</p>
                                        </div>
                                    </div>
                                    <div class="TOS">
                                        <div class="form-check mb-2 mt-3">
                                            <input class="form-check-input" type="checkbox" id="tos1" name="tos1" required>
                                            <label class="form-check-label" for="tos1" aria-required="true">
                                                I agree to the <a href="#terms" class="link-info">Terms</a> and Conditions.
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" 
                                    class="btn btn-primary w-25 d-block mx-auto mt-3 text-nowrap" 
                                    id="joinSubmit"
                                    >Register</button>
                                    <a href="Login.php" class="d-block text-center mt-3">Already a member? Login now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </div>

    <section class="paymentPopup">
        <div class="popup">
            
        </div>
    </section>
    

    <script src="../js/Join.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo htmlspecialchars(getenv('ENCRYPT_SITE_KEY')); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
    document.getElementById('joinForm').addEventListener('submit', function(e){
        e.preventDefault();
        grecaptcha.ready(function(){
            grecaptcha.execute('<?php echo htmlspecialchars(getenv('ENCRYPT_SITE_KEY')); ?>', {action: 'register'}).then(function(token){
                var f = document.getElementById('joinForm');
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'g-recaptcha-response';
                input.value = token;
                f.appendChild(input);
                f.submit();
            });
        });
    });
    </script>
</body>
</html>