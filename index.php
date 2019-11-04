<?php
//pre defined variables
$if_fave = "";

if (isset($_POST['remove'])) {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
    }
    sleep(1);

//Redirect using the Location header.
    header('Location: index.php');


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!--loading animation using jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="js/loading.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Pokémon Extreme</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>
    <link href="https://fonts.googleapis.com/css?family=Staatliches&display=swap" rel="stylesheet">
</head>
<body>
<div class="se-pre-con"></div>
<section class=" text-center">
    <img src="Img/International_Pokémon_logo.svg" alt="pokemon logo">
</section>
<div class="container">
    <div class="pokedex">
        <form method="post">
            <div class="row">
                <div class="col">
                    <label>pokémon type</label>
                    <select name="type" class="form-control md-3">
                        <option value="all">all</option>
                        <option value="grass">Grass</option>
                        <option value="poison">Poison</option>
                        <option value="normal">Normal</option>
                        <option value="electric">Electric</option>
                    </select>
                </div>
                <div class="col">
                    <label>No. of pokémon to show</label>
                    <select name="dropdownvalue" class="form-control md-3">
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="807">807 takes 2 mins to load</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit" name="submit"> apply</button>
            </div>
        </form>
    </div>
</div>


<div class="container-fluid text-center">
    <p class="lead pt-1 text-light">favorite pokémon</p>
    <p class="blacktxt">
        <?php if ($_COOKIE == null) {
            echo "Oops! You dont have any favorite pokémon yet";
            $if_fave = "disabled";
        }
        ?>
    </p>
    <form method="post">
        <button class="btn btn-danger my-2" type="submit" name="remove" <?php echo $if_fave ?>>Remove all favorites
        </button>
    </form>
    <hr>
    <div class="row">

        <?php
        if (isset($_COOKIE)) {
            foreach ($_COOKIE as $Name => $Value) {
                $url = "https://pokeapi.co/api/v2/pokemon/$Value";
                $data = file_get_contents($url);
                $pokemon = json_decode($data);
                echo
                    '<div class="col-md-3"><a href="profile.php?id=' . $Value . '">
                     <div class="card2 mb-4">' . $id = $Value,
                    '<img class="card-image" src="' . $pokemon->sprites->front_default . '"/>',
                    '<div class="card-body"><h2 class="card-title">' . $pname = $Name . '</h2>',
                    '<p class="card-subtitle">Type: ' . $ptype = $pokemon->types[0]->type->name . '</p></a> 
                    <a href="send.php?value=profile.php?id=' . $Value . '">Share</div></div></div>';
            }
        }
        ?>
    </div>
</div>
<hr>
<br>


<?php

$contoshow = $_POST['dropdownvalue'] ?? '20';


echo '<div class="container-fluid">
        <div class="row">';


for ($i = 1; $i <= $contoshow; $i++) {
    $url = "https://pokeapi.co/api/v2/pokemon/$i";
    $data = file_get_contents($url);
    $pokemon = json_decode($data);
    $datatemplate = array(
        '<div class="col-md-3"><a href="profile.php?id=' . $pokemon->id . '">
             <div class="card mb-4">' . $id = $pokemon->id,
        '<img class="card-image" src="' . $pokemon->sprites->front_default . '"/>',
        '<div class="card-body"><h2 class="card-title">' . $pname = $pokemon->name . '</h2>',
        '<p class="card-subtitle">Type: ' . $ptype = $pokemon->types[0]->type->name . '</p></a></div></div></div>'
    );
    echo implode($datatemplate);
}

echo '</div></div>';

?>
<nav aria-label="Page navigation example" class="pagination">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
</nav>
<footer class="my-5 pt-5 pb-1 text-center text-small bg-light blacktxt">
    <p class="mb-1">© 2019 Becode</p>
    <ul class="list-inline">
        <li class="list-inline-item"><a href="index.php">Home</a></li>
        <li class="list-inline-item"><a href="https://pokeapi.co/">pokéApi</a></li>
        <li class="list-inline-item"><a href="https://github.com/Rubicscube/Pokemon-Extreme">Github</a></li>
    </ul>
</footer>
</body>
</html>