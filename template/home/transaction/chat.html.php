<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat Ibou - Max it</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6 h-[80vh] flex flex-col">
    <h2 class="text-xl font-bold mb-4">Chat Ibou</h2>
    <div class="flex-1 overflow-y-auto space-y-3 mb-4">
      <div class="bg-gray-100 p-3 rounded w-fit max-w-xs">Bonjour, comment puis-je vous aider ?</div>
      <div class="bg-orange-100 p-3 rounded w-fit max-w-xs ml-auto">Je veux connaître mon solde</div>
    </div>
    <div class="flex">
      <input type="text" placeholder="Écrivez votre message..." class="flex-1 border border-gray-300 rounded-l-lg px-4 py-3">
      <button class="bg-orange-500 text-white px-6 py-3 rounded-r-lg hover:bg-orange-600">Envoyer</button>
    </div>
  </div>
</body>
</html>
