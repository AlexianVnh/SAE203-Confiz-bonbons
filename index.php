<?php
include_once("header.php");
?>

<!DOCTYPE html>
<body>
    <section class="herobanner">
        <article class="herobanner-content w-70">
            <h1 class="paytone-one p-60">Bienvenue chez Confiz !</h1>
            <p class="paytone-one p-30">Amuz toi bien et profite des nombreuses boutiques</p>
            <a href="#produits-starz">Je craque !</a>
        </article>
    </section>


    <?php
        /* Récupération de tous les produits pour le caroussel */
        $confiseries = get_product();          
    ?>


    <section class="produit-starz" id="produits-starz">
        <article class="produit-starz-content w-70 padding-50y">
            <div>
                <h1 class="paytone-one p-60">Nos produits starz</h1>
                <img src="media/images/etoile.png" width="130" height="130" alt="décoration">
                <img src="media/images/etoile.png" width="130" height="130" alt="décoration" style="transform: rotate(35deg)">
            </div>
            <div class="produit-en-avant">
                <div class="image-produit-en-avant">
                    <img id="main-product-img" src="media/images/produits/<?= $confiseries[0]['illustration'] ?>" width="500" height="500" alt="">
                    <p class="p-30" id="main-product-price"><?= $confiseries[0]['prix'] ?> €</p>
                </div>
                <div class="texte-produit-en-avant">
                    <h1 class="paytone-one p-60" id="main-product-name"><?= $confiseries[0]['nom'] ?></h1>
                    <a href="<?= CHEMIN_URL_SERVER ?>boutiques.php" class="p-26 underline">Découvrez ce produit star</a>
                </div>

                <div class="autres-produit">
                    <div id="product-previews">
                        <?php for ($i = 1; $i <= 3; $i++) : ?>
                            <a href="">
                                <img src="media/images/produits/<?= $confiseries[$i]['illustration'] ?>" width="150" height="150" alt="">
                            </a>
                        <?php endfor; ?>
                    </div>    

                    <div class="fleches-caroussel">
                        <a class="fleches-cercle" id="prev-btn"><span class="fleches-carre fleche1"></span></a>
                        <a class="fleches-cercle" id="next-btn"><span class="fleches-carre fleche2"></span></a>
                    </div>
                </div>
            </div>
        </article>
    </section>

    <section class="histoire-confiz" id="notre_histoire">
        <article class="histoire-confiz-content w-70 padding-50y">
            <div class="histoire-texte">
                <h1 class="paytone-one p-60">Notre histoire</h1>
                <p class="p-20">
                    Nous sommes une société de confiserie crée en 2012,
                    vous proposant une centrale d'achat de confiseries fiable et 
                    sans sucroût. Camarade de Jack Dermitt, héritier de la
                    société allemande "Haribo", il choisit d'exploiser le 
                    catalogue produit de la société de son ami pour offir au 
                    réseau de magasins franchisés qu'il a construit, la possibilité
                    de gérer leur réapprovisionnement très simplement : en ligne !
                </p>
            </div>
            <img src="media/images/logo_confiz.png" width="auto" height="auto" alt="logo de l'entreprise sur Confiz">
        </article>
    </section>

    <section class="avantages-confiz padding-50y">
        <div class="avantages-confiz-slider">
            <article>
                <i class="fa-solid fa-truck-fast"></i>
                <p>Livraison <b>rapide</b> en moins de <b>3 jours</b></p>
            </article>
            <article>
                <i class="fa-solid fa-heart"></i>
                <p>Clients chéris <b>SAV 7/7</b></p>
            </article>
            <article>
                <i class="fa-solid fa-bag-shopping"></i>
                <p>Boutique en ligne de <b>qualité</b></p>
            </article>
            <article>
                <i class="fa-solid fa-star"></i>
                <p>Note de <b>4,6</b> en moyenne</p>
            </article>
            <article>
                <i class="fa-regular fa-face-smile-wink"></i>
                <p>Sans <b>édulcorants</b></p>
            </article>
            <article>
                <i class="fa-solid fa-candy-cane"></i>
                <p>Plus de <b>50</b> produits différents</p>
            </article>
            <article>
                <i class="fa-solid fa-truck-fast"></i>
                <p>Livraison <b>rapide</b> en moins de <b>3 jours</b></p>
            </article>
            <article>
                <i class="fa-solid fa-heart"></i>
                <p>Clients chéris <b>SAV 7/7</b></p>
            </article>
            <article>
                <i class="fa-solid fa-bag-shopping"></i>
                <p>Boutique en ligne de <b>qualité</b></p>
            </article>
            <article>
                <i class="fa-solid fa-star"></i>
                <p>Note de <b>4,6</b> en moyenne</p>
            </article>
            <article>
                <i class="fa-regular fa-face-smile-wink"></i>
                <p>Sans <b>édulcorants</b></p>
            </article>
            <article>
                <i class="fa-solid fa-candy-cane"></i>
                <p>Plus de <b>50</b> produits différents</p>
            </article>
        </div>
    </section>
</body>
</html>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            const confiseries = <?php echo json_encode($confiseries); ?>;
            
            const mainProductImg = document.getElementById('main-product-img');
            const mainProductPrice = document.getElementById('main-product-price');
            const mainProductName = document.getElementById('main-product-name');
            const productPreviews = document.querySelectorAll('#product-previews a img');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            const productsCount = confiseries.length; // Nombre de produits
            let currentIndex = 0;

            function updateMainProduct(index) {
                mainProductImg.src = `media/images/produits/${confiseries[index]['id']}.png`;
                mainProductPrice.innerText = `${confiseries[index]['prix']} €`;
                mainProductName.innerText = confiseries[index]['nom'];
            }

            function updatePreviews() {
                const previewIndices = [1, 2, 3].map(i => (currentIndex + i) % productsCount);
                productPreviews.forEach((preview, i) => {
                    preview.src = `media/images/produits/${confiseries[previewIndices[i]]['id']}.png`;
                });
            }

            function nextProduct() {
                currentIndex = (currentIndex + 1) % productsCount;
                updateMainProduct(currentIndex);
                updatePreviews();
            }

            function prevProduct() {
                currentIndex = (currentIndex - 1 + productsCount) % productsCount;
                updateMainProduct(currentIndex);
                updatePreviews();
            }

            // Event Listeners
            nextBtn.addEventListener('click', nextProduct);
            prevBtn.addEventListener('click', prevProduct);

            // Auto-update every 5 seconds
            setInterval(nextProduct, 5000);

            // Initial Update
            updateMainProduct(currentIndex);
            updatePreviews();
        });
    </script>

<?php
include_once("footer.php");
?>