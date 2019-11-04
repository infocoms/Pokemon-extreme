<?php



$link = $_GET['value'];
$emailval = "Look at this pokemon, it is so cool!".' LINK: '.$link;

if(isset($_POST['submit'])){
    if (mail($_POST['email'],"Pokémon Extreme",$_POST['message'])){

    echo "Mail Sent. Thank you, we will contact you shortly.";
    sleep(2);
    header('Location: index.php');
}else{
        echo "failed";
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Pokémon Share with a friend</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen"/>
    <link href="https://fonts.googleapis.com/css?family=Staatliches&display=swap" rel="stylesheet">
</head>
<body>
<div class="profile blacktxt">
    <section class="jumbotron p-0 text-center">
        <div class="container-fluid">
            <img src="Img/International_Pokémon_logo.svg" alt="pokemon logo">
            <p class="lead pt-1">Share with a friend</p>
            <div class="container-fluid">
                <form action="" method="post">
                    Email: <input type="text" name="email"><br>
                    Message:<br><textarea rows="5" name="message" cols="30"><?php echo $emailval?></textarea><br>
                    <input class="btn btn-success my-2" type="submit" name="submit" value="Send">
                    <a href="index.php" class="btn btn-danger my-2">I changed my mind</a>
                </form>
            </div>
        </div>
    </section>
</div>
</body>
</html>







