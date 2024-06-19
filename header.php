<?php
    include_once ("functions.php");

    if (isset($_POST['logout'])) {
        echo "<script>localStorage.removeItem('panier');</script>";
        
        session_unset();
        session_destroy();

        header("Location: " . CHEMIN_URL_SERVER . "account/login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confiz</title>

    <!-- icône sur l'onglet de la page web -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?=CHEMIN_URL_SERVER?>media/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=CHEMIN_URL_SERVER?>media/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=CHEMIN_URL_SERVER?>media/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=CHEMIN_URL_SERVER?>media/images/favicon/site.webmanifest">

    <!-- liens CSS -->
    <link rel="stylesheet" href="<?=CHEMIN_URL_SERVER?>styles.css">
    <link rel="stylesheet" href="<?=CHEMIN_URL_SERVER?>account/login_styles.css"> 

    <!-- fonts (paytone one, league spartan et inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=League+Spartan:wght@100..900&family=Paytone+One&display=swap" rel="stylesheet">
    
    <!-- icônes de fontawesone -->
    <script src="https://kit.fontawesome.com/81e44f4840.js" crossorigin="anonymous"></script>

    <!-- liens Javascript -->
    <script src="<?=CHEMIN_URL_SERVER?>account/login_script.js" defer></script> <!--script login JS--> 
    <script src="<?=CHEMIN_URL_SERVER?>app.js" defer></script> <!--script JS--> 

</head>
<body>
    <header>
        <article class="w-70">
            <nav>
                <a href="<?=CHEMIN_URL_SERVER?>index.php" class="league-spartan p-30 hover-header">Accueil</a>
                <a href="<?=CHEMIN_URL_SERVER?>boutiques.php" class="league-spartan p-30 hover-header">Nos boutiques</a>
            </nav>
            <a href="<?=CHEMIN_URL_SERVER?>index.php">
                <img src="<?=CHEMIN_URL_SERVER?>media/images/logo_confiz.png" alt="Logo Confiz" width="auto" height="100">
            </a>
            <nav>
                <?php
                if (isset($_SESSION["role"]) && $_SESSION['role'] === 'admin') {
                ?>    
                    <a href="admin.php"><i class="fa-solid fa-gear p-30"></i></a>
                <?php
                }
                ?>
                <button id="panier-toggle" >
                    <i class="fa-solid fa-cart-shopping p-30"></i>
                </button>
                
                <a href="<?=CHEMIN_URL_SERVER?>account/login.php" style="display: flex; align-items: center; gap: 10px;">
                    <?php
                    if (!isset($_SESSION["username"])) {
                    ?>
                        <i class="fa-regular fa-user p-30"></i>
                    <?php
                    } else {
                    ?>   
                        <form method="post" style="display: inline;">
                            <button type="submit" name="logout" class="header-logout-button"><i class="fa-solid fa-right-from-bracket p-30"></i></button>
                        </form>
                        <p class="p-26 league-spartan"><?=$_SESSION["username"]?></p>
                    <?php
                    }
                    ?>
                </a>
            </nav>
        </article>
    </header>
    <span class="header-fictif"></span>

    <!-- Panier javascript -->
    <aside id="panier" class="panier">
        <div class="header-panier">
            <p class="p-20">Votre panier :</p>
            <i class="panier-cross fa-solid fa-xmark p-30 "></i>
        </div>   
        
        <div class="articles-panier">
            <!-- Rempli en javascript -->
        </div>

        <div class="total-panier p-20">
            <!-- Rempli en javascript -->
        </div>
    </aside>
</body>

<!-- Pas dans un fichier à part pour éviter les problèmes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutButton = document.querySelector('.header-logout-button');

        if (logoutButton) {
            logoutButton.addEventListener('click', function() {
                // Vider le panier du localStorage
                localStorage.removeItem('panier');
            });
        }
    });
</script>
</html>