<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-black p-2 border-bottom border-danger pb-3">
            <!-- Logo -->
            <a class="navbar-brand d-flex flex-row align-items-end me-lg-5 ms-lg-5 me-sm-5 ms-sm-5" href="home.html">
                <img src="./assets/download.png" alt="logo">
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
                        <ul class="list-group">
                            <li class="list-group-item" data-filter="profile">Profile Information</li>
                            <li class="list-group-item" data-filter="password">Change Password</li>
                            <li class="list-group-item" data-filter="membership">Membership Details</li>
                            <li class="list-group-item" data-filter="credit">Add Credit</li>
                            <li class="list-group-item"><a href="logout.php" class="text-danger">Logout</a></li>
                        </ul>
                    </div>

                </div>
                

                
                

            </div>
        </section>


    <script src="./bootstrap/jquery-3.6.0.min.js"></script>
    <script src="./bootstrap/popper.min.js"></script>
    <script src="./bootstrap/bootstrap.min.js"></script>
</body>
</html>