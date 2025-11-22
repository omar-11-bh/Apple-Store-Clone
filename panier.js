// Gestion du panier avec localStorage

class Panier {
    constructor() {
        this.items = JSON.parse(localStorage.getItem('panier')) || [];
    }

    addItem(product) {
        // Vérifier si le produit existe déjà
        const existingItem = this.items.find(item => item.name === product.name);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            product.quantity = 1;
            this.items.push(product);
        }
        this.save();
        this.showNotification(`${product.name} ajouté au panier!`);
    }

    removeItem(productName) {
        this.items = this.items.filter(item => item.name !== productName);
        this.save();
    }

    updateQuantity(productName, quantity) {
        const item = this.items.find(item => item.name === productName);
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.save();
        }
    }

    clear() {
        this.items = [];
        this.save();
    }

    save() {
        localStorage.setItem('panier', JSON.stringify(this.items));
    }

    getTotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    }

    showNotification(message) {
        // Créer une notification
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }
}

// Initialiser le panier
const panier = new Panier();

// Ajouter les événements aux boutons "Commander"
function initializeCartButtons() {
    const orderButtons = document.querySelectorAll('.order');
    
    orderButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Récupérer les informations du produit
            const articleCard = this.closest('.carte-articles');
            const name = articleCard.querySelector('.articles-categorie').textContent;
            const priceText = articleCard.querySelector('.price').textContent;
            const price = parseFloat(priceText.replace('€', '').replace(',', '.').trim());
            
            // Créer l'objet produit
            const product = {
                name: name,
                price: price
            };
            
            // Ajouter au panier
            panier.addItem(product);
        });
    });
}

// Afficher le panier
function displayCart() {
    const panierItemsDiv = document.getElementById('panierItems');
    
    if (!panierItemsDiv) return; // Si on n'est pas sur la page du panier
    
    if (panier.items.length === 0) {
        panierItemsDiv.innerHTML = '<p class="empty-cart-message">Votre panier est vide. <a href="index.html">Continuez vos achats</a></p>';
        document.getElementById('checkoutBtn').disabled = true;
        document.getElementById('emptyCartBtn').disabled = true;
        return;
    }
    
    let html = '<table class="panier-table">';
    html += '<thead><tr><th>Produit</th><th>Prix</th><th>Quantité</th><th>Sous-total</th><th>Action</th></tr></thead>';
    html += '<tbody>';
    
    panier.items.forEach(item => {
        const subtotal = item.price * item.quantity;
        html += `
            <tr class="panier-row" data-product="${item.name}">
                <td>${item.name}</td>
                <td>${item.price.toFixed(2).replace('.', ',')} €</td>
                <td>
                    <input type="number" min="1" value="${item.quantity}" class="quantity-input" data-product="${item.name}">
                </td>
                <td>${subtotal.toFixed(2).replace('.', ',')} €</td>
                <td>
                    <button class="delete-btn" data-product="${item.name}">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </td>
            </tr>
        `;
    });
    
    html += '</tbody></table>';
    panierItemsDiv.innerHTML = html;
    
    // Ajouter les événements
    addCartEventListeners();
    updateSummary();
}

// Mettre à jour le résumé
function updateSummary() {
    const subtotal = panier.getTotal();
    const shipping = subtotal > 0 ? 5.00 : 0;
    const total = subtotal + shipping;
    
    document.getElementById('subtotal').textContent = subtotal.toFixed(2).replace('.', ',') + ' €';
    document.getElementById('shipping').textContent = shipping.toFixed(2).replace('.', ',') + ' €';
    document.getElementById('total').textContent = total.toFixed(2).replace('.', ',') + ' €';
}

// Ajouter les événements du panier
function addCartEventListeners() {
    // Événements de suppression
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productName = this.dataset.product;
            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit?')) {
                panier.removeItem(productName);
                displayCart();
            }
        });
    });
    
    // Événements de modification de quantité
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productName = this.dataset.product;
            const quantity = parseInt(this.value) || 1;
            panier.updateQuantity(productName, quantity);
            displayCart();
        });
    });
}

// Vider le panier
const emptyCartBtn = document.getElementById('emptyCartBtn');
if (emptyCartBtn) {
    emptyCartBtn.addEventListener('click', function() {
        if (confirm('Êtes-vous sûr de vouloir vider le panier?')) {
            panier.clear();
            displayCart();
        }
    });
}

// Procéder au paiement
const checkoutBtn = document.getElementById('checkoutBtn');
if (checkoutBtn) {
    checkoutBtn.addEventListener('click', function() {
        // Envoyer les données au serveur PHP
        const data = {
            items: panier.items,
            total: panier.getTotal() + 5.00
        };
        
        fetch('process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Commande créée avec succès! Numéro de commande: ' + result.order_id);
                panier.clear();
                displayCart();
            } else {
                alert('Erreur: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors du traitement de la commande');
        });
    });
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', function() {
    initializeCartButtons();
    displayCart();
});
