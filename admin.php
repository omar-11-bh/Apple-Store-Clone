<?php
// admin.php - Page d'administration pour voir les commandes

header('Content-Type: text/html; charset=utf-8');

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apple_store";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

// Récupérer toutes les commandes
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

$orders = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Commandes</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        header {
            background-color: black;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .admin-section {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 0.9em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        .action-btn {
            background-color: #667eea;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s;
        }

        .action-btn:hover {
            background-color: #764ba2;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .modal-title {
            margin-bottom: 20px;
            color: #333;
        }

        .order-detail {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .order-detail strong {
            color: #333;
        }

        .items-list {
            margin-top: 20px;
            border-top: 2px solid #dee2e6;
            padding-top: 20px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .empty-message {
            text-align: center;
            color: #999;
            padding: 40px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Apple Store - Administration</h1>
        <a href="index.html" style="color: white; text-decoration: none;">← Retour au site</a>
    </header>

    <div class="container">
        <h1>Gestion des Commandes</h1>

        <div class="admin-section">
            <?php
            if (count($orders) > 0) {
                // Calculer les statistiques
                $total_orders = count($orders);
                $total_revenue = 0;
                foreach ($orders as $order) {
                    $total_revenue += $order['total_amount'];
                }

                echo '<div class="stats">';
                echo '<div class="stat-card">';
                echo '<h3>' . $total_orders . '</h3>';
                echo '<p>Commandes totales</p>';
                echo '</div>';

                echo '<div class="stat-card">';
                echo '<h3>' . number_format($total_revenue, 2, ',', ' ') . ' €</h3>';
                echo '<p>Chiffre d\'affaires</p>';
                echo '</div>';

                echo '<div class="stat-card">';
                echo '<h3>' . number_format($total_revenue / $total_orders, 2, ',', '.') . ' €</h3>';
                echo '<p>Panier moyen</p>';
                echo '</div>';
                echo '</div>';

                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>ID Commande</th>';
                echo '<th>Date</th>';
                echo '<th>Montant</th>';
                echo '<th>Statut</th>';
                echo '<th>Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach ($orders as $order) {
                    echo '<tr>';
                    echo '<td>#' . $order['id'] . '</td>';
                    echo '<td>' . date('d/m/Y H:i', strtotime($order['order_date'])) . '</td>';
                    echo '<td>' . number_format($order['total_amount'], 2, ',', ' ') . ' €</td>';
                    echo '<td>' . $order['order_status'] . '</td>';
                    echo '<td><button class="action-btn" onclick="viewOrder(' . $order['id'] . ')">Détails</button></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="empty-message">';
                echo '<i class="fas fa-shopping-cart" style="font-size: 3em; color: #ddd; margin-bottom: 20px;"></i>';
                echo '<p>Aucune commande pour le moment.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="orderDetails"></div>
        </div>
    </div>

    <script>
        function viewOrder(orderId) {
            fetch('get_order_details.php?id=' + orderId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let html = '<h2 class="modal-title">Commande #' + data.order.id + '</h2>';
                        html += '<div class="order-detail"><strong>Date:</strong> ' + data.order.order_date + '</div>';
                        html += '<div class="order-detail"><strong>Montant total:</strong> ' + data.order.total_amount + ' €</div>';
                        html += '<div class="order-detail"><strong>Statut:</strong> ' + data.order.order_status + '</div>';
                        
                        html += '<div class="items-list"><strong>Articles:</strong>';
                        data.items.forEach(item => {
                            html += '<div class="item">';
                            html += '<div>' + item.product_name + ' x ' + item.quantity + '</div>';
                            html += '<div>' + item.item_total + ' €</div>';
                            html += '</div>';
                        });
                        html += '</div>';

                        document.getElementById('orderDetails').innerHTML = html;
                        document.getElementById('detailModal').style.display = 'block';
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }

        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('detailModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
