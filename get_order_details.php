<?php
// get_order_details.php - Récupérer les détails d'une commande

header('Content-Type: application/json');

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apple_store";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "Erreur de connexion: " . $conn->connect_error));
    exit();
}

// Vérifier que l'ID de commande est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "ID de commande manquant"));
    exit();
}

$order_id = intval($_GET['id']);

// Récupérer la commande
$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(array("success" => false, "message" => "Commande non trouvée"));
    exit();
}

$order = $result->fetch_assoc();
$stmt->close();

// Récupérer les articles de la commande
$sql = "SELECT * FROM order_items WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$items = array();
while ($row = $result->fetch_assoc()) {
    $items[] = array(
        'product_name' => $row['product_name'],
        'product_price' => number_format($row['product_price'], 2, ',', ' '),
        'quantity' => $row['quantity'],
        'item_total' => number_format($row['item_total'], 2, ',', ' ')
    );
}

$stmt->close();
$conn->close();

// Formater la date
$order['order_date'] = date('d/m/Y H:i', strtotime($order['order_date']));
$order['total_amount'] = number_format($order['total_amount'], 2, ',', ' ') . ' €';

// Répondre avec succès
http_response_code(200);
echo json_encode(array(
    "success" => true,
    "order" => $order,
    "items" => $items
));
?>
