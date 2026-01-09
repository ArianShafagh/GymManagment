<?php
// Start the session

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $passwordFromDB = $row['password'];
    
        if (password_verify($password, $passwordFromDB)){
            echo"<script>alert('Login successful!'); window.location.href = 'Home.php';</script>";
            exit();
        } else {
            echo"<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        echo"<script>alert('Invalid email. Please try again.');</script>";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="title icon" href="./assets/download.png">
    <link rel="stylesheet" href="./bootstrap/bootstrap.min.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/main.css">

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
    <div class="pageLogin min-vh-100" style="background-image: url(./assets/gym/mohamed-fareed-rbSNsoXk-3A-unsplash.jpg) ; background-size: cover; background-position: center;">
        <section class="logo p-4">
            <img src="./assets/download.png" alt="Logo" class="img-fluid mx-auto d-block" style="width: 150px; height: 150px;">
        </section>

        <!-- login page content -->
        <section class="login">
            <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
                <div class="row w-100">
                    <div class="card col-md-6 offset-md-3 p-4" style="background-color: rgba(255, 255, 255, 0.8);">
                        <h2 class="anton-regular text-center mb-4">Login</h2>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-25 d-block mx-auto">Login</button>
                            <a href="Join.php" class="d-block text-center mt-3">Not a member? Join now</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="./bootstrap/jquery-3.6.0.min.js"></script>
    <script src="./bootstrap/popper.min.js"></script>
    <script src="./bootstrap/bootstrap.min.js"></script>
</body>
</html>