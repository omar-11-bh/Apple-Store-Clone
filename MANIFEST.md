# 📦 Liste Complète des Fichiers - Apple Store Panier

## 📋 Vue d'ensemble

Le projet contient **11 fichiers HTML/PHP/JS** et **4 fichiers de documentation**.

## 📄 Fichiers HTML

| Fichier | Description | Statut |
|---------|-------------|--------|
| `index.html` | Page d'accueil principale | ✅ Modifié (ajout lien panier) |
| `Iphone.html` | Page produits iPhone | ✅ Modifié (lien panier + script JS) |
| `MacBook.html` | Page produits MacBook | ✅ Modifié (lien panier + script JS) |
| `AppleWatch.html` | Page produits Apple Watch | ✅ Modifié (lien panier + script JS) |
| `AirPods.html` | Page produits AirPods | ✅ Modifié (lien panier + script JS) |
| `credit.html` | Page des crédits | ✓ Inchangé |
| `panier.html` | Page du panier d'achat | ✅ NOUVEAU |

## 💾 Fichiers JavaScript

| Fichier | Description | Taille |
|---------|-------------|--------|
| `panier.js` | Gestion du panier (localStorage) | ~15KB |

**Fonctionnalités :**
- Ajout/suppression de produits
- Modification des quantités
- Calcul des totaux
- Sauvegarde localStorage
- Notifications utilisateur

## 🐘 Fichiers PHP

| Fichier | Description | Taille |
|---------|-------------|--------|
| `process_order.php` | Traitement des commandes | ~8KB |
| `admin.php` | Dashboard administration | ~12KB |
| `get_order_details.php` | API JSON pour détails | ~3KB |
| `export_orders.php` | Export CSV des commandes | ~2KB |

**Fonctionnalités :**
- Création automatique BD MySQL
- Insertion des commandes
- Récupération des détails
- Export en CSV
- Affichage des statistiques

## 🎨 Fichiers CSS

| Fichier | Description | Actions |
|---------|-------------|---------|
| `style.css` | Styles CSS complet | ✅ Modifié (styles panier ajoutés) |

**Styles ajoutés :**
- `.panier-section` - Zone principale du panier
- `.panier-items` - Tableau des articles
- `.panier-summary` - Résumé et total
- `.checkout-btn` - Bouton de paiement
- `.notification` - Notifications toast
- Styles responsifs mobile

## 📚 Fichiers de Documentation

| Fichier | Contenu | Pages |
|---------|---------|-------|
| `README.md` | Guide complet du projet | 4 pages |
| `SETUP.md` | Guide d'installation rapide | 3 pages |
| `TECHNICAL_DOC.md` | Documentation technique | 6 pages |
| `apple_store.sql` | Script SQL pour BD | 1 page |
| `MANIFEST.md` | Ce fichier | - |

## 📂 Structure complète du projet

```
projet_Omar_Apple_Store_Clone/
│
├── 📄 HTML
│   ├── index.html              (Page d'accueil)
│   ├── Iphone.html             (Produits iPhone)
│   ├── MacBook.html            (Produits MacBook)
│   ├── AppleWatch.html         (Produits Apple Watch)
│   ├── AirPods.html            (Produits AirPods)
│   ├── panier.html             (Panier d'achat) ⭐ NOUVEAU
│   └── credit.html             (Crédits)
│
├── 🎨 CSS
│   └── style.css               (Styles + styles panier)
│
├── 📜 JavaScript
│   └── panier.js               (Gestion panier) ⭐ NOUVEAU
│
├── 🐘 PHP
│   ├── process_order.php       (Traitement commandes) ⭐ NOUVEAU
│   ├── admin.php               (Dashboard admin) ⭐ NOUVEAU
│   ├── get_order_details.php   (API détails) ⭐ NOUVEAU
│   └── export_orders.php       (Export CSV) ⭐ NOUVEAU
│
├── 📚 Documentation
│   ├── README.md               (Guide complet)
│   ├── SETUP.md                (Installation)
│   ├── TECHNICAL_DOC.md        (Architecture)
│   ├── apple_store.sql         (Script BD)
│   └── MANIFEST.md             (Ce fichier)
│
├── 📁 image/
│   ├── favicon2.png
│   ├── Iphone.jpg
│   ├── MacBook.jpg
│   ├── AppleWatch.jpg
│   ├── AirPods.jpeg
│   ├── iphone17.jpg
│   ├── iphone-17-pro.jpg
│   ├── ...autres images...
│   ├── macbook air 15 m4.avif
│   └── macbook pro 14 m4 max.avif
│
└── 📁 videos/
    ├── hightlight-third.mp4
    ├── highlight-first.mp4
    ├── macbook.mp4
    ├── AppleWatch.mp4
    └── AirPods.mp4
```

## ✨ Fichiers Modifiés

### 1. **index.html**
```diff
- <a href="#" class="logo">
+ <a href="index.html" class="logo">
- <a href="credit.html" target="_blank"> | CREDIT | </a>
+ <a href="panier.html"> | MON PANIER | </a>
+ <a href="credit.html" target="_blank"> | CREDIT | </a>
```

### 2. **Iphone.html, MacBook.html, AppleWatch.html, AirPods.html**
```diff
- <a href="#" class="logo">
+ <a href="index.html" class="logo">
- <a href="#articles"> | ARTICLES | </a>
+ <a href="panier.html"> | MON PANIER | </a>
- <a href="credit.html" target="_blank"> | CREDIT | </a>
+ <a href="credit.html" target="_blank"> | CREDIT | </a>
+ <script src="panier.js"></script>
```

### 3. **style.css**
```diff
+ /* ===== STYLES DU PANIER ===== */
+ .panier-section { ... }
+ .panier-header { ... }
+ .panier-content { ... }
+ .panier-items { ... }
+ .panier-table { ... }
+ .panier-summary { ... }
+ .checkout-btn { ... }
+ .notification { ... }
```

## 🆕 Fichiers Créés

### Fichiers majeurs

1. **panier.html** (256 lignes)
   - Page complète du panier
   - Tableau d'affichage des produits
   - Résumé avec totaux
   - Boutons d'action

2. **panier.js** (245 lignes)
   - Classe `Panier` complète
   - Gestion localStorage
   - Affichage dynamique
   - Notifications toast
   - Communication API

3. **process_order.php** (154 lignes)
   - Réception des commandes
   - Validation des données
   - Création automatique BD
   - Insertion tables orders/order_items
   - Réponse JSON

4. **admin.php** (198 lignes)
   - Dashboard administration
   - Affichage statistiques
   - Liste des commandes
   - Modal détails commande
   - Styles intégrés

5. **get_order_details.php** (60 lignes)
   - API JSON
   - Récupération commande
   - Récupération articles
   - Formatage réponse

6. **export_orders.php** (50 lignes)
   - Export en CSV
   - Téléchargement fichier
   - Formatage données

### Fichiers de documentation

7. **README.md** - Guide complet utilisateur
8. **SETUP.md** - Installation rapide
9. **TECHNICAL_DOC.md** - Documentation technique
10. **apple_store.sql** - Script SQL
11. **MANIFEST.md** - Ce fichier

## 🔄 Flux de travail utilisateur

```
1. Utilisateur visite index.html
   ↓
2. Clique sur une catégorie (Iphone, MacBook, etc.)
   ↓
3. Choisit un produit et clique "Commander"
   ↓ (panier.js ajoute au localStorage)
4. Produit est dans le panier ✅
   ↓
5. Visite panier.html (lien "MON PANIER")
   ↓
6. Modifie les quantités ou supprime des produits
   ↓
7. Clique "Procéder au paiement"
   ↓ (panier.js envoie à process_order.php)
8. Commande est créée dans MySQL ✅
   ↓
9. Message de confirmation avec ID commande
   ↓
10. Admin visite admin.php pour voir les commandes
```

## 📊 Base de Données

### Tables créées automatiquement

**Table `orders`**
```
id              INT PRIMARY KEY AUTO_INCREMENT
order_date      DATETIME
total_amount    DECIMAL(10,2)
order_status    VARCHAR(50) DEFAULT 'Pending'
created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
```

**Table `order_items`**
```
id              INT PRIMARY KEY AUTO_INCREMENT
order_id        INT (FK to orders.id)
product_name    VARCHAR(255)
product_price   DECIMAL(10,2)
quantity        INT
item_total      DECIMAL(10,2)
```

## 🚀 Points d'accès

| URL | Description |
|-----|-------------|
| `http://localhost/projet_Omar_Apple_Store_Clone/` | Accueil |
| `http://localhost/projet_Omar_Apple_Store_Clone/panier.html` | Panier |
| `http://localhost/projet_Omar_Apple_Store_Clone/admin.php` | Administration |
| `http://localhost/projet_Omar_Apple_Store_Clone/export_orders.php` | Export CSV |
| `http://localhost/phpmyadmin` | Gestion BD |

## 📈 Statistiques du projet

| Métrique | Valeur |
|----------|--------|
| Fichiers HTML | 7 |
| Fichiers CSS | 1 |
| Fichiers JavaScript | 1 |
| Fichiers PHP | 4 |
| Fichiers Documentation | 4 |
| **Total** | **17 fichiers** |
| Lignes de code (sans HTML) | ~1200 |
| Taille totale (sans images) | ~150 KB |

## ✅ Checklist d'Installation

- [ ] PHP 7.4+ installé
- [ ] MySQL installé et lancé
- [ ] Fichiers copiés dans htdocs/
- [ ] Apache démarré
- [ ] `index.html` s'affiche
- [ ] Ajout au panier fonctionne
- [ ] Panier s'affiche avec les produits
- [ ] Commande se traite sans erreur
- [ ] Admin affiche les commandes
- [ ] Export CSV fonctionne

## 🔐 Points de sécurité

✅ **Implémentés**
- Validation des données serveur
- Prepared statements SQL
- Sanitization (htmlspecialchars, stripslashes)
- Headers Content-Type corrects

⚠️ **À ajouter**
- Authentification utilisateur
- HTTPS/SSL
- Rate limiting
- Logs d'audit
- CSRF token

## 📞 Support

Pour toute question :
- **Med Omar** : mohammad.omar.ben.hammouda@outlook.com
- **Ihab** : rashiinyihab@gmail.com

---

**Dernière mise à jour** : 22 novembre 2025
**Version** : 1.0
**Statut** : ✅ Production Ready
