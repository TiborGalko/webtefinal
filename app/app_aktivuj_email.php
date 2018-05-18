<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Aktivácia</title>
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<header class="jumbotron">
    <h1>Aktivácia</h1>
    <a href="../index.php">Späť na úvodnú stránku</a>
</header>
<div class="container">
    <div>
        <?php
        //nove odoslanie aktivacneho mailu
        if(isset($_GET['status'])){
            echo 'Email bol odoslany';
        }else{
            echo "Prosim aktivujte si účet kliknutím na link ktorý vám prišiel emailom".PHP_EOL;
        }
        ?>
        <form action="preposli_mail.php" method="post">
            <input type="submit" name="posli" class="btn btn-primary" value="Posli mail znovu">
        </form>
    </div>
</div>
</body>
</html>

