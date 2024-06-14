<?php
include_once("db.php");

//try to connect with the server using the database connection information in defined in constants.php
try {
    $PDO = new PDO(
        DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_DATABASE . ';port=' . DB_PORT,
        DB_USERNAME,
        DB_PASSWORD
    );
} catch (Exception $ex) {
    echo ($ex->getMessage());
    die;
}

function query($sql){
    global $PDO;
    $stmt = $PDO->query($sql);
    return $stmt->fetchAll();
}





function add_account($username, $prenom, $nom, $email, $ddn, $role, $mot_de_passe) {
    global $PDO;

    $hashedPassword = md5($mot_de_passe);
    $sql = "INSERT INTO utilisateurs (username, role, password, email, nom, prenom, ddn) 
    VALUES (:username, :role, :mot_de_passe, :email, :nom, :prenom, :ddn)";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':mot_de_passe', $hashedPassword);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':ddn', $ddn);
    
    $stmt->execute();
    
    return true;
}

function check_login($username, $role, $mot_de_passe) {
    global $PDO;

    $sql = "SELECT * FROM utilisateurs WHERE username = :username AND role = :role";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    
    $result = $stmt->fetch();

    if ($result && $result['password'] === md5($mot_de_passe)) {
        return true;
    } else {
        return false;
    }
}



function get_id_user_by_username($username) {
    global $PDO;
    $sql = "SELECT id FROM utilisateurs WHERE username = ':username'";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_id_user_gerant() {
    global $PDO;
    $sql = "SELECT id FROM utilisateurs WHERE role = 'gerant' OR role = 'admin'";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




function get_shop() {
    global $PDO;
    $sql = "SELECT * FROM boutiques";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Utiliser PDO::FETCH_ASSOC pour obtenir uniquement les clés associatives
}
function get_shop_by_id($id) {
    global $PDO;
    $sql = "SELECT * FROM boutiques WHERE id = :id";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Utiliser PDO::FETCH_ASSOC pour obtenir uniquement les clés associatives
}

function add_shop($nom_boutique, $id_gerant, $numero_rue, $nom_rue, $code_postal, $ville, $pays) {
    global $PDO;

    $sql = "INSERT INTO boutiques (nom, utilisateur_id, numero_rue, nom_adresse, code_postal, ville, pays)
    VALUES (:nom, :id, :numero, :nom_rue, :code_postal, :ville, :pays)";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':nom', $nom_boutique);
    $stmt->bindParam(':id', $id_gerant);
    $stmt->bindParam(':numero', $numero_rue);
    $stmt->bindParam(':nom_rue', $nom_rue);
    $stmt->bindParam(':code_postal', $code_postal);
    $stmt->bindParam(':ville', $ville);
    $stmt->bindParam(':pays', $pays);
    
    $stmt->execute();

    echo("Boutique ajoutée !");

    return true;
}

function delete_shop($id_boutique) {
    global $PDO;

    $sql = "DELETE FROM boutiques WHERE id = :id";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id_boutique);
    $stmt->execute();

    return true;
}





function get_product() { 
    global $PDO;

    $sql = "SELECT * FROM confiseries";

    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_product_by_id($id_produit) { 
    global $PDO;

    $sql = "SELECT * FROM confiseries WHERE id = :id";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id_produit);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_product_type() {
    global $PDO;

    $sql = "SELECT DISTINCT type FROM confiseries";

    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function add_product($nom_produit, $type_produit, $prix_produit, $illustration_produit, $description_produit) {
    global $PDO;

    $sql = "INSERT INTO confiseries (nom, type, prix, illustration, description)
    VALUES (:nom, :type, :prix, :illustration, :description)";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':nom', $nom_produit);
    $stmt->bindParam(':type', $type_produit);
    $stmt->bindParam(':prix', $prix_produit);
    $stmt->bindParam(':illustration', $illustration_produit);
    $stmt->bindParam(':description', $description_produit);

    $stmt->execute();

    return true;
}

function delete_product($id_produit) {
    global $PDO;

    $sql = "DELETE FROM confiseries WHERE id = :id";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id_produit);
    $stmt->execute();

    return true;
}

function get_all_products() {
    global $PDO;

    $sql = "SELECT * FROM confiseries";
    
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);;
}

function get_products_and_their_stock($id_boutique) {
    global $PDO;

        $sql = "SELECT 
                b.nom,
                c.id,
                c.nom,
                c.prix,
                c.type,
                c.description,
                c.illustration,
                COALESCE(s.quantite, 0) AS quantite /* remplace null par 0 */
            FROM 
                utilisateurs u
            JOIN 
                boutiques b ON u.id = b.utilisateur_id
            JOIN 
                stocks s ON b.id = s.boutique_id
            JOIN 
                confiseries c ON s.confiserie_id = c.id
            WHERE 
                s.boutique_id = :id_boutique";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id_boutique', $id_boutique);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_stock_by_ids($id_boutique, $id_produit) {
    global $PDO;

    $sql = "SELECT quantite FROM stocks
            WHERE boutique_id LIKE :boutique_id
            AND confiserie_id LIKE :confiserie_id";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':boutique_id', $id_boutique);
    $stmt->bindParam(':confiserie_id', $id_produit);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function ajust_product_qty($action, $id_produit) {
    $confiserie = get_product_by_id($id_produit);
    
    if ($action == 'incrementer') {
        $_SESSION['quantite_' . $id_produit] += 1;
    } elseif ($action == 'decrementer') {
        if ($_SESSION['quantite_' . $id_produit] > 0) {
            $_SESSION['quantite_' . $id_produit] -= 1;
        }
    }
}

function update_product_qty($quantite_finale, $id_produit) {
    global $PDO;

    $sql = "UPDATE stocks SET quantite = :quantite WHERE id = :id_produit";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':quantite', $quantite_finale);
    $stmt->bindParam(':id_produit', $id_produit);

    if ($stmt->execute()) {
        $_SESSION['feedback_quantite'] = "La quantité du produit a été mise à jour avec succès.";
    } else {
        $_SESSION['feedback_quantite'] = "Erreur lors de la mise à jour de la quantité du produit : " . $errorInfo[2];
    }
}
?>