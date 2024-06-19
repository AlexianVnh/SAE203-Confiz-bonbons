<?php
include_once("db.php"); // import des données de la base et initialisation de la session

// try to connect with the server using the database connection information defined in db.php
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

/**
 * Ajouter un compte utilisateur.
 *
 * @param string $username Nom d'utilisateur.
 * @param string $prenom Prénom de l'utilisateur.
 * @param string $nom Nom de l'utilisateur.
 * @param string $email Adresse email de l'utilisateur.
 * @param string $ddn Date de naissance de l'utilisateur.
 * @param string $role Rôle de l'utilisateur.
 * @param string $mot_de_passe Mot de passe de l'utilisateur.
 * @return string Message de succès ou d'erreur.
 */
function add_account($username, $prenom, $nom, $email, $ddn, $role, $mot_de_passe) {
    global $PDO;

    // Vérifiez si l'utilisateur existe déjà par username ou email
    $sql_check = "SELECT COUNT(*) FROM utilisateurs WHERE username = :username OR email = :email";
    $stmt_check = $PDO->prepare($sql_check);
    $stmt_check->bindParam(':username', $username);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();

    if ($stmt_check->fetchColumn() > 0) {
        return "Erreur : L'utilisateur avec ce nom d'utilisateur ou cet email existe déjà.";
    } else {
        $hashedPassword = md5($mot_de_passe);

        // Insérer le nouvel utilisateur
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
    
        if ($stmt->execute()) {
            return "Utilisateur ajouté avec succès.";
        } else {
            return "Erreur lors de l'ajout de l'utilisateur.";
        }
    }
}

/**
 * Vérifier si un compte peut se connecter.
 *
 * @param string $username Nom d'utilisateur.
 * @param string $role Rôle de l'utilisateur.
 * @param string $mot_de_passe Mot de passe de l'utilisateur.
 * @return bool True si l'utilisateur peut se connecter, false sinon.
 */
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

/**
 * Obtenir l'ID utilisateur par nom d'utilisateur.
 *
 * @param string $username Nom d'utilisateur.
 * @return array Tableau associatif contenant l'ID utilisateur.
 */
function get_id_user_by_username($username) {
    global $PDO;
    $sql = "SELECT id FROM utilisateurs WHERE username = :username";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtenir les ID des utilisateurs gérants ou administrateurs.
 *
 * @return array Tableau associatif contenant les ID des utilisateurs.
 */
function get_id_user_gerant() {
    global $PDO;
    $sql = "SELECT id FROM utilisateurs WHERE role = 'gerant' OR role = 'admin'";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtenir les informations des utilisateurs gérants ou administrateurs.
 *
 * @return array Tableau associatif contenant les ID des utilisateurs.
 */
function get_user_gerant() {
    global $PDO;
    $sql = "SELECT * FROM utilisateurs WHERE role = 'gerant' OR role = 'admin'";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtenir la liste des boutiques.
 *
 * @return array Tableau associatif contenant les informations des boutiques.
 */
function get_shop() {
    global $PDO;
    $sql = "SELECT * FROM boutiques";
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtenir une boutique par ID.
 *
 * @param int $id ID de la boutique.
 * @return array Tableau associatif contenant les informations de la boutique.
 */
function get_shop_by_id($id) {
    global $PDO;
    $sql = "SELECT * FROM boutiques WHERE id = :id";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Ajouter une nouvelle boutique.
 *
 * @param string $nom_boutique Nom de la boutique.
 * @param int $id_gerant ID du gérant de la boutique.
 * @param int $numero_rue Numéro de rue de la boutique.
 * @param string $nom_rue Nom de la rue de la boutique.
 * @param string $code_postal Code postal de la boutique.
 * @param string $ville Ville de la boutique.
 * @param string $pays Pays de la boutique.
 * @return bool True si la boutique est ajoutée avec succès, false sinon.
 */
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

/**
 * Supprimer une boutique par ID.
 *
 * @param int $id_boutique ID de la boutique à supprimer.
 * @return bool True si la boutique est supprimée avec succès, false sinon.
 */
function delete_shop($id_boutique) {
    global $PDO;

    $sql = "DELETE FROM boutiques WHERE id = :id";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id_boutique);
    $stmt->execute();

    return true;
}

/**
 * Obtenir la liste des produits.
 *
 * @return array Tableau associatif contenant les informations des produits.
 */
function get_product() { 
    global $PDO;

    $sql = "SELECT * FROM confiseries";

    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtenir un produit par ID.
 *
 * @param int $id_produit ID du produit.
 * @return array Tableau associatif contenant les informations du produit.
 */
function get_product_by_id($id_produit) { 
    global $PDO;

    $sql = "SELECT * FROM confiseries WHERE id = :id";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id_produit);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtenir les types de produits distincts.
 *
 * @return array Tableau associatif contenant les types de produits.
 */
function get_product_type() {
    global $PDO;

    $sql = "SELECT DISTINCT type FROM confiseries";

    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Ajouter un produit.
 *
 * @param string $nom_produit Nom du produit.
 * @param string $type_produit Type du produit.
 * @param float $prix_produit Prix du produit.
 * @param string $illustration_produit URL de l'illustration du produit.
 * @param string $description_produit Description du produit.
 * @return bool True si le produit est ajouté avec succès, false sinon.
 */
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

/**
 * Ajouter un produit à une boutique.
 *
 * @param int $id_produit ID du produit.
 * @param int $id_boutique ID de la boutique.
 * @param int $quantite Quantité du produit à ajouter.
 * @return bool True si le produit est ajouté avec succès, false sinon.
 */
function add_product_to_shop($id_produit, $id_boutique, $quantite) {
    global $PDO;

    // Vérifiez si le produit existe déjà dans le stock de la boutique
    $sql_check = "SELECT * FROM stocks WHERE confiserie_id = :id_produit AND boutique_id = :id_boutique";
    $stmt_check = $PDO->prepare($sql_check);
    $stmt_check->bindParam(':id_produit', $id_produit);
    $stmt_check->bindParam(':id_boutique', $id_boutique);
    $stmt_check->execute();
    
    if ($stmt_check->rowCount() > 0) {
        // Le produit existe déjà, on retourne false
        return false;
    } else {
        // Le produit n'existe pas, on l'ajoute
        $sql_insert = "INSERT INTO stocks (quantite, confiserie_id, boutique_id) VALUES (:quantite, :id_produit, :id_boutique)";
        $stmt_insert = $PDO->prepare($sql_insert);
        $stmt_insert->bindParam(':quantite', $quantite);
        $stmt_insert->bindParam(':id_produit', $id_produit);
        $stmt_insert->bindParam(':id_boutique', $id_boutique);
        $stmt_insert->execute();
        
        return true;
    }
}

/**
 * Supprimer un produit par ID.
 *
 * @param int $id_produit ID du produit à supprimer.
 * @return bool True si le produit est supprimé avec succès, false sinon.
 */
function delete_product($id_produit) {
    global $PDO;

    $sql = "DELETE FROM confiseries WHERE id = :id";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $id_produit);
    $stmt->execute();

    return true;
}

/**
 * Obtenir la liste de tous les produits.
 *
 * @return array Tableau associatif contenant les informations de tous les produits.
 */
function get_all_products() {
    global $PDO;

    $sql = "SELECT * FROM confiseries";
    
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Obtenir les produits et leur stock pour une boutique.
 *
 * @param int $id_boutique ID de la boutique.
 * @return array Tableau associatif contenant les informations des produits et leur stock.
 */
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

/**
 * Obtenir le stock d'un produit par ID de boutique et ID de produit.
 *
 * @param int $id_boutique ID de la boutique.
 * @param int $id_produit ID du produit.
 * @return int Quantité du produit en stock.
 */
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

/**
 * Ajuster la quantité d'un produit.
 *
 * @param string $action Action à réaliser (valider).
 * @param int $id_produit ID du produit.
 */
function ajust_product_qty($action, $id_produit) {
    $confiserie = get_product_by_id($id_produit);
    
    if ($action == 'valider') {
        $quantite_finale = intval($_POST['quantite']);
        $_SESSION['quantite_' . $id_produit] = $quantite_finale;
        update_product_qty($quantite_finale, $id_produit);
    }
}

/**
 * Mettre à jour la quantité d'un produit.
 *
 * @param int $quantite_finale Quantité finale du produit.
 * @param int $id_produit ID du produit.
 */
function update_product_qty($quantite_finale, $id_produit) {
    global $PDO;

    $sql = "UPDATE stocks SET quantite = :quantite WHERE id = :id_produit";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':quantite', $quantite_finale);
    $stmt->bindParam(':id_produit', $id_produit);

    if ($stmt->execute()) {
        $_SESSION['feedback_messages'][$id_produit] = "Quantité mise à jour";
    } else {
        $_SESSION['feedback_messages'][$id_produit] = "Erreur lors de la mise à jour de la quantité";
    }
}


/**
 * Changer le rôle d'un utilisateur.
 *
 * @param int $id_utilisateur ID de l'utilisateur.
 * @param string $role_utilisateur rôle de l'utilisateur.
 * @return bool True si le changement est fait avec succès, false sinon.
 */
function change_role($id_utilisateur, $role_utilisateur) {
    global $PDO;

    // Vérifier d'abord si le rôle à modifier est différent du rôle actuel dans la base de données
    $sql_check = "SELECT role FROM utilisateurs WHERE id = :id_utilisateur";
    $stmt_check = $PDO->prepare($sql_check);
    $stmt_check->bindParam(':id_utilisateur', $id_utilisateur);
    $stmt_check->execute();
    $current_role = $stmt_check->fetchColumn();

    if ($current_role === $role_utilisateur) {
        return false;
    }

    // Sinon, procéder à la mise à jour du rôle
    $sql_update = "UPDATE utilisateurs SET role = :role WHERE id = :id_utilisateur";
    $stmt = $PDO->prepare($sql_update);
    $stmt->bindParam(':role', $role_utilisateur);
    $stmt->bindParam(':id_utilisateur', $id_utilisateur);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

?>