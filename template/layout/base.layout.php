<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Max it - Tableau de bord</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-80 bg-orange-500 text-white flex flex-col">
      <div class="p-6 border-b border-orange-400">
        <div class="flex items-center space-x-3">
          <div class="bg-white text-orange-500 text-xl font-bold w-12 h-12 rounded-full flex items-center justify-center">M</div>
          <div>
            <h2 class="font-semibold">Max it</h2>
            <p class="text-sm text-orange-200">Orange Money</p>
          </div>
        </div>
      </div>

      <!-- User info -->
      <div class="p-4 border-b border-orange-400">
        <div class="flex items-center space-x-3">
          <div class="bg-orange-400 text-white w-10 h-10 rounded-full flex items-center justify-center">AB</div>
          <div>
            <p class="font-medium">
              <?php 
              echo ''.$this->session->get("user")->getPrenom().' '.$this->session->get("user")->getNom().'';

               ?>
            </p>
            <p class="text-sm text-orange-200">
              <?php 
              // echo ;
               echo $this->session->get("compte")->getNum_telephone();
               

               ?>
            </p>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 p-4 space-y-2">
        <a href="#" class="block p-3 rounded-lg bg-white bg-opacity-10">🏠 Accueil</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">💸 Transfert</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">⬇️ Dépôt</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">⬆️ Retrait</a>
        <!-- <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">🧾 Factures</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">🏪 Paiement marchand</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">📱 Crédit</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">📺 TV/Internet</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">📊 Historique</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">👥 Parrainage</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">💬 Chat Ibou</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">⚙️ Paramètres</a> -->
      </nav>

      <!-- Déconnexion -->
      <div class="p-4 border-t border-orange-400">
      <a href="/"><button class="w-full bg-orange-400 text-white py-2 rounded-lg hover:bg-orange-600">Déconnexion</button> </a>  

      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6 space-y-6 overflow-y-auto">
      <!-- Titre -->
      <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>

      <!-- Solde -->
      <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
        <div class="flex justify-between items-center">
          <div>
            <p class="text-orange-200 text-sm">Solde Orange Money</p>
            <p class="text-3xl font-bold">  <?php 
          
            
            echo $this->session->get("compte")->getSolde();
             ?>
             </p>
          </div>
          <div class="text-right">
            <p class="text-orange-200 text-sm">Dernier recharge</p>
            <p class="text-sm">Aujourd'hui 14:30</p>
          </div>
        </div>
      </div>

      <!-- Actions rapides -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md cursor-pointer text-center">
          <div class="bg-orange-100 text-orange-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">💸</div>
          <p class="font-medium text-gray-800">Transfert</p>
          <p class="text-sm text-gray-600">Envoyer argent</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md cursor-pointer text-center">
          <div class="bg-orange-100 text-orange-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">🧾</div>
          <p class="font-medium text-gray-800">Factures</p>
          <p class="text-sm text-gray-600">Payer factures</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md cursor-pointer text-center">
          <div class="bg-orange-100 text-orange-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">📱</div>
          <p class="font-medium text-gray-800">Crédit</p>
          <p class="text-sm text-gray-600">Recharger mobile</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow hover:shadow-md cursor-pointer text-center">
          <div class="bg-orange-100 text-orange-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">⬇️</div>
          <p class="font-medium text-gray-800">Dépôt</p>
          <p class="text-sm text-gray-600">Recharger compte</p>
        </div>
      </div>

      <?php echo $containe ?>
    </main>
  </div>
</body>
</html>
