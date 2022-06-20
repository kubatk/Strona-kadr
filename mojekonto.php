<?php
    session_start();

    //sprawdzanie czy uzytkownik jest zalogowany
    if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] == false){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Znajdź pracę</title>
    
	<link rel="stylesheet" type="text/css" href="css/style.css">
    
	<link href="https://fonts.googleapis.com/css?family=Lato|Ubuntu" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
    
    <!-- menu-->
    <?php include "skrypty/menu.php"; ?>
	
    <div class="content">
		
        <h1>Twoje dane:</h1>
        
        <div class="box">
            <form method="post" action="skrypty/register.php">
                <table>
                    <tr>
                        <td>Imię:</td>
                        <td><?php echo $_SESSION['imie']; ?></td>
                    </tr>
                    <tr>
                        <td>Nazwisko:</td>
                        <td><?php echo $_SESSION['nazwisko']; ?></td>
                    </tr>
                    <tr>
                        <td>Data urodzenia:</td>
                        <td><?php echo $_SESSION['data_ur']; ?></td>
                    </tr>
                    <tr>
                        <td>Płeć:</td>
                        <td>
                            <?php
                                if ($_SESSION['plec'] == 'm') $plec = "mężczyzna";
                                else $plec = "kobieta";
                                echo $plec;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>E-mail:</td>
                        <td><?php echo $_SESSION['email']; ?></td>
                    </tr>
                    <tr>
                        <td>Nr telefonu:</td>
                        <td><?php echo $_SESSION['tel']; ?></td>
                    </tr>
                    <tr>
                        <td>Miasto:</td>
                        <td><?php echo $_SESSION['miasto']; ?></td>
                    </tr>
                    <tr>
                        <td>Adres:</td>
                        <td><?php echo $_SESSION['adres']; ?></td>
                    </tr>
                    <tr>
                        <td>Poczta:</td>
                        <td><?php echo $_SESSION['poczta']; ?></td>
                    </tr>
                    <tr>
                        <td>Kod pocztowy:</td>
                        <td><?php echo $_SESSION['kod_pocztowy']; ?></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td colspan="2"><span style="font-size: 18px;">Edycja danych niemożliwa. Skontaktuj się z administratorem w razie wątpliwości co do poprawności danych.</span></td>
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