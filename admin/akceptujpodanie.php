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
        $_SESSION['blad'] = "Błąd przy wykonywaniu operacji. Spróbuj ponownie później.";
        header('Location: podania.php');
        exit();
    }

    //dodawanie pracownika
    $zap = "SELECT ogloszenia.ID_stanowiska, podania.UID FROM podania JOIN ogloszenia ON podania.oferta = ogloszenia.ID WHERE podania.ID = ".$podanie;
    if ($query = mysqli_query($pol, $zap)){
        
        $w = mysqli_fetch_array($query);
        
        $zap2 = "INSERT INTO pracownicy VALUES (NULL, ".$w['UID'].", ".$w['ID_stanowiska'].")";
        if(mysqli_query($pol, $zap2)){
            
            $zap3 = "UPDATE podania SET zaakceptowane = 1 WHERE ID = ".$podanie;
            mysqli_query($pol, $zap3);
            
            $_SESSION['sukces'] = "Pomyślnie zatrudniono pracownika";
            header("Location: podania.php");
            exit();
        }
        else{
            $_SESSION['blad'] = "Nie udało się zatrudnić pracownika. Spróbuj ponownie póżniej";
            header("Location: podania.php");
            exit();
        }
    }
    else{
        $_SESSION['blad'] = "Nie udało się zatrudnić pracownika. Spróbuj ponownie póżniej";
        header("Location: podania.php");
        exit();
    }

//zamknięcie połączenia
mysqli_close($pol);
