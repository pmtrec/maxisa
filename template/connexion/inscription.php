<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription - PMT</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>

  <body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-xl">
      <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">
        Formulaire d'inscription
      </h2>

      <form action="/register" method="POST" enctype="multipart/form-data" class="space-y-4">
        <!-- Nom -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Nom</label>
          <input
            type="text"
            name="nom"
            required
            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
          />
        </div>

        <!-- Prénom -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Prénom</label>
          <input
            type="text"
            name="prenom"
            required
            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
          />
        </div>

        <!-- Login -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Login</label>
          <input
            type="text"
            name="login"
            required
            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
          />
        </div>

        <!-- Mot de passe -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
          <input
            type="password"
            name="password"
            required
            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
          />
        </div>

        <!-- Adresse -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Adresse</label>
          <input
            type="text"
            name="adresse"
            required
            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
          />
        </div>

        <!-- Numéro de carte d'identité -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Numéro CNI</label>
          <input
            type="text"
            name="numeroCarteIdentite"
            required
            class="mt-1 w-full p-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
          />
        </div>

        <!-- Photo d'identité -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Photo d'identité</label>
          <input
            type="file"
            name="photoIdentite"
            accept="image/*"
            required
            class="mt-1 w-full"
          />
        </div>

        <!-- Bouton soumettre -->
        <div>
          <button
            type="submit"
            class="w-full bg-orange-500 text-white font-semibold py-2 rounded-md hover:bg-orange-600"
          >
            S'inscrire
          </button>
        </div>
      </form>
    </div>
  </body>
</html>
