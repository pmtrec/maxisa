// Variables globales
let currentBalance = 25750;
let isLoggedIn = false;

// Fonction pour charger un contenu HTML
async function loadContent(url, elementId) {
  try {
    const response = await fetch(url);
    const html = await response.text();
    document.getElementById(elementId).innerHTML = html;
  } catch (error) {
    console.error('Erreur de chargement:', error);
  }
}

// Initialisation de l'application
async function initApp() {
  // Charger la page de connexion par défaut
  await loadContent('views/auth/login.html', 'app');
  
  // Initialiser les événements
  setupEventListeners();
}

// Gestion des événements
function setupEventListeners() {
  // Événements seront ajoutés ici après le chargement du DOM
  document.addEventListener('click', function(e) {
    // Gestion de la navigation
    if (e.target.matches('.nav-item') || e.target.matches('.quick-action')) {
      e.preventDefault();
      const section = e.target.getAttribute('data-section');
      showSection(section);
    }
    
    // Déconnexion
    if (e.target.matches('#logout-btn')) {
      logout();
    }
  });
  
  // Gestion du formulaire de connexion
  document.addEventListener('submit', function(e) {
    if (e.target.matches('#login-form')) {
      e.preventDefault();
      login();
    }
  });
}

// Fonction de connexion
function login() {
  const phone = document.getElementById('phone').value;
  const pin = document.getElementById('pin').value;
  
  if (phone && pin.length === 4) {
    isLoggedIn = true;
    loadAppLayout();
  } else {
    alert('Veuillez remplir tous les champs correctement');
  }
}

// Fonction de déconnexion
function logout() {
  isLoggedIn = false;
  loadContent('views/auth/login.html', 'app');
}

// Charger la mise en page de l'application
async function loadAppLayout() {
  await loadContent('partials/sidebar.html', 'app');
  await loadContent('views/app/dashboard.html', 'main-content');
  showSection('dashboard');
}

// Afficher une section spécifique
async function showSection(sectionId) {
  const sectionMap = {
    'dashboard': 'views/app/dashboard.html',
    'transfer': 'views/app/transfer.html',
    'deposit': 'views/app/deposit.html',
    'withdraw': 'views/app/withdraw.html',
    'bills': 'views/app/bills.html',
    'merchant': 'views/app/merchant.html',
    'credit': 'views/app/credit.html',
    'tv': 'views/app/tv.html',
    'history': 'views/app/history.html',
    'referral': 'views/app/referral.html',
    'chat': 'views/app/chat.html',
    'settings': 'views/app/settings.html'
  };
  
  if (sectionMap[sectionId]) {
    await loadContent(sectionMap[sectionId], 'main-content');
    updateActiveNavItem(sectionId);
  }
}

// Mettre à jour l'élément de navigation actif
function updateActiveNavItem(sectionId) {
  document.querySelectorAll('.nav-item').forEach(item => {
    item.classList.remove('bg-white', 'bg-opacity-10');
    item.classList.add('hover:bg-orange-400');
    
    if (item.getAttribute('data-section') === sectionId) {
      item.classList.add('bg-white', 'bg-opacity-10');
      item.classList.remove('hover:bg-orange-400');
    }
  });
}

// Mettre à jour le solde
function updateBalance() {
  document.getElementById('balance').textContent = `${currentBalance.toLocaleString()} FCFA`;
}

// Initialiser l'application au chargement
document.addEventListener('DOMContentLoaded', initApp);