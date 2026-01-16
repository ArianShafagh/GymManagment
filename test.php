<?php

// $a;

// if ($a){
//     echo "Variable is set and true.";
// } else {
//     echo "Variable is not set or false.";
// }


$name = "John Doe";
$x = 65515156.4651;
// $x = (int) $x;
echo $x;
echo "<br>";
echo PHP_INT_MAX;
echo "<br>";
echo gettype($x);
echo var_dump($x);
// echo "Hello, $name! Welcome to the test page.";
// echo "<br>";
// echo 'Hello, $name ! Welcome to the test page.';
// echo strlen($name);

// echo strtoupper($name);

// $x = 10;
// $y = 20.2;
// $sum = $x . $y;
// echo "$sum";

// echo substr($name, 3, 3);

// echo intval($y, 10);
// $z = (string) $x;
// echo gettype($z);
// $x = ['apple', 'banana', 'cherry',];
// $x = array('apple', 'banana', 'cherry');
// echo gettype($x);
// echo "<br>";
// $str = 'which watch you like the most';
// $pattern = '/[wh]/i';

// echo preg_match_all($pattern, $str);

//week day like mon tue wed thu fri sat sun


// echo date('l');
// echo date('Y-m-d H:i:s');


//open a file
// $file = fopen('test.txt','r');
// while(!feof($file)){
//     $line = fgets($file);
//     echo $line . "<br>";
// }

// php jason


// echo count($x);
// foreach($x as $value){
//     echo $value;
// }
// echo phpinfo();

// $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
// echo $days[3];
// $cart = [
//     'item1'=> ['name'=>'Laptop', 'price'=>1000, 'quantity'=>1],
//     'item2'=> ['name'=>'Mouse', 'price'=>50, 'quantity'=>2]
// ];
// echo "<br>";
// foreach($cart as $item){
//     foreach($item as $key=>$value){
//         echo "$key: $value\n";
//     }
//     echo "<br>";
// }

?>
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <meta>
</head>

<body>
    <header>
        <h1>Test Page</h1>
        <p>kir</p>
    </header>
    <main>
        <section>
            <button id="wrap-button" onclick="">Wrap Gallery Items</button>
        </section>
        <div id="output">
            <p>This is a test paragraph.</p>
            <h1>kir</h1>
        </div>
    </main>
    <script src="./bootstrap/jquery-3.7.1.min.js"></script>
    <script src="test.js"></script>

</body>

</html> -->

<!DOCTYPE html>
<head>
    <style>
        .highlight{
            color: yellow;
            font-weight: bold;
        }
        #container{
            display: flex;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="#home">Home</a>
            <a href="#about">About</a>
        </nav>

    </header>
    <main>
        <form method="post">
            <input type="email" name="email" placeholder = "Enter your email">
            <input type="password" name="password" placeholder="Enter your password">
            <button type="submit">submit</button>
            
        </form>

    </main>
    <section>
        <article>
            <h2 class="highlight">Article Title</h2>
            <p>This is an article paragraph.</p>
        </article>
    </section>



    <section>
        <div id="container">
            <div class="box" style="background-color: lightblue; padding: 10px; margin: 5px;">
                Box 1
            </div>
            <div class="box" style="background-color: lightgreen; padding: 10px; margin: 5px;">
                Box 2
            </div>
        </div>
    </section>
    <footer>
        <table border="3" >
            <caption>Monthly income:</caption>
            <thead>
                <tr>
                    <th scope="col">Month</th>
                    <th scope="col">income</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>June</td>
                    <img src="" alt="">
                    <br>
                    <input type="text">
                    
                </tr>
            </tbody>    
        </table>
    </footer>
    <script src="test.js"></script>
</body>
<section>
<h1>jbhbknkjlnkjvkskncvkjnpjkdnfkjvnjfjnkanjvjn</h1>
</section>


</html>