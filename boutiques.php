<?php
include_once("header.php");
?>

<!DOCTYPE html>
<body>
    <section class="herobanner-boutiques">
        <img src="media/images/fond-boutiques.png" width="100%" alt="">
        <article class="herobanner-boutiques-content w-70 padding-50y">
            <h1 class="paytone-one p-60">Nos boutiques</h1>
            <form class="barre-de-recherche">
                <input type="text" id="password" name="password" required>
                <input type="submit" value="Chercher">
            </form>
        </article>
    </section>
    
    <section class="carte-boutiques-container w-70 padding-50y">
        <?php
            $shop = get_shop();
            $indice_image = 1;
            foreach ($shop as $boutique) {
        ?>
        <article class="carte-boutique">
            <img src="media/images/boutiques/<?=$indice_image?>.jpg" width="300" height="300" alt="">
            <?php    
                echo "Nom: " . $boutique['nom'] . "<br>";
                echo "Adresse : " . $boutique['numero_rue'] . " " . $boutique['nom_adresse'] . ", " . $boutique['code_postal'] . ", "  . $boutique['ville'] . ", " . $boutique['pays'] . "<br>";
            ?>
            <button class="boutique-voir-plus">Découvrir leurs produits ></button>
        </article>
        <?php        
            $indice_image++;
            }
        ?>
    </section>
    

</body>
</html>




<?php
include_once("footer.php");
?>