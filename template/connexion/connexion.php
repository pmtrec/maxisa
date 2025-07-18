 <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
      <h1 class="text-2xl font-bold text-orange-600 text-center mb-6">
        Bienvenue sur Orange Money Sénégal
      </h1>

      <form class="space-y-4" method="POST" action="/login">
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700"
            >Numéro de téléphone</label
          >
          <input
            type="tel"
            id="phone"
            name="phone"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500"
            placeholder="77 123 45 67"
          />
        </div>

        <div>
          <label for="pin" class="block text-sm font-medium text-gray-700"
            >Code secret</label
          >
          <input
            type="password"
            id="pin"
            name="password"
            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-orange-500 focus:border-orange-500"
            placeholder="••••"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-md"
        >
          Connexion
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Vous n’avez pas de compte ?
        <a href="#" class="text-orange-600 hover:underline">Créer un compte</a>
      </p>
    </div>
  