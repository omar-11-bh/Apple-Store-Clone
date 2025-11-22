# ⚡ Démarrage Rapide - 5 minutes

> Pour les utilisateurs impatients qui veulent commencer tout de suite !

## 🎯 Objectif
Avoir un panier fonctionnel avec sauvegarde en base de données en 5 minutes.

## ⏰ Prérequis (2 min)

Téléchargez et installez UN des deux :

### Option 1 : XAMPP (Recommandé Windows)
1. Aller sur https://www.apachefriends.org/
2. Télécharger XAMPP
3. Installer dans `C:\xampp`
4. Cocher Apache et MySQL
5. Cliquer "Start"

### Option 2 : WAMP (Alternative Windows)
1. Aller sur https://www.wampserver.com/
2. Télécharger WAMP
3. Installer
4. Clic droit icône → All Services → Start

## 📁 Installation du projet (2 min)

### XAMPP
```
1. Copier le dossier projet_Omar_Apple_Store_Clone
2. Coller dans C:\xampp\htdocs\
```

### WAMP
```
1. Copier le dossier projet_Omar_Apple_Store_Clone
2. Coller dans C:\wamp64\www\
```

## 🌐 Accéder au site (1 min)

Ouvrir votre navigateur et aller à :

```
http://localhost/projet_Omar_Apple_Store_Clone/
```

✅ **Ça marche !**

## 🛒 Test du panier (pas même 1 min)

1. **Cliquer** sur un produit (iPhone, MacBook, etc.)
2. **Cliquer** sur "Commander"
3. **Notification** de succès apparaît ✅
4. **Cliquer** sur "MON PANIER" en haut
5. **Voir** le produit dans le panier ✅
6. **Cliquer** "Procéder au paiement"
7. **Message** "Commande créée - ID: #1" ✅

## 📊 Vérifier la base de données

Ouvrir : `http://localhost/phpmyadmin`

**Identifiant :**
- Utilisateur : `root`
- Mot de passe : (laisser vide)

**Chercher :**
- Base de données : `apple_store`
- Tables : `orders` et `order_items`

## 👨‍💼 Voir les commandes

Ouvrir : `http://localhost/projet_Omar_Apple_Store_Clone/admin.php`

Vous verrez :
- ✅ Nombre total de commandes
- ✅ Montant total des ventes
- ✅ Panier moyen
- ✅ Liste de toutes les commandes
- ✅ Cliquer sur une commande pour détails

## 📥 Exporter en Excel

Ouvrir : `http://localhost/projet_Omar_Apple_Store_Clone/export_orders.php`

Un fichier CSV s'ouvre dans Excel avec :
- ID commande
- Date
- Produits
- Prix
- Quantités
- Totaux

## 🎓 Prochaines étapes

### 📚 Lire la documentation
```
- README.md      : Guide complet
- SETUP.md       : Installation détaillée
- TECHNICAL_DOC  : Architecture technique
```

### 🔧 Personnaliser les prix

Ouvrir les fichiers HTML et modifier :
```html
<div class="price">969,00 €</div>  ← Modifier ici
```

### 🎨 Changer les couleurs

Ouvrir `style.css` et modifier :
```css
background-color: black;  ← Modifier la couleur
```

### 💾 Changer les frais de port

Ouvrir `panier.js` et modifier :
```javascript
const shipping = subtotal > 0 ? 5.00 : 0;  ← Modifier 5.00
```

## ❌ Erreurs courantes

### "Erreur de connexion" dans le panier
**Solution :** 
- Vérifier que MySQL est lancé (XAMPP/WAMP control panel)
- Attendre 5 secondes
- Relancer la commande

### "404 Not Found"
**Solution :**
- Vérifier le chemin : `C:\xampp\htdocs\projet_Omar_Apple_Store_Clone\`
- Actualiser la page (Ctrl+F5)

### "Le panier reste vide"
**Normal !** Le panier utilise localStorage du navigateur.
**Solution :** C'est prévu, c'est correct ! 👍

### "Les fichiers CSS ne s'affichent pas"
**Solution :**
- F12 → Network → Voir si `style.css` est en rouge
- Si rouge : vérifier que le fichier existe
- Actualiser avec Ctrl+F5

## 📞 Besoin d'aide ?

**Email :** 
- Med Omar : mohammad.omar.ben.hammouda@outlook.com

**Vérifier :**
1. Apache est lancé ✅
2. MySQL est lancé ✅
3. Les fichiers sont au bon endroit ✅
4. Le navigateur n'a pas d'erreur (F12) ✅

## 🚀 Ça marche ! 🎉

Vous avez maintenant un système de panier complet avec :
- ✅ Ajout de produits
- ✅ Calcul automatique
- ✅ Base de données MySQL
- ✅ Dashboard administrateur
- ✅ Export des commandes

**Prochaine étape :** Lire le README.md pour les fonctionnalités avancées !
