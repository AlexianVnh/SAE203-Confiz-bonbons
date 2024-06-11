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




function add_account($username, $role, $mot_de_passe) {
    global $PDO;

    $hashedPassword = md5($mot_de_passe);
    $sql = "INSERT INTO utilisateurs (username, role, password) VALUES (:username, :role, :mot_de_passe)";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':mot_de_passe', $hashedPassword);
    
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



function get_shop() {
    global $PDO;

    $sql = "SELECT * FROM boutiques";

    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Utiliser PDO::FETCH_ASSOC pour obtenir uniquement les clés associatives
}


function get_products_and_their_stock($username, $role) {
    global $PDO;

    if ($role == 'gerant') {
        $sql = "SELECT 
                b.nom_boutique,
                p.id_produit,
                p.nom_produit,
                p.prix_unitaire,
                p.prix_au_kg,
                s.quantite
            FROM 
                utilisateurs u
            JOIN 
                boutiques b ON u.id_user = b.id_user
            JOIN 
                stock s ON b.id_boutique = s.id_boutique
            JOIN 
                produits p ON s.id_produit = p.id_produit
            WHERE 
                u.username = :username";

        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        echo("pas possible");
    }
}


function ajust_product_qty($action, $id_produit) {
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

    $sql = "UPDATE stock SET quantite = :quantite WHERE id_produit = :id_produit";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':quantite', $quantite_finale, PDO::PARAM_INT);
    $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "La quantité du produit a été mise à jour avec succès.";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Erreur lors de la mise à jour de la quantité du produit : " . $errorInfo[2];
    }
}
?>