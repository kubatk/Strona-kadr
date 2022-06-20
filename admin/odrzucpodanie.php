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
        header("Location: podania.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //odebranie ID podania
    if (isset($_GET['id'])){
        $podanie = $_GET['id'];
    }
    else{
        $_SESSION['blad'] = "Błąd podczas usuwania podania. Spróbuj ponownie później.";
        header('Location: podania.php');
        exit();
    }

    //usuwanie podania z bazy
    $zap = "DELETE FROM podania WHERE ID = ".$podanie;
    if ($query = mysqli_query($pol, $zap)){
            
        $_SESSION['sukces'] = "Pomyślnie usunięto podanie";
        header("Location: podania.php");
        exit();

    }
    else{
        $_SESSION['blad'] = "Błąd podczas usuwania podania. Spróbuj ponownie póżniej";
        header("Location: podania.php");
        exit();
    }

//zamknięcie połączenia
mysqli_close($pol);
