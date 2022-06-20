<?php
    session_start();

    //sprawdzanie czy uzytkownik juz zalogowany
    if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true){
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
		
        <h1>Logowanie do systemu:</h1>
        <?php
            if (isset($_SESSION['blad'])){    
                echo '<h2 style="color: red;">'.$_SESSION['blad'].'</h2>';
                unset($_SESSION['blad']);
            }
        ?>
        
        <div class="box">
            <form method="post" action="skrypty/login.php">
                <table>
                    <tr>
                        <td>E-mail:</td>
                        <td><input type="text" name="mail"></td>
                    </tr>
                    <tr>
                        <td>Hasło:</td>
                        <td><input type="password" name="haslo"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Zaloguj!"></td>
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