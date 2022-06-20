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
        header("Location: uzytkownicy.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");

    //czy formularz wysłany?
    if (isset($_POST['imie'])){
        
        //zmienne pomocnicze    
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $dataurodzenia = $_POST['dataurodzenia'];
        $plec = $_POST['plec'];
        $email = $_POST['email'];
        $telefon = $_POST['telefon'];
        $miasto = $_POST['miasto'];
        $adres = $_POST['adres'];
        $poczta = $_POST['poczta'];
        $kod = $_POST['kod'];

        
        $zap = "INSERT INTO uzytkownicy VALUES (NULL, '$email', NULL, 0)";
        if (mysqli_query($pol, $zap)){
            
            $zap2 = "INSERT INTO daneosobowe VALUES (NULL, (SELECT LAST_INSERT_ID() AS id), '$imie', '$nazwisko', '$dataurodzenia', '$plec', '$telefon', '$miasto', '$adres', '$poczta', '$kod')";
            
            if (mysqli_query($pol, $zap2)){
                $_SESSION['sukces'] = "Pomyślnie utworzono użytkownika";
                header("Location: uzytkownicy.php");
                exit();
            }
            else{
                $_SESSION['blad'] = "Nie udało się utworzyć użytkownika. Spróbuj ponownie póżniej.";
                header("Location: uzytkownicy.php");
                exit();
            }
        }
        else{
            $_SESSION['blad'] = "Nie udało się utworzyć użytkownika. Spróbuj ponownie póżniej.";
            header("Location: uzytkownicy.php");
            exit();
        }
    }

    mysqli_close($pol);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Znajdź pracę</title>
    
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    
	<link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
    
    <!-- menu-->
    <?php include "../skrypty/menu.php"; ?>

    
    <div class="content">
		
        <h1>Kreator tworzenia użytkownika</h1>
        
        <div class="box">
            <form method="post">
                <table>
                    <tr>
                        <td>Imię:</td>
                        <td><input type="text" name="imie"></td>
                    </tr>
                    <tr>
                        <td>Nazwisko:</td>
                        <td><input type="text" name="nazwisko"></td>
                    </tr>
                    <tr>
                        <td>Data urodzenia:</td>
                        <td><input type="date" name="dataurodzenia"></td>
                    </tr>
                    <tr>
                        <td>Płeć:</td>
                        <td>
                            <select name="plec">
                                <option value="m">mężczyzna</option>
                                <option value="k">kobieta</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td>E-mail:</td>
                        <td><input type="text" name="email"></td>
                    </tr>
                    <tr>
                        <td>Nr telefonu:</td>
                        <td><input type="text" name="telefon"></td>
                    </tr>
                    <tr>
                        <td>Miasto:</td>
                        <td><input type="text" name="miasto"></td>
                    </tr>
                    <tr>
                        <td>Adres:</td>
                        <td><input type="text" name="adres"></td>
                    </tr>
                    <tr>
                        <td>Poczta:</td>
                        <td><input type="text" name="poczta"></td>
                    </tr>
                    <tr>
                        <td>Kod pocztowy:</td>
                        <td><input type="text" name="kod"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Dodaj użytkownika"></td>
                    </tr>
                </table>
            </form>
        </div>
            
             
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
</body>
</html>