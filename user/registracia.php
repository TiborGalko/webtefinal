<?php
include_once "../db/usersdb.php";

if(isset($_POST['skolaadresa'])) {
    insertNewUser($_POST['priezvisko'],$_POST['meno'],$_POST['email'],
        $_POST['skolameno'],$_POST['skolaadresa'],$_POST['ulica'],$_POST['psc'],$_POST['mesto'],$_POST['password']);
}




