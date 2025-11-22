#!/bin/bash
# Installation complète du panier Apple Store

echo "==================================="
echo "Installation Apple Store Panier"
echo "==================================="
echo ""

# Vérifier si les fichiers existent
echo "Vérification des fichiers..."
files=(
    "index.html"
    "panier.html"
    "panier.js"
    "style.css"
    "process_order.php"
    "admin.php"
    "get_order_details.php"
    "export_orders.php"
)

missing_files=()
for file in "${files[@]}"; do
    if [ ! -f "$file" ]; then
        missing_files+=("$file")
    fi
done

if [ ${#missing_files[@]} -gt 0 ]; then
    echo "❌ Fichiers manquants:"
    for file in "${missing_files[@]}"; do
        echo "   - $file"
    done
    exit 1
else
    echo "✅ Tous les fichiers sont présents"
fi

echo ""
echo "Installation réussie !"
echo ""
echo "Prochaines étapes :"
echo "1. Lancer Apache et MySQL"
echo "2. Accéder à http://localhost/projet_Omar_Apple_Store_Clone/"
echo "3. Ajouter un produit au panier"
echo "4. Accéder à http://localhost/projet_Omar_Apple_Store_Clone/admin.php"
echo ""
echo "Documentation :"
echo "- QUICKSTART.md     : Démarrage rapide (5 min)"
echo "- README.md         : Guide complet"
echo "- SETUP.md          : Installation détaillée"
echo "- TECHNICAL_DOC.md  : Architecture technique"
echo ""
