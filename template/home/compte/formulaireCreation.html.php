<div class="max-w-xl mx-auto mt-10">
  <h2 class="text-2xl font-bold mb-6 text-orange-600">Créer un compte secondaire</h2>

  <form action="/secondaire/store" method="POST"
        class="bg-white rounded-lg shadow border border-orange-200 p-6 space-y-5">

    <!-- Numéro du compte secondaire -->
    <div>
      <label class="block text-sm font-semibold text-gray-700">Numéro de compte</label>
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
</div>
