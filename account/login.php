<?php
include_once("../header.php");
?>

<!DOCTYPE html>
<html lang="fr">
<body>
    <main class="login-main">
        <span class="login-background">
            <!-- forme polygone de fond -->
        </span>
        <section class="login-container">
            <article class="login-form-container">
                <a href="<?=CHEMIN_URL_SERVER?>index.php">< Retour à l'accueil</a>
                <nav>
                    <button class="register-button button-inactive p-20">Inscription</button>
                    <span class="nav-separation"></span>
                    <button class="login-button button-active p-20">Connexion</button>
                </nav>
                <form class="login-form" action="login_verification.php" method="post">
                    <div>
                        <i class="fa-regular fa-user"></i>                        
                        <input class="input-name" type="text" id="name" name="name" required>
                        <label for="name">username</label>
                    </div>
                    <div>
                        <i class="fa-regular fa-user"></i>                        
                        <select name="role" id="role">
                        <option value="user">Client</option>
                        <option value="gerant">Gérant</option>
                        <option value="admin">Administrateur</option>
                        </select>
                    </div>
                    <div>
                        <i class="fa-solid fa-lock"></i>                        
                        <input class="input-password" type="password" id="password" name="password" required>
                        <label for="password">Mot de passe :</label>
                        <button id="toggle-password"><i class="fa-solid fa-eye"></i></button>                        
                    </div>
                    <input type="submit" value="Se connecter" class="submit-button p-20 border-r-15">
                </form>

                <?php
                    if (isset($_SESSION['error'])) {
                        echo('<p>' . $_SESSION['error'] . '</p>');
                        $_SESSION['error'] = '';
                    }
                ?>
            </article>
            
            <article class="welcome-text">
                <h2 class="paytone-one p-60">Bienvenue hez</h2>
                <h1 class="paytone-one">Confiz</h1>
            </article>

            <img class="img-2" src="../media/images/produits/3.png" width="250" height="250" alt="">
            <img class="img-1" src="../media/images/produits/1.png" width="250" height="250" alt="">
            <img class="img-3" src="../media/images/produits/4.png" width="250" height="250" alt="">
        </section>
    </main>
</body>
</html>