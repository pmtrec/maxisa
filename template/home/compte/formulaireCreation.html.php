<div class="max-w-xl mx-auto mt-10">
  <h2 class="text-2xl font-bold mb-6 text-orange-600">Créer un compte secondaire</h2>

  <?php if (isset($success)): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>

  <?php if (isset($error)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form action="/secondaire/store" method="POST"
        class="bg-white rounded-lg shadow border border-orange-200 p-6 space-y-5">

    <!-- Numéro de téléphone -->
    <div>
      <label class="block text-sm font-semibold text-gray-700">Numéro de téléphone</label>
       <input type="text" name="num_telephone" required
             placeholder="Ex : 778899XX"
             class="mt-1 block w-full border border-orange-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
    </div>

    <!-- Solde (facultatif) -->
    <div>
      <label class="block text-sm font-semibold text-gray-700">Solde initial (facultatif)</label>
      <input type="number" name="solde" min="0" step="0.01"
             placeholder="Ex : 15000"
             class="mt-1 block w-full border border-orange-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
    </div>

    <!-- Bouton de soumission -->
    <div class="pt-4">
      <button type="submit"
              class="w-full bg-orange-500 text-white font-semibold py-2 px-4 rounded hover:bg-orange-600 transition duration-200 shadow">
        Enregistrer le compte
      </button>
    </div>

  </form>

  <!-- Liste des comptes secondaires existants -->
  <?php if (!empty($comptes)): ?>
    <div class="mt-8">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Comptes secondaires existants</h3>
      <div class="bg-white rounded-lg shadow border border-gray-200">
        <?php foreach ($comptes as $compte): ?>
          <div class="p-4 border-b border-gray-200 last:border-b-0">
            <div class="flex justify-between items-center">
              <div>
                <p class="font-medium text-gray-900"><?= htmlspecialchars($compte->getNum_telephone()) ?></p>
                <p class="text-sm text-gray-500">Compte: <?= htmlspecialchars($compte->getNum_compte()) ?></p>
              </div>
              <div class="text-right">
                <p class="font-semibold text-green-600"><?= number_format($compte->getSolde(), 2, ',', ' ') ?> FCFA</p>
                <p class="text-xs text-gray-500">Créé le <?= date('d/m/Y', strtotime($compte->getDate_creation())) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>
