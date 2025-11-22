# 🚀 Guide d'Installation Rapide - Apple Store Panier

## Étape 1 : Configuration de l'environnement

### Windows avec XAMPP (Recommandé)

1. **Télécharger XAMPP** : https://www.apachefriends.org/
2. **Installer XAMPP** dans `C:\xampp`
3. **Lancer le panneau de contrôle XAMPP**
4. **Démarrer Apache et MySQL** (cliquer sur "Start")

### Windows avec WAMP

1. **Télécharger WAMP** : https://www.wampserver.com/
2. **Installer WAMP**
3. **Clic droit sur l'icône WAMP** → All Services → Start All Services

## Étape 2 : Placer les fichiers

Copier tous les fichiers du projet dans :
- **XAMPP** : `C:\xampp\htdocs\projet_Omar_Apple_Store_Clone\`
- **WAMP** : `C:\wamp64\www\projet_Omar_Apple_Store_Clone\`

Structure attendue :
```
projet_Omar_Apple_Store_Clone/
├── index.html
├── panier.html
├── Iphone.html
├── MacBook.html
├── AppleWatch.html
├── AirPods.html
├── credit.html
├── style.css
├── panier.js
├── process_order.php
├── admin.php
├── get_order_details.php
├── image/
└── videos/
```

## Étape 3 : Configuration de la base de données

### Option 1 : Automatique (Recommandé)

La base de données est créée automatiquement lors de la première commande !

1. Accéder au site : `http://localhost/projet_Omar_Apple_Store_Clone/`
2. Ajouter un produit au panier
3. Cliquer sur "Procéder au paiement"
4. Les tables sont créées automatiquement ✅

### Option 2 : Manuel (via phpMyAdmin)

1. Ouvrir phpMyAdmin : `http://localhost/phpmyadmin`
2. Identifier avec `root` (pas de mot de passe par défaut)
3. Créer une nouvelle base de données : `apple_store`
4. Importer le fichier SQL (s'il existe)

## Étape 4 : Vérifier l'installation

1. Ouvrir dans le navigateur : `http://localhost/projet_Omar_Apple_Store_Clone/`
2. Vérifier que le site s'affiche correctement
3. Tester l'ajout au panier
4. Accéder au panier : `http://localhost/projet_Omar_Apple_Store_Clone/panier.html`
5. Tester une commande
6. Vérifier l'administration : `http://localhost/projet_Omar_Apple_Store_Clone/admin.php`

## Vérification rapide

| Élément | Vérifier |
|---------|----------|
| **Site principal** | http://localhost/projet_Omar_Apple_Store_Clone/ |
| **Panier** | http://localhost/projet_Omar_Apple_Store_Clone/panier.html |
| **Admin** | http://localhost/projet_Omar_Apple_Store_Clone/admin.php |
| **phpMyAdmin** | http://localhost/phpmyadmin |

## 🔧 Dépannage

### Erreur "Impossible de se connecter"
```php
// Vérifier dans process_order.php
$servername = "localhost";  // OK
$username = "root";         // OK
$password = "";            // OK (vide pour XAMPP/WAMP défaut)
```

### Erreur 404 - Fichiers non trouvés
- Vérifier le chemin : `C:\xampp\htdocs\projet_Omar_Apple_Store_Clone\`
- Redémarrer Apache
- Actualiser la page (Ctrl+F5)

### Le panier reste vide après actualisation
C'est NORMAL ! Les données sont dans `localStorage` du navigateur.
- F12 → Application → localStorage → "panier"

### Erreur de base de données MySQL
```
1. Vérifier que MySQL est démarré (XAMPP/WAMP control panel)
2. Vérifier les identifiants dans process_order.php
3. Vérifier le port (3306)
```

## Commandes utiles

### XAMPP
```powershell
# Démarrer Apache
cd C:\xampp
apache_start.bat

# Démarrer MySQL
mysqld.exe
```

### WAMP
```powershell
# Redémarrer les services
Start-Service wampapache
Start-Service wampmysqld
```

## Ports par défaut
- **Apache** : 80
- **MySQL** : 3306
- **phpMyAdmin** : 80/phpmyadmin

## Accès rapide

```
Site           : http://localhost/projet_Omar_Apple_Store_Clone/
Panier          : http://localhost/projet_Omar_Apple_Store_Clone/panier.html
Admin           : http://localhost/projet_Omar_Apple_Store_Clone/admin.php
phpMyAdmin      : http://localhost/phpmyadmin
```

## Support

En cas de problème :
- Med Omar : mohamed.omar.ben.hammouda@outlook.com

