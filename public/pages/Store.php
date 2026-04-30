<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bull Store</title>
    <link rel="title icon" href="../assets/download.png">
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link href='https://cdn.boxicons.com/3.0.6/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/Store.css">

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
                <p class="bbh-bartle-regular text-danger fst-italic">Store</p>
            </a>
            <button class="navbar-toggler position-static me-lg-5 ms-lg-5 me-sm-5 ms-sm-5" type="button" data-toggle="collapse" data-target="#mynav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-around" id="mynav">
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
                <div class="access d-lg-none d-flex justify-content-center mt-3">
                <div class="login d-flex align-items-center me-3">
                    <i class="bx bx-arrow-to-right text-light me-1"></i>
                    <a href="Login.php" class="anton-regular text-light text-decoration-none fs-5">Login</a>
                </div>
                <a href="Join.php" class="anton-regular btn btn-outline-danger fs-5 px-3">Join now</a>
                </div>
            </div>
                <div class="access d-none d-lg-flex justify-content-end mt-3">
                <div class="login d-flex align-items-center me-3">
                    <i class="bx bx-arrow-to-right text-light me-1"></i>
                    <a href="Login.php" class="anton-regular text-light text-decoration-none fs-5">Login</a>
                </div>
                <a href="Join.php" class="anton-regular btn btn-outline-danger fs-3 px-3">Join now</a>
                </div>

        </nav>
        <!-- navbar end -->

        <!-- slider start -->
        <section class="slider bg-black">
            <div id="carouselStoreIndicators" class="carousel slide" data-ride="carousel" data-interval="8000">
                <div class="carousel-inner">
                    <div class="carousel-item active mt-5 h-100">
                    <div class="container-fluid h-100">
                        <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-6 text-light text-center text-md-start px-4 px-md-5 mt-sm-5">
                            <h1 class="anton-regular display-4">Choice of Champions</h1>
                            <p class="fs-5 mt-3">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus eius laudantium a mollitia veniam fuga assumenda, porro nulla incidunt ex architecto quas cum perferendis iusto harum modi culpa facere sapiente ullam sit voluptates molestias saepe? Porro fugit aut vero minima perspiciatis odio incidunt, praesentium ab. Soluta tenetur fugit fugiat facilis.
                            </p>
                            <a href="#supplements" class="btn btn-outline-light mt-3 px-4">Shop Now</a>
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content-center px-3 mt-sm-5">
                            <div class="video-wrapper w-100" style="max-width: 800px; height: 800px; position: relative;">
                                <img src="../assets/Store/Supplements/hadi.webp" alt="item1"
                                 class="w-100 h-100" style="object-fit: cover; border-radius: 8px; opacity: 0.75;">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                    <div class="carousel-item h-100 mt-5">
                    <div class="container-fluid h-100">
                        <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-6 text-light text-center text-md-start px-4 px-md-5 mt-sm-5">
                            <h1 class="anton-regular display-4">Look Good, Feel Good</h1>
                            <p class="fs-5 mt-3">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus eius laudantium a mollitia veniam fuga assumenda, porro nulla incidunt ex architecto quas cum perferendis iusto harum modi culpa facere sapiente ullam sit voluptates molestias saepe? Porro fugit aut vero minima perspiciatis odio incidunt, praesentium ab. Soluta tenetur fugit fugiat facilis.
                            </p>
                            <a href="#clothes" class="btn btn-outline-light mt-3 px-4">Shop Now</a>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-center px-3 mt-sm-5">
                            <div class="video-wrapper w-100" style="max-width: 800px; height: 800px; position: relative;">
                                <img src="../assets/Store/Clothes/pexels-shuttersavage-34270097.jpg" alt="item2"
                                 class="w-100 h-100" style="object-fit: cover; border-radius: 8px; opacity: 0.75;">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                    <div class="carousel-item h-100 mt-5">
                    <div class="container-fluid h-100">
                        <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-6 text-light text-center text-md-start px-4 px-md-5 mt-sm-5">
                            <h1 class="anton-regular display-4">Best Accessories for you</h1>
                            <p class="fs-5 mt-3">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi soluta voluptatibus laborum quas aut quam non explicabo! Amet soluta repellat expedita iusto nihil beatae ullam labore vitae veniam? Similique, cupiditate.
                            </p>
                            <a href="#accessories" class="btn btn-outline-light mt-3 px-4">Shop Now</a>
                        </div>
                        <div class="col-12 col-md-6 d-flex justify-content-center px-3 mt-sm-5">
                            <div class="video-wrapper w-100" style="max-width: 800px; height: 800px; position: relative;">
                                <img src="../assets/Store/Accessories/pexels-krzysztof-biernat-406313862-14918312.jpg" alt="item3"
                                 class="w-100 h-100" style="object-fit: cover; border-radius: 8px; opacity: 0.75;">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-next" href="#carouselStoreIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </section>
        <!-- slider end -->
    </header>
    
    <main>
        <!-- supplements items -->
        <section class="supplements" id="supplements">
            <h1 class="anton-regular display-4 ms-5 mt-5 text-center">Supplements</h1>
            <div class="slider">
                <div id="carouselSupplements" class="carousel slider" data-ride="carousel" data-interval="0">
                    <div class="carousel-inner p-4">
                        <div class="carousel-item active h-100">
                            <div class="container">
                                <div class="row g-5">
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/protein-1.avif" alt="Supplement 1">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 1</h5>
                                                <p class="card-text fs-5 fw-bold">$29.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/protein-2.avif" alt="Supplement 2">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 2</h5>
                                                <p class="card-text fs-5 fw-bold">$39.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/creatin-1.avif" alt="Supplement 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 3</h5>
                                                <p class="card-text fs-5 fw-bold">$69.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/creatin-2.avif" alt="Supplement 4">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 4</h5>
                                                <p class="card-text fs-5 fw-bold">$49.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item h-100">
                            <div class="container">
                                <div class="row g-5">
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/bcaa-1.avif" alt="Supplement 1">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 5</h5>
                                                <p class="card-text fs-5 fw-bold">$19.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/bcaa-2.avif" alt="Supplement 2">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 6</h5>
                                                <p class="card-text fs-5 fw-bold">$65.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/vitamin-1.avif" alt="Supplement 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 7</h5>
                                                <p class="card-text fs-5 fw-bold">$99.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Supplements/vitamin-2.avif" alt="Supplement 4">
                                            <div class="card-body">
                                                <h5 class="card-title">Supplement 8</h5>
                                                <p class="card-text fs-5 fw-bold">$79.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev display-1 prev-click" href="#carouselSupplements" role="button" data-slide="prev">
                            <i class='bx  bx-caret-left bx-flip-horizontal' style='color:#000000'></i> 
                        </a>
                        <a class="carousel-control-next display-1 next-click" href="#carouselSupplements" role="button" data-slide="next">
                            <i class='bx  bx-caret-right bx-flip-horizontal' style='color:#000000'></i> 
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="offer justify-content-center d-flex my-5">
            <div class="offer-content d-flex flex-column flex-md-row align-items-center justify-content-center text-center text-md-start p-4 p-md-5 bg-black text-light rounded-5 w-75">
                <div class="offer-text me-md-5 mb-4 mb-md-0">
                    <h2 class="anton-regular display-4 text-danger">Special Offer!</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Optio adipisci beatae placeat doloremque quas eius itaque ab iusto? Qui, quidem.</p>
                </div>
                <a href="#supplements" class="btn btn-danger btn-lg px-4">Shop Now</a>
            </div>
        </section>


        <!-- accessories items  -->
        <section class="accessories" id="accessories">
            <h1 class="anton-regular display-4 ms-5 text-center">Accessories</h1>
            <div class="slider">
                <div id="carouselAccessories" class="carousel slider" data-ride="carousel" data-interval="0">
                    <div class="carousel-inner p-4">
                        <div class="carousel-item active h-100">
                            <div class="container">
                                <div class="row g-5">
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC8.jpg" alt="Accessory 8">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 8</h5>
                                                <p class="card-text fs-5 fw-bold">$29.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC7.jpg" alt="Accessory 7">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 7</h5>
                                                <p class="card-text fs-5 fw-bold">$39.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC6.jpg" alt="Accessory 6">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 6</h5>
                                                <p class="card-text fs-5 fw-bold">$69.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC5.jpg" alt="Accessory 5">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 5</h5>
                                                <p class="card-text fs-5 fw-bold">$49.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item h-100">
                            <div class="container">
                                <div class="row g-5">
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC4.jpg" alt="Accessory 4">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 4</h5>
                                                <p class="card-text fs-5 fw-bold">$19.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC3.jpg" alt="Accessory 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 3</h5>
                                                <p class="card-text fs-5 fw-bold">$65.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC2.jpg" alt="Accessory 2">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 2</h5>
                                                <p class="card-text fs-5 fw-bold">$99.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Accessories/ACC1.jpg" alt="Accessory 1">
                                            <div class="card-body">
                                                <h5 class="card-title">Accessory 1</h5>
                                                <p class="card-text fs-5 fw-bold">$79.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev display-1 prev-click" href="#carouselAccessories" role="button" data-slide="prev">
                            <i class='bx  bx-caret-left bx-flip-horizontal' style='color:#000000'></i> 
                        </a>
                        <a class="carousel-control-next display-1 next-click" href="#carouselAccessories" role="button" data-slide="next">
                            <i class='bx  bx-caret-right bx-flip-horizontal' style='color:#000000'></i> 
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="offer justify-content-center d-flex my-5">
            <div class="offer-content d-flex flex-column flex-md-row align-items-center justify-content-center text-center text-md-start p-4 p-md-5 bg-black text-light rounded-5 w-75">
                <div class="icone">
                    <i class="bx bxs-biceps bx-bounce display-1" style='color:#ff0000'></i>
                </div>
                <div class="offer-text me-md-5 mb-4 mb-md-0">
                    <h2 class="anton-regular display-4">Special Offer!</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Optio adipisci beatae placeat doloremque quas eius itaque ab iusto? Qui, quidem.</p>
                </div>
                <a href="#accessories" class="btn btn-danger btn-lg px-4">Shop Now</a>
            </div>
        </section>

        <!-- clothes items  -->
        <section class="clothes" id="clothes">
            <h1 class="anton-regular display-4 ms-5 text-center">clothes</h1>
            <div class="slider">
                <div id="carouselClothes" class="carousel slider" data-ride="carousel" data-interval="0">
                    <div class="carousel-inner p-4">
                        <div class="carousel-item active h-100">
                            <div class="container">
                                <div class="row g-5">
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA8.jpg" alt="Supplement 1">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 1</h5>
                                                <p class="card-text fs-5 fw-bold">$29.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA7.avif" alt="Clothes 2">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 2</h5>
                                                <p class="card-text fs-5 fw-bold">$39.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA6.avif" alt="Clothes 3">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 3</h5>
                                                <p class="card-text fs-5 fw-bold">$69.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA5.jpg" alt="Clothes 4">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 4</h5>
                                                <p class="card-text fs-5 fw-bold">$49.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item h-100">
                            <div class="container">
                                <div class="row g-5">
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA4.jpg" alt="Clothes 5">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 5</h5>
                                                <p class="card-text fs-5 fw-bold">$19.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA3.jpg" alt="Clothes 6">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 6</h5>
                                                <p class="card-text fs-5 fw-bold">$65.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA2.avif" alt="Clothes 7">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 7</h5>
                                                <p class="card-text fs-5 fw-bold">$99.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item col-md-3 col-6 d-flex justify-content-center">
                                        <div class="card shadow-lg" style="width: 18rem;">
                                            <img class="card-img-top" src="../assets/Store/Clothes/NBA1.jpg" alt="Clothes 8">
                                            <div class="card-body">
                                                <h5 class="card-title">Clothes 8</h5>
                                                <p class="card-text fs-5 fw-bold">$79.99</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, voluptas.</p>
                                                <a href="#" class="btn btn-primary">Add to Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev display-1 prev-click" href="#carouselClothes" role="button" data-slide="prev">
                            <i class='bx  bx-caret-left bx-flip-horizontal' style='color:#000000'></i> 
                        </a>
                        <a class="carousel-control-next display-1 next-click" href="#carouselClothes" role="button" data-slide="next">
                            <i class='bx  bx-caret-right bx-flip-horizontal' style='color:#000000'></i> 
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
  <!-- footer start -->
  <footer>
    <div class="footer bg-black text-light d-flex flex-column align-items-center py-4">
      <img src="../assets/download.png" alt="LOGO" class="mb-3">
      <h2 class="anton-regular text-danger display-4">BULL</h2>
      <p class="fs-5 text-center px-3 px-md-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
      <p class="fs-5 mt-3">&copy; 2025 Bull. All rights reserved.</p>
    </div>
  </footer>
  <!-- footer end -->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>