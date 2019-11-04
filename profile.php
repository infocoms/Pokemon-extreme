<?php

//value passed from the clicked pokémon (index.php)
$passedId = $_GET["id"];

//FETCH THE API JSON FILE for the received ID
$url = "https://pokeapi.co/api/v2/pokemon/";
$data = file_get_contents($url . $passedId);
$pokemon = json_decode($data);

//pokémon name and stats
$pokname = $pokemon->name;
$speed = $pokemon->stats[0]->base_stat;
$hp = $pokemon->stats[5]->base_stat;
$attack = $pokemon->stats[4]->base_stat;
$defense = $pokemon->stats[3]->base_stat;

// Setting a cookie when the heart button is pressed
$likebuttonval = "submit";

//if like is pressed then create a cookie with the pokeon name and id in it
if (isset($_POST['submit'])) {
    setcookie("$pokname", "$passedId", time() + 30 * 24 * 60 * 60);
    sleep(1);
    header('Location: profile.php?id=' . $passedId);
} //if unlike is pressed remove cookie
elseif (isset($_POST['unsubmit'])) {
    setcookie("$pokname", "", time() - 3600);
    sleep(1);
    header('Location: profile.php?id=' . $passedId);
}

//like button tooltip and icon variables
$likestatus = "";
$likeicon = "";

//if pokemon is not liked then set these values (tooltip & icon)
if (!isset($_COOKIE[$pokname])) {
    $likestatus = "title=\"Add To Favorites\"";
    $likeicon = "fa fa-heart-o fa-2x";
} //if pokemon is liked then set these values
else {
    $likestatus = "title=\"Remove From Favorites\"";
    $likeicon = "fa fa-heart fa-2x";
    $likebuttonval = "unsubmit";
}

//Fetch 4 random moves from moves array
$rand_keys = array_rand($pokemon->moves, 3);
$move1 = $pokemon->moves[0]->move->name;
$move2 = $pokemon->moves[$rand_keys[0]]->move->name;
$move3 = $pokemon->moves[$rand_keys[1]]->move->name;
$move4 = $pokemon->moves[$rand_keys[2]]->move->name;

//Image for the main pokemon the type and the evolution link
$image = $pokemon->sprites->front_default;
$type = $pokemon->types[0]->type->name . ' &nbsp&nbsp&nbsp&nbsp' . $pokemon->types[1]->type->name;
$evolink = $pokemon->species->url;

//if NULL show default pokeball image
if ($image === NULL) {
    $image = "Img/pokeball.svg";
}

//Get information of the main pokémon and also the pokémon evolution name and evolves from LINK
$evodata = file_get_contents($evolink);
$evolution = json_decode($evodata);
$info = $evolution->flavor_text_entries[1]->flavor_text;
$evopokname = $evolution->evolves_from_species->name;
$evopokurl = $evolution->evolves_from_species->url;

//Evolves from link data being fetched and decoded into php while also fetching the url of the pokemon for later use
$imgevo = file_get_contents($evopokurl);
$evoimg = json_decode($imgevo);
$evoimglink = $evoimg->varieties[0]->pokemon->url;

//the url from before (LATER USE) is being used to fetch the image of the previous pokemon
$evoimgfetch = file_get_contents($evoimglink);
$evoimgdata = json_decode($evoimgfetch);
$evoimglinkfinal = $evoimgdata->sprites->front_default;
$evoinfolink = $evoimgdata->species->url;

//fetching prev evo information
$evoinfostuff = file_get_contents($evoinfolink);
$evoinfodata = json_decode($evoinfostuff);
$evoinfo = $evoinfodata->flavor_text_entries[1]->flavor_text;

//if no prev evolution image then show default pokeball
if ($evoimglinkfinal === NULL) {
    $evoimglinkfinal = "Img/pokeball.svg";
}
//if no prev evolution poké name then show NO PREV EVOLUTION
if ($evopokname === NULL) {
    $evopokname = "No Previous Evolution";
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
    <script src="https://use.fontawesome.com/cb8ec5d411.js"></script>
</head>
<body>


<div class="profile bg-light">
    <section class="jumbotron p-0 text-center">
        <div class="container">
            <img src="Img/International_Pokémon_logo.svg" alt="pokemon logo">
            <p class="lead pt-1 text-muted">Basic information about <u><?php echo $pokname ?></u> can be found here, all
                of this information comes from the pokéapi.</p>
            <form method="post">
                <a href="index.php" class="btn btn-primary my-2">back to home</a>
                <a href="fave.php" class="btn btn-warning my-2">Show my favorites</a>
            </form>
        </div>
    </section>
    <div class="container blacktxt">

        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4 rounded-circle border border-dark" src="<?php echo "$image" ?>" alt=""
                 width="150" height="150">
            <form method="post">
                <button class="btn btn-light my-2" type="submit"
                        name="<?php echo $likebuttonval ?>" <?php echo $likestatus ?>><i class="<?php echo $likeicon ?>"
                                                                                         style="color:#dd001b;"></i>
                </button>
            </form>
            <h2><?php echo $pokname ?></h2>
            <p class="lead"><?php echo $info ?></p>
        </div>

        <div class="poktypes">
            <h2 class="typeblur pt-5 text-center">pokémon type</h2>
            <p class="typeblur pb-5 text-center"><?php echo $type ?></p>
        </div>

        <h2 class="text-center">statistics</h2>
        <label>Base HP</label>
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                 style="width: <?php echo "$hp" ?>%" aria-valuenow="<?php echo "$hp" ?>" aria-valuemin="0"
                 aria-valuemax="255"></div>
        </div>
        <label>Base SPEED</label>
        <div class="progress">
            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo "$speed" ?>%"
                 aria-valuemin="0" aria-valuemax="180"></div>
        </div>
        <label>Base attack</label>
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                 style="width: <?php echo "$attack" ?>%" aria-valuemin="0" aria-valuemax="190"></div>
        </div>
        <label>Base defense</label>
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                 style="width: <?php echo "$defense" ?>%" aria-valuemin="0" aria-valuemax="230"></div>
        </div>
        <hr>
        <h2 class="mt-3 text-center">Moves</h2>
        <div class=" text-center" id="move"><?php
            echo " $move1 &nbsp &nbsp,&nbsp &nbsp $move2 &nbsp &nbsp,&nbsp &nbsp $move3 &nbsp &nbsp,&nbsp &nbsp $move4"; ?> </div>
        <hr>
        <h2 class="mt-5 text-center">Previous evolution</h2>
        <div class=" text-center">
            <img class="d-block mx-auto mb-4 rounded-circle border border-dark" src="<?php echo "$evoimglinkfinal" ?>"
                 alt=""
                 width="150" height="150">
            <h2><?php echo $evopokname ?></h2>
            <p class="lead"><?php echo $evoinfo ?></p>
        </div>
        <footer class="my-5 pt-5 pb-5 text-center text-small">
            <p class="mb-1">© 2019 Becode</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="index.php">Home</a></li>
                <li class="list-inline-item"><a href="https://pokeapi.co/">pokéApi</a></li>
                <li class="list-inline-item"><a href="https://github.com/Rubicscube/Pokemon-Extreme">Github</a></li>
            </ul>
        </footer>
    </div>
</div>
</body>

</html>