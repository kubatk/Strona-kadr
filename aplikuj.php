<?php

session_start();

//odrzuc niezalogowanych
if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] == false){
    $_SESSION['blad'] = "Utwórz konto, zanim złożysz aplikację.";
    header("Location: index.php");
    exit();
}

//sprawdz czy admin
 if ($_SESSION['admin']){
    $_SESSION['blad'] = "Nie możesz aplikować jako Administrator.";
    header("Location: index.php");
    exit();
}

//przechwycenie id ogloszenia
if(isset($_GET['id'])){
    $oferta = $_GET['id'];
}
else{
    header("Location: index.php");
    exit();
}

//łączenie z bazą
require_once "config/database.php";
if (!$pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
    $_SESSION['blad'] = "Nie udało się połączyć z bazą. Spróbuj ponownie póżniej";
    header("Location: index.php");
    exit();
}
mysqli_query($pol, "SET NAMES 'utf8'");

//sprawdz czy uzytkownik nie aplikował wcześniej
$zap1 = "SELECT * FROM podania WHERE UID = ".$_SESSION['UID']." AND oferta = ".$oferta;
$query1 = mysqli_query($pol, $zap1);

if(mysqli_num_rows($query1)>0){
    $_SESSION['blad'] = "Nie można aplikować dwa razy na tę samą ofertę.";
    header("Location: index.php");
    exit();
}

//sprawdz, czy nie jest aktualnym pracownikiem firmy
$zap2 = "SELECT * FROM pracownicy WHERE UID = ".$_SESSION['UID'];
$query2 = mysqli_query($pol, $zap2);

if(mysqli_num_rows($query2)>0){
    $_SESSION['blad'] = "Nie możesz aplikować ponieważ jesteś pracownikiem.";
    header("Location: index.php");
    exit();
}

//skoro wszytko ok - dodajemy podanie do bazy
$zap3 = "INSERT INTO podania (UID, oferta) VALUES (".$_SESSION['UID'].", $oferta)";
if (mysqli_query($pol, $zap3)){
    $_SESSION['sukces'] = "Zgłoszenie pojawiło się już na twoim koncie.";
        header("Location: mojepodania.php");
}
else{
    $_SESSION['blad'] = "Wystąpił błąd podczas dodawania zgłoszenia.Spróbuj ponownie póżniej.";
    
}


//zakmnięcie połączenia
mysqli_close($pol);

?>