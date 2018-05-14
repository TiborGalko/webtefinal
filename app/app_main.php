
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Aplikácia</title>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <link href="../css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<header>
    <h1>Aplikácia</h1>
</header>


<form action="../scripts/upload.php" method="post" enctype="multipart/form-data">
    <label for="delim">Oddeľovač: </label>
    <input id="delim" type="text" name="delim">
    Select image to upload:
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload" name="submit">
</form>


</body>
</html>
