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
         <?php  require_once __DIR__ .'/../partial/action.html.php' ?>
      
      <?php echo $containe ?>
    </main>