<?php
// export_orders.php - Exporter les commandes en CSV

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(array("success" => false, "message" => "Méthode non autorisée"));
    exit();
}

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

// Récupérer toutes les commandes avec les articles
$sql = "SELECT o.id, o.order_date, o.total_amount, o.order_status, 
               oi.product_name, oi.product_price, oi.quantity, oi.item_total
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(array("success" => false, "message" => "Erreur de requête: " . $conn->error));
    exit();
}

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(array("success" => false, "message" => "Aucune commande à exporter"));
    exit();
}

// Préparer le CSV
$csv = "ID Commande,Date,Produit,Prix,Quantité,Montant Article,Montant Total,Statut\n";

$current_order_id = null;

while ($row = $result->fetch_assoc()) {
    $order_id = $row['id'];
    $date = date('d/m/Y H:i', strtotime($row['order_date']));
    $product = $row['product_name'] ?? 'N/A';
    $price = number_format($row['product_price'] ?? 0, 2, ',', ' ');
    $quantity = $row['quantity'] ?? 0;
    $item_total = number_format($row['item_total'] ?? 0, 2, ',', ' ');
    $total = number_format($row['total_amount'], 2, ',', ' ');
    $status = $row['order_status'];
    
    $csv .= "\"$order_id\",\"$date\",\"$product\",\"$price€\",\"$quantity\",\"$item_total€\",\"$total€\",\"$status\"\n";
}

$conn->close();

// Envoyer le CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="commandes_apple_store_' . date('Y-m-d_H-i-s') . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');

echo "\xEF\xBB\xBF"; // BOM UTF-8 pour Excel
echo $csv;
exit();
?>
