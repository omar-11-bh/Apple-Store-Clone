# 📊 Documentation Technique - Système de Panier Apple Store

## Architecture du système

```
┌─────────────────────────────────────────────────────────────┐
│                    CLIENT (Navigateur)                       │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ Pages HTML (index, Iphone, MacBook, etc.)           │   │
│  │ - Boutons "Commander"                               │   │
│  │ - Classe .order                                      │   │
│  └──────────────────────────────────────────────────────┘   │
│                          ↓ (click)                            │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ panier.js (JavaScript)                              │   │
│  │ - Capture les clics                                │   │
│  │ - Gère localStorage                                 │   │
│  │ - Affiche notifications                             │   │
│  └──────────────────────────────────────────────────────┘   │
│                          ↓                                    │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ localStorage (Navigateur)                            │   │
│  │ - Clé: "panier"                                     │   │
│  │ - Format: JSON array d'objets produits             │   │
│  └──────────────────────────────────────────────────────┘   │
│                          ↓ (affichage)                       │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ panier.html                                          │   │
│  │ - Affiche les produits                             │   │
│  │ - Permet modification quantités                     │   │
│  │ - Calcule le total                                 │   │
│  └──────────────────────────────────────────────────────┘   │
│                          ↓ (envoi)                           │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ process_order.php (HTTP POST)                        │   │
│  │ - JSON: { items, total }                            │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                               │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    SERVEUR (Apache/PHP)                      │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ process_order.php                                    │   │
│  │ - Reçoit les données JSON                           │   │
│  │ - Valide les données                                │   │
│  │ - Prépare les requêtes SQL                          │   │
│  └──────────────────────────────────────────────────────┘   │
│                          ↓                                    │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ Création automatique BD (si n'existe pas)            │   │
│  │ - CREATE DATABASE apple_store                       │   │
│  │ - CREATE TABLE orders                               │   │
│  │ - CREATE TABLE order_items                          │   │
│  └──────────────────────────────────────────────────────┘   │
│                          ↓                                    │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ MySQL                                               │   │
│  │ - Database: apple_store                            │   │
│  │ - Table: orders                                     │   │
│  │ - Table: order_items                                │   │
│  └──────────────────────────────────────────────────────┘   │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

## Flux de données

### 1. Ajout au panier

```
Utilisateur clique "Commander"
          ↓
JavaScript capture le clic (.order button)
          ↓
Extrait les données du produit:
- Nom (articles-categorie)
- Prix (price)
          ↓
Crée objet produit:
{
  name: "iPhone 17",
  price: 969.00,
  quantity: 1
}
          ↓
Cherche si produit existe déjà dans localStorage
          ↓
- OUI: quantité += 1
- NON: ajoute nouveau produit
          ↓
Sauvegarde dans localStorage["panier"]
          ↓
Affiche notification de succès
```

### 2. Validation de commande

```
Utilisateur clique "Procéder au paiement"
          ↓
JavaScript récupère le panier depuis localStorage
          ↓
Calcule le total:
- Sous-total = somme(prix × quantité)
- Frais port = 5.00€
- Total = Sous-total + Frais port
          ↓
Prépare JSON:
{
  items: [...],
  total: 1234.56
}
          ↓
Envoie en POST à process_order.php
          ↓
```

### 3. Traitement serveur

```
process_order.php reçoit la requête
          ↓
Décode le JSON
          ↓
Valide les données:
- Panier pas vide?
- Total présent?
- Prix valides?
          ↓
Connexion MySQL
          ↓
Crée BD si n'existe pas
          ↓
INSERT INTO orders:
- order_date: NOW()
- total_amount: 1234.56
- order_status: 'Pending'
          ↓
Récupère order_id
          ↓
Boucle sur chaque article:
  INSERT INTO order_items
  - order_id: 1
  - product_name: "iPhone 17"
  - product_price: 969.00
  - quantity: 1
  - item_total: 969.00
          ↓
Retourne JSON avec succès
          ↓
JavaScript vide le localStorage
          ↓
Affiche "Commande réussie - ID: #1"
```

## Structures de données

### localStorage['panier']

```javascript
[
  {
    name: "iPhone 17",
    price: 969.00,
    quantity: 2
  },
  {
    name: "MacBook Air 13",
    price: 1099.00,
    quantity: 1
  }
]
```

### Table `orders`

```
id              INT PRIMARY KEY AUTO_INCREMENT
order_date      DATETIME
total_amount    DECIMAL(10,2)
order_status    VARCHAR(50)
created_at      TIMESTAMP
```

### Table `order_items`

```
id              INT PRIMARY KEY AUTO_INCREMENT
order_id        INT (FK to orders.id)
product_name    VARCHAR(255)
product_price   DECIMAL(10,2)
quantity        INT
item_total      DECIMAL(10,2)
```

## Classe Panier (JavaScript)

### Méthodes principales

```javascript
// Initialisation
const panier = new Panier();

// Ajouter un produit
panier.addItem({
  name: "iPhone 17",
  price: 969.00
});

// Supprimer un produit
panier.removeItem("iPhone 17");

// Modifier la quantité
panier.updateQuantity("iPhone 17", 3);

// Vider le panier
panier.clear();

// Obtenir le total
const total = panier.getTotal(); // 1938.00
```

## Endpoints PHP

### POST /process_order.php

**Entrée:**
```json
{
  "items": [
    {"name": "iPhone 17", "price": 969.00, "quantity": 2}
  ],
  "total": 1938.00
}
```

**Sortie (succès):**
```json
{
  "success": true,
  "message": "Commande créée avec succès",
  "order_id": 1,
  "total": "1 938,00"
}
```

**Sortie (erreur):**
```json
{
  "success": false,
  "message": "Panier vide"
}
```

### GET /admin.php

Affiche la page d'administration avec :
- Statistiques des commandes
- Liste des commandes
- Modal pour voir les détails

### GET /get_order_details.php?id=1

**Sortie:**
```json
{
  "success": true,
  "order": {
    "id": "1",
    "order_date": "22/11/2025 14:30",
    "total_amount": "1 938,00 €",
    "order_status": "Pending"
  },
  "items": [
    {
      "product_name": "iPhone 17",
      "product_price": "969,00",
      "quantity": "2",
      "item_total": "1 938,00"
    }
  ]
}
```

### GET /export_orders.php

Télécharge un fichier CSV avec toutes les commandes.

## Sécurité

### Implémenté

✅ **Validation côté serveur**
- Vérification que panier n'est pas vide
- Vérification que total est présent
- Type casting des variables

✅ **Sanitization**
- htmlspecialchars() pour éviter XSS
- stripslashes() pour éviter les échappements doubles
- trim() pour supprimer les espaces inutiles

✅ **Requêtes SQL**
- Prepared statements avec bind_param()
- Pas de concaténation SQL directe

✅ **Headers**
- Content-Type corrects
- Pas d'exposition d'erreurs détaillées

### À Ajouter

⚠️ **Authentication**: Créer un système de login
⚠️ **HTTPS**: Utiliser SSL en production
⚠️ **CORS**: Restreindre les domaines autorisés
⚠️ **Rate Limiting**: Limiter les requêtes par IP
⚠️ **Logs**: Enregistrer toutes les commandes

## Performance

### Optimisations actuelles

✅ localStorage pour éviter rechargements réseau
✅ Indexes sur order_id (clé étrangère)
✅ JSON compact
✅ Pas de requêtes N+1

### Suggestions

- Cache des produits en sessionStorage
- Compression GZIP
- Minification CSS/JS
- Lazy loading des images

## Configuration personnalisée

### Frais de port

Fichier: `panier.js` (ligne ~138)
```javascript
const shipping = subtotal > 0 ? 5.00 : 0;  // 5€ de frais
```

### Identifiants BD

Fichier: `process_order.php` (lignes 4-7)
```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apple_store";
```

### Statut par défaut

Fichier: `process_order.php` (ligne ~50)
```php
$order_status = 'Pending';  // Nouveau statut
```

## Dépannage

### Problème: "Erreur 500" au checkout

**Solution:**
1. Vérifier que MySQL est lancé
2. Vérifier les identifiants dans process_order.php
3. Vérifier les logs Apache/PHP

### Problème: Panier vide après actualisation

**Normal** - localStorage est local au navigateur.
**Solution:** Utiliser Ctrl+F5 pour forcer le rechargement du cache.

### Problème: "CORS error"

Si le serveur PHP est sur un autre domaine :
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
```

## Améliorations futures

1. **Authentification utilisateur** - Créer des comptes client
2. **Email confirmation** - Envoyer confirmation par mail
3. **Paiement réel** - Intégrer Stripe/PayPal
4. **Stock réel** - Vérifier la disponibilité
5. **Dashboard** - Graphiques des ventes
6. **Notifications** - Push notifications
7. **Analytics** - Tracking des visites
8. **Multilangue** - Support d'autres langues
