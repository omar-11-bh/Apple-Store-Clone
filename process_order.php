<?php
header('Content-Type: application/json');

// Configuration de la base de données
$servername = "localhost";
$username = "root"; // À adapter selon votre configuration
$password = ""; // À adapter selon votre configuration
$dbname = "apple_store"; // À créer ou adapter

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    // Si la base de données n'existe pas, la créer
    $conn = new mysqli($servername, $username, $password);
    
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(array("success" => false, "message" => "Erreur de connexion: " . $conn->connect_error));
        exit();
    }
    
    // Créer la base de données
    $sql = "CREATE DATABASE IF NOT EXISTS apple_store";
    if ($conn->query($sql) !== TRUE) {
        http_response_code(500);
        echo json_encode(array("success" => false, "message" => "Erreur lors de la création de la base de données"));
        exit();
    }
    
    // Sélectionner la base de données
    $conn->select_db("apple_store");
    
    // Créer les tables
    createTables($conn);
}

// Créer les tables si elles n'existent pas
createTables($conn);

// Récupérer les données JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data === null) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Données invalides"));
    exit();
}

// Valider les données
if (!isset($data['items']) || !is_array($data['items']) || empty($data['items'])) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Panier vide"));
    exit();
}

if (!isset($data['total'])) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Montant total manquant"));
    exit();
}

// Préparer les données de la commande
$order_date = date('Y-m-d H:i:s');
$total_amount = floatval($data['total']);
$order_status = 'Pending';

// Insérer la commande
$sql = "INSERT INTO orders (order_date, total_amount, order_status) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "Erreur de préparation: " . $conn->error));
    exit();
}

$stmt->bind_param("sds", $order_date, $total_amount, $order_status);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "Erreur lors de l'insertion de la commande: " . $stmt->error));
    exit();
}

$order_id = $stmt->insert_id;
$stmt->close();

// Insérer les articles de la commande
$sql = "INSERT INTO order_items (order_id, product_name, product_price, quantity, item_total) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "Erreur de préparation: " . $conn->error));
    exit();
}

foreach ($data['items'] as $item) {
    $product_name = sanitizeInput($item['name']);
    $product_price = floatval($item['price']);
    $quantity = intval($item['quantity']);
    $item_total = $product_price * $quantity;
    
    $stmt->bind_param("isdi", $order_id, $product_name, $product_price, $quantity);
    $stmt->add_bind_value("d", $item_total);
    
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(array("success" => false, "message" => "Erreur lors de l'insertion des articles: " . $stmt->error));
        $stmt->close();
        exit();
    }
}

$stmt->close();
$conn->close();

// Répondre avec succès
http_response_code(200);
echo json_encode(array(
    "success" => true, 
    "message" => "Commande créée avec succès",
    "order_id" => $order_id,
    "total" => number_format($total_amount, 2, ',', ' ')
));

// Fonction pour créer les tables
function createTables($conn) {
    // Table des commandes
    $sql_orders = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_date DATETIME NOT NULL,
        total_amount DECIMAL(10, 2) NOT NULL,
        order_status VARCHAR(50) NOT NULL DEFAULT 'Pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql_orders) !== TRUE) {
        http_response_code(500);
        echo json_encode(array("success" => false, "message" => "Erreur lors de la création de la table orders"));
        exit();
    }
    
    // Table des articles de commande
    $sql_items = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        product_price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        item_total DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    )";
    
    if ($conn->query($sql_items) !== TRUE) {
        http_response_code(500);
        echo json_encode(array("success" => false, "message" => "Erreur lors de la création de la table order_items"));
        exit();
    }
}

// Fonction pour sécuriser les entrées
function sanitizeInput($input) {
    return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, 'UTF-8');
}
?>
