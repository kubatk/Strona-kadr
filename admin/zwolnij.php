<?php
    session_start();

    //jezeli nie admin - przekieruj na głowną
    if (!$_SESSION['admin']){
        header("Location: ../index.php");
        exit();
    }

    //łączenie z bazą
    require_once "../config/database.php";
    if (!$pol = mysqli_connect($db_host, $db_user, $db_pass, $db_name)){
        $_SESSION['blad'] = "Nie udało się połączyć z bazą. Spróbuj ponownie póżniej";
        header("Location: ../pracownicy.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //odebranie ID użytkownika
    if (isset($_GET['uid'])){
        $uid = $_GET['uid'];
    }
    else{
        $_SESSION['blad'] = "Nie można zwolnić pracownika. Spróbuj ponownie później.";
        header('Location: pracownicy.php');
        exit();
    }

    //zwalnianie
    $zap = "DELETE FROM pracownicy WHERE UID = $uid";
    if (mysqli_query($pol, $zap)){
        $_SESSION['sukces'] = "Pomyślnie zwolniono pracownika";
        header("Location: pracownicy.php");
        exit();
    }
    else{
        $_SESSION['blad'] = "Nie udało się zwolnić pracownika. Spróbuj ponownie póżniej";
        header("Location: pracownicy.php");
        exit();
    }

//zamknięcie połączenia
mysqli_close($pol);
