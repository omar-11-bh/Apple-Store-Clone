# Système de Panier Apple Store

⚠️ **AVERTISSEMENT : Projet Éducatif Uniquement**

Ce projet est une **simulation éducative** créée à des fins pédagogiques uniquement. Il n'est **PAS** affilié, autorisé ou endorsé par Apple Inc. Ce site n'est pas un vrai magasin Apple et n'accepte pas de vrais paiements. Il est destiné à l'apprentissage du développement web (HTML, CSS, JavaScript, PHP, MySQL).

---

Ce projet implémente un système complet de panier d'achat pour une boutique Apple avec :
- ✅ Ajout de produits au panier
- ✅ Calcul automatique du total
- ✅ Sauvegarde du panier dans le navigateur (localStorage)
- ✅ Système de commande avec PHP
- ✅ Base de données MySQL pour stocker les commandes
- ✅ Page d'administration pour consulter les commandes

## 📋 Prérequis

- Un serveur Apache avec PHP 7.4+
- MySQL (serveur local ou distant)
- Un navigateur web moderne

## 🚀 Installation

### 1. Configuration du serveur PHP

Assurez-vous que votre serveur PHP est bien installé et configuré avec MySQL.

Sous Windows, vous pouvez utiliser :
- **XAMPP** (Apache + MySQL + PHP)
- **WAMP** (Windows Apache MySQL PHP)
- **Laragon** (Outils PHP modernes)

### 2. Placer les fichiers

Placez tous les fichiers du projet dans le répertoire `htdocs` (XAMPP) ou équivalent :
```
htdocs/
├── index.html
├── Iphone.html
├── MacBook.html
├── AppleWatch.html
├── AirPods.html
├── panier.html
├── style.css
├── panier.js
├── process_order.php
├── admin.php
├── get_order_details.php
└── image/
    └── (vos images)
```

### 3. Démarrer le serveur

**Avec XAMPP :**
1. Ouvrir le panneau de contrôle XAMPP
2. Démarrer Apache et MySQL
3. Accéder à `http://localhost/projet_Omar_Apple_Store_Clone/`

**Avec WAMP :**
1. Clic droit sur l'icône WAMP → Start All Services
2. Accéder à `http://localhost/projet_Omar_Apple_Store_Clone/`

## 📝 Utilisation

### Pour les clients

1. **Naviguer sur le site** : Les clients accèdent à `index.html`
2. **Choisir un produit** : Cliquer sur les cartes produits (iPhone, MacBook, etc.)
3. **Ajouter au panier** : Cliquer sur le bouton "Commander"
4. **Voir le panier** : Cliquer sur "MON PANIER" dans le header
5. **Modifier le panier** : 
   - Changer les quantités
   - Supprimer des produits
6. **Valider la commande** : Cliquer sur "Procéder au paiement"

### Pour l'administrateur

Accéder à la page d'administration :
```
http://localhost/projet_Omar_Apple_Store_Clone/admin.php
```

Fonctionnalités :
- Vue d'ensemble des commandes
- Statistiques (nombre de commandes, chiffre d'affaires, panier moyen)
- Détails de chaque commande
- Liste des articles commandés

## 🗂️ Structure des fichiers

| Fichier | Description |
|---------|-------------|
| `index.html` | Page d'accueil |
| `Iphone.html` | Page des produits iPhone |
| `MacBook.html` | Page des produits MacBook |
| `AppleWatch.html` | Page des produits AppleWatch |
| `AirPods.html` | Page des produits AirPods |
| `panier.html` | Page du panier |
| `panier.js` | Logique JavaScript du panier (localStorage) |
| `style.css` | Styles CSS (incluant les styles du panier) |
| `process_order.php` | Traitement des commandes et base de données |
| `admin.php` | Page d'administration |
| `get_order_details.php` | API pour récupérer les détails d'une commande |

## 💾 Base de données

La base de données `apple_store` est créée automatiquement au premier traitement de commande.

**Tables créées :**

### Table `orders`
```sql
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_date DATETIME NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Table `order_items`
```sql
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    item_total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);
```

## 🔧 Configuration PHP

Pour utiliser une base de données distante ou avec des identifiants différents, modifiez les variables en haut de `process_order.php` :

```php
$servername = "localhost";    // Serveur MySQL
$username = "root";           // Utilisateur MySQL
$password = "";              // Mot de passe MySQL
$dbname = "apple_store";     // Nom de la base de données
```

## 🎨 Personnalisation

### Ajouter de nouveaux produits

1. Créer une nouvelle page HTML (ex: `iPad.html`)
2. Copier la structure d'une page produit existante (Iphone.html)
3. Modifier les noms et prix des produits
4. Ajouter les balises div avec `class="order"` pour les boutons "Commander"
5. Ajouter un lien vers cette page dans `index.html`

### Modifier les frais de port

Dans `panier.js`, ligne de la variable `shipping` :
```javascript
const shipping = subtotal > 0 ? 5.00 : 0;  // Modifier 5.00
```

### Changer les prix

Les prix sont directement dans les fichiers HTML dans les balises `.price`

## 🐛 Dépannage

### "Erreur de connexion" en PHP

- Assurez-vous que MySQL est démarré
- Vérifiez les identifiants dans `process_order.php`
- Vérifiez que le port MySQL est correct (par défaut 3306)

### Le panier est vide après actualisation

C'est normal ! Le panier est stocké dans `localStorage` du navigateur. Videz le cache si problème :
- Ouvrir les outils développeur (F12)
- Application → localStorage → Supprimer l'entrée "panier"

### Les boutons "Commander" ne fonctionnent pas

- Vérifier que `panier.js` est bien lié dans chaque page HTML
- Vérifier la console du navigateur (F12) pour les erreurs JavaScript

## 📧 Support

Pour toute question ou problème :
- Med Omar : mohammad.omar.ben.hammouda@outlook.com

## 📄 Licence

Projet réalisé par Med Omar
