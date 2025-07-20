<?php $transactions = $this->session->get('transactions');?>
<div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
  <!-- En-tête -->
  <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
    <div class="flex items-center justify-between">
      <h3 class="text-xl font-bold text-gray-800 flex items-center">
        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
        </svg>
        Transactions récentes
      </h3>
      <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
        <?= count($transactions) ?> transaction(s)
      </span>
    </div>
  </div>

  <!-- Tableau -->
  <div class="overflow-x-auto">
    <table class="w-full">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <div class="flex items-center space-x-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <span>Date</span>
            </div>
          </th>
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <div class="flex items-center space-x-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
              </svg>
              <span>Type</span>
            </div>
          </th>
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <div class="flex items-center space-x-1">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
              </svg>
              <span>Montant</span>
            </div>
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php if (empty($transactions)): ?>
        <tr>
          <td colspan="3" class="px-6 py-8 text-center">
            <div class="flex flex-col items-center">
              <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <p class="text-gray-500 text-lg font-medium">Aucune transaction trouvée</p>
              <p class="text-gray-400 text-sm mt-1">Les transactions apparaîtront ici une fois effectuées</p>
            </div>
          </td>
        </tr>
        <?php else: ?>
        <?php foreach($transactions as $index => $transaction): ?>
        <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">
                  <?= date('d/m/Y', strtotime($transaction->getDate())) ?>
                </div>
                <div class="text-sm text-gray-500">
                  <?= date('H:i', strtotime($transaction->getDate())) ?>
                </div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <?php 
            $type = $transaction->getTypeTransaction()->value;
            $typeColors = [
              'depot' => 'bg-green-100 text-green-800',
              'retrait' => 'bg-red-100 text-red-800',
              'transfer' => 'bg-blue-100 text-blue-800',
              'paiement' => 'bg-purple-100 text-purple-800'
            ];
            $colorClass = $typeColors[strtolower($type)] ?? 'bg-gray-100 text-gray-800';
            ?>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $colorClass ?>">
              <?= ucfirst($type) ?>
            </span>
          </td>
          <td class="px-6 py-4 whitespace-nowrap">
            <?php 
            $montant = $transaction->getMontant();
            $isPositive = $montant >= 0;
            $textColor = $isPositive ? 'text-green-600' : 'text-red-600';
            $bgColor = $isPositive ? 'bg-green-50' : 'bg-red-50';
            ?>
            <div class="flex items-center">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold <?= $textColor ?> <?= $bgColor ?>">
                <?= $isPositive ? '+' : '' ?><?= number_format($montant, 2, ',', ' ') ?> €
              </span>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pied de page -->
  <?php if (!empty($transactions)): ?>
  <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
    <div class="flex items-center justify-between text-sm text-gray-600">
      <span>Dernière mise à jour: <?= date('d/m/Y à H:i') ?></span>
      <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-150">
        Voir tout l'historique →
      </button>
    </div>
  </div>
  <?php endif; ?>
</div>