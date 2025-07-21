<aside class="w-80 bg-orange-500 text-white flex flex-col relative">
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
    <div class="p-4 border-b border-orange-400 relative">
        <div class="flex items-center space-x-3">
            <div class="bg-orange-400 text-white w-10 h-10 rounded-full flex items-center justify-center">
                <?php 
                $prenom = $this->session->get("user")->getPrenom();
                $nom = $this->session->get("user")->getNom();
                $initiales = strtoupper(substr($prenom, 0, 1) . substr($nom, 0, 1));
                echo $initiales;
                ?>
            </div>
            <div class="flex-1">
                <p class="font-medium">
                    <?php 
                    echo $this->session->get("user")->getPrenom().' '.$this->session->get("user")->getNom();
                    ?>
                </p>
                <div class="flex items-center space-x-2 text-sm text-orange-200">
                    <span id="current-number">
                        <?php 
                        echo $this->session->get("compte")->getNum_telephone();
                        ?>
                    </span>
                    <button onclick="toggleAccountPopup()" class="text-orange-200 hover:text-white transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Popup pour sélection de compte -->
        <div id="account-popup" class="hidden absolute z-50 mt-2 left-0 right-0 mx-2 bg-white text-gray-800 rounded-lg shadow-lg border border-gray-200">
            <div class="p-3 border-b border-gray-200">
                <h3 class="font-semibold text-sm text-gray-600">Changer de compte</h3>
            </div>
            <div class="py-2 max-h-48 overflow-y-auto">
                <!-- Compte principal (actuel) -->
                <div class="px-3 py-2 hover:bg-gray-50 cursor-pointer border-l-3 border-orange-500 bg-orange-50" onclick="selectAccount('<?php echo $this->session->get('compte')->getNum_telephone(); ?>', 'Principal')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-sm"><?php echo $this->session->get("compte")->getNum_telephone(); ?></p>
                            <p class="text-xs text-gray-500">Compte Principal</p>
                        </div>
                        <span class="text-orange-500 text-xs font-medium">Actuel</span>
                    </div>
                </div>
                
                <!-- Comptes secondaires - Remplacer par votre boucle PHP -->
                <?php 
                // $num = $this->session->get("numberS");
                // var_dump($num);die();
                
                 
                $comptesSecondaires = [
                    ['numero' => '+221 77 987 65 43', 'type' => 'Compte Secondaire'],
                    ['numero' => '+221 76 555 44 33', 'type' => 'Compte Secondaire'],
                    ['numero' => '+221 78 111 22 33', 'type' => 'Compte Secondaire']
                ];
                
                foreach($comptesSecondaires as $compte) : 
                ?>
                <div class="px-3 py-2 hover:bg-gray-50 cursor-pointer" onclick="selectAccount('<?php echo $compte['numero']; ?>', 'Secondaire')">
                    <div>
                        <p class="font-medium text-sm"><?php echo $compte['numero']; ?></p>
                        <p class="text-xs text-gray-500"><?php echo $compte['type']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="p-3 border-t border-gray-200">
                <button onclick="toggleAccountPopup()" class="text-sm text-gray-500 hover:text-gray-700">Fermer</button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-2">
        <a href="#" class="block p-3 rounded-lg bg-white bg-opacity-10">🏠 Accueil</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">💸 Transfert</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">⬇️ Dépôt</a>
        <a href="#" class="block p-3 rounded-lg hover:bg-orange-400">⬆️ Retrait</a>
        <a href="/newcompte" class="block p-3 rounded-lg hover:bg-orange-400">⬆️ Creation de Nouveau Compte</a>
    </nav>

    <!-- Déconnexion -->
    <div class="p-4 border-t border-orange-400">
        <a href="/"><button class="w-full bg-orange-400 text-white py-2 rounded-lg hover:bg-orange-600">Déconnexion</button></a>  
    </div>
</aside>

<script>
let isPopupOpen = false;

function toggleAccountPopup() {
    const popup = document.getElementById('account-popup');
    isPopupOpen = !isPopupOpen;
    
    if (isPopupOpen) {
        popup.classList.remove('hidden');
        // Fermer le popup si on clique ailleurs
        document.addEventListener('click', closePopupOnOutsideClick);
    } else {
        popup.classList.add('hidden');
        document.removeEventListener('click', closePopupOnOutsideClick);
    }
}

function closePopupOnOutsideClick(event) {
    const popup = document.getElementById('account-popup');
    const button = event.target.closest('button');
    
    if (!popup.contains(event.target) && !button?.onclick?.toString().includes('toggleAccountPopup')) {
        popup.classList.add('hidden');
        isPopupOpen = false;
        document.removeEventListener('click', closePopupOnOutsideClick);
    }
}

function selectAccount(phoneNumber, accountType) {
    // Mettre à jour le numéro affiché
    document.getElementById('current-number').textContent = phoneNumber;
    
    // Fermer le popup
    document.getElementById('account-popup').classList.add('hidden');
    isPopupOpen = false;
    document.removeEventListener('click', closePopupOnOutsideClick);
    
    // Redirection vers votre backend pour changer de compte
    console.log('Changement vers:', phoneNumber, accountType);
    // window.location.href = '/switch-account?phone=' + encodeURIComponent(phoneNumber);
}
</script>