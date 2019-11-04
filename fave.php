<?php


if (isset($_POST['submit'])) {
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
    header('Location: fave.php');


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Pokémon Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>
    <link href="https://fonts.googleapis.com/css?family=Staatliches&display=swap" rel="stylesheet">
</head>
<body>
<div class="profile blacktxt">
    <section class="jumbotron p-0 text-center">
        <div class="container-fluid">
            <img src="Img/International_Pokémon_logo.svg">
            <p class="lead pt-1">your favorite pokemon's</p>
            <div class="container-fluid">
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
            <p>
                <?php if ($_COOKIE == null) {
                    echo "Oops! You dont have any favorite pokémon yet";
                }
                ?>
            </p>
            <form method="post">
                <a href="index.php" class="btn btn-primary my-2">back to home</a>
                <button class="btn btn-danger my-2" type="submit" name="submit">Remove all favorites</button>
            </form>

        </div>
    </section>
</div>
</body>
</html>