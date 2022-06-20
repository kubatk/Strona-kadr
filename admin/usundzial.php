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
        header("Location: firma.php");
        exit();
    }
    mysqli_query($pol, "SET NAMES 'utf8'");
    
    //sprawdź czy podane id
    if (isset($_GET['id'])) $edytuj_id = $_GET['id'];
    else{
        $_SESSION[blad] = "Nie można usunąć działu. Spróbuj ponownie póżniej";
        header("Location: firma.php");
        exit();
    }
    
    //czy zawiera stanowiska
    $zap = "SELECT * FROM stanowiska WHERE ID_dzial = ".$edytuj_id;
    $query = mysqli_query($pol, $zap);
    
    if (mysqli_num_rows($query)>0){
        $_SESSION[blad] = "Nie można usunąć działu gdy zawiera stanowiska!!!";
        header("Location: firma.php");
        exit();
    }

    //usuwanie działu
    $zap1 = "DELETE FROM dzialy WHERE ID = ".$edytuj_id;
    if (mysqli_query($pol, $zap1)){
        $_SESSION['sukces'] = "Usunięto dział";
        header("Location: firma.php");
        exit();
    }
    else{
        $_SESSION['blad'] = "Nie udało się usunąć działu. Spróbuj ponownie póżniej";
        header("Location: firma.php");
        exit();
    }
 
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
		
        <h1>Aktualizuj dział</h1>
        
        <?php
            //pobranie wartości z bazy
            $zap1 = "SELECT nazwa FROM dzialy WHERE ID = ".$edytuj_id;
            $query1 = mysqli_query($pol, $zap1);
            $w1 = mysqli_fetch_array($query1);
        ?>
        
        <div class="box">
            <form method="post">
                <table>
                    <tr>
                        <td>Nazwa:</td>
                        <td><input type="text" name="nazwa" value="<?php echo $w1['nazwa'] ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Aktualizuj dział"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" value="Usun stanowisko" onclick="location.href='usundzial.php?id=<?php echo $edytuj_id; ?>'" style="background-color: #dc524c;"></td>
                    </tr>
                </table>
            </form>
        </div>
            
             
	</div>
    
    <div class="footer">
        <div class="footer-content">Projekt wykonał: Jakub Trzciński</div>
    </div>
    
    <?php
        mysqli_close($pol);
    ?>
</body>
</html>