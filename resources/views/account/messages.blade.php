@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            @include('account.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">💬 Messagerie intégrée</h5>
                </div>
                <div class="card-body p-0">
                    <div class="row g-0" style="height: 600px;">
                        {{-- Liste des conversations --}}
                        <div class="col-md-4 border-end">
                            <div class="p-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Conversations</h6>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newConversationModal">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Filtres --}}
                            <div class="p-3 border-bottom">
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="conversationType" id="allConversations" checked>
                                    <label class="btn btn-outline-primary btn-sm" for="allConversations">Toutes</label>
                                    
                                    <input type="radio" class="btn-check" name="conversationType" id="merchantConversations">
                                    <label class="btn btn-outline-primary btn-sm" for="merchantConversations">Commerçants</label>
                                    
                                    <input type="radio" class="btn-check" name="conversationType" id="groupConversations">
                                    <label class="btn btn-outline-primary btn-sm" for="groupConversations">Groupes</label>
                                </div>
                            </div>
                            
                            {{-- Liste des conversations --}}
                            <div class="conversation-list" style="height: 450px; overflow-y: auto;">
                                @if($conversations->count() > 0)
                                    @foreach($conversations as $conversation)
                                        <div class="conversation-item p-3 border-bottom cursor-pointer" data-conversation-id="{{ $conversation->id }}">
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative me-3">
                                                    <img src="{{ $conversation->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($conversation->name).'&background=random' }}" 
                                                         class="rounded-circle" width="40" height="40" alt="Avatar">
                                                    @if($conversation->is_online)
                                                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" style="width: 12px; height: 12px; border: 2px solid white;"></span>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <h6 class="mb-1">{{ $conversation->name }}</h6>
                                                        <small class="text-muted">{{ $conversation->last_message_time ?? '10:30' }}</small>
                                                    </div>
                                                    <p class="mb-1 text-muted small">{{ $conversation->last_message ?? 'Bonjour, j\'ai une question sur...' }}</p>
                                                    @if($conversation->unread_count > 0)
                                                        <span class="badge bg-danger">{{ $conversation->unread_count }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Conversations par défaut --}}
                                    <div class="conversation-item p-3 border-bottom cursor-pointer active" data-conversation-id="1">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://ui-avatars.com/api/?name=Boutique+Tech&background=2563eb&color=fff" 
                                                     class="rounded-circle" width="40" height="40" alt="Avatar">
                                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" style="width: 12px; height: 12px; border: 2px solid white;"></span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="mb-1">Boutique Tech</h6>
                                                    <small class="text-muted">10:30</small>
                                                </div>
                                                <p class="mb-1 text-muted small">Votre commande est prête pour expédition</p>
                                                <span class="badge bg-danger">2</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="conversation-item p-3 border-bottom cursor-pointer" data-conversation-id="2">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://ui-avatars.com/api/?name=Cercle+Famille&background=28a745&color=fff" 
                                                     class="rounded-circle" width="40" height="40" alt="Avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="mb-1">Cercle Famille</h6>
                                                    <small class="text-muted">Hier</small>
                                                </div>
                                                <p class="mb-1 text-muted small">Marie: Qui veut participer à l'achat groupé ?</p>
                                                <span class="badge bg-danger">1</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="conversation-item p-3 border-bottom cursor-pointer" data-conversation-id="3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                <img src="https://ui-avatars.com/api/?name=Support+CBM&background=ffc107&color=000" 
                                                     class="rounded-circle" width="40" height="40" alt="Avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="mb-1">Support CBM</h6>
                                                    <small class="text-muted">2j</small>
                                                </div>
                                                <p class="mb-1 text-muted small">Merci pour votre retour, nous avons pris en compte...</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Zone de conversation --}}
                        <div class="col-md-8 d-flex flex-column">
                            {{-- En-tête de conversation --}}
                            <div class="p-3 border-bottom bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Boutique+Tech&background=2563eb&color=fff" 
                                             class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                        <div>
                                            <h6 class="mb-0">Boutique Tech</h6>
                                            <small class="text-success">En ligne</small>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle"></i> Infos</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-archive"></i> Archiver</a></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Supprimer</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Messages --}}
                            <div class="flex-grow-1 p-3" style="overflow-y: auto; max-height: 400px;" id="messagesContainer">
                                {{-- Message reçu --}}
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <img src="https://ui-avatars.com/api/?name=Boutique+Tech&background=2563eb&color=fff" 
                                             class="rounded-circle me-2" width="30" height="30" alt="Avatar">
                                        <div>
                                            <div class="bg-light rounded p-2 mb-1" style="max-width: 300px;">
                                                Bonjour ! Votre commande #12345 est prête pour expédition. Souhaitez-vous que nous procédions à l'envoi ?
                                            </div>
                                            <small class="text-muted">10:25</small>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Message envoyé --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-end">
                                        <div>
                                            <div class="bg-primary text-white rounded p-2 mb-1" style="max-width: 300px;">
                                                Oui, vous pouvez procéder à l'expédition. Merci !
                                            </div>
                                            <small class="text-muted d-block text-end">10:28</small>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Message reçu avec notification d'offre --}}
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <img src="https://ui-avatars.com/api/?name=Boutique+Tech&background=2563eb&color=fff" 
                                             class="rounded-circle me-2" width="30" height="30" alt="Avatar">
                                        <div>
                                            <div class="bg-warning bg-opacity-25 border border-warning rounded p-2 mb-1" style="max-width: 300px;">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="bi bi-gift text-warning me-2"></i>
                                                    <strong>Offre spéciale !</strong>
                                                </div>
                                                -20% sur votre prochain achat avec le code MERCI20. Valable jusqu'au 31/12.
                                            </div>
                                            <small class="text-muted">10:30</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Zone de saisie --}}
                            <div class="p-3 border-top">
                                <form id="messageForm">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Tapez votre message..." id="messageInput">
                                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-paperclip"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-image"></i> Image</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark"></i> Fichier</a></li>
                                        </ul>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-send"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Nouvelle conversation --}}
<div class="modal fade" id="newConversationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle conversation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="conversationType" class="form-label">Type de conversation</label>
                        <select class="form-select" id="conversationType">
                            <option value="merchant">Commerçant</option>
                            <option value="support">Support CBM</option>
                            <option value="user">Utilisateur</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recipient" class="form-label">Destinataire</label>
                        <input type="text" class="form-control" id="recipient" placeholder="Rechercher un commerçant, utilisateur...">
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Sujet</label>
                        <input type="text" class="form-control" id="subject" placeholder="Objet de la conversation">
                    </div>
                    <div class="mb-3">
                        <label for="initialMessage" class="form-label">Message initial</label>
                        <textarea class="form-control" id="initialMessage" rows="3" placeholder="Votre message..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Démarrer la conversation</button>
            </div>
        </div>
    </div>
</div>

<style>
.conversation-item {
    transition: background-color 0.2s;
}
.conversation-item:hover {
    background-color: #f8f9fa;
}
.conversation-item.active {
    background-color: #e3f2fd;
    border-left: 4px solid #2196f3;
}
.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des conversations
    document.querySelectorAll('.conversation-item').forEach(item => {
        item.addEventListener('click', function() {
            // Retirer la classe active de tous les éléments
            document.querySelectorAll('.conversation-item').forEach(el => el.classList.remove('active'));
            // Ajouter la classe active à l'élément cliqué
            this.classList.add('active');
            
            // Charger les messages de la conversation
            const conversationId = this.dataset.conversationId;
            loadConversation(conversationId);
        });
    });
    
    // Envoi de message
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();
        
        if (message) {
            addMessage(message, true);
            messageInput.value = '';
            
            // Simulation d'une réponse automatique
            setTimeout(() => {
                addMessage('Message reçu, merci !', false);
            }, 1000);
        }
    });
    
    function loadConversation(conversationId) {
        // Logique pour charger les messages d'une conversation
        console.log('Chargement de la conversation:', conversationId);
    }
    
    function addMessage(text, isSent) {
        const messagesContainer = document.getElementById('messagesContainer');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'mb-3';
        
        const now = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        
        if (isSent) {
            messageDiv.innerHTML = `
                <div class="d-flex justify-content-end">
                    <div>
                        <div class="bg-primary text-white rounded p-2 mb-1" style="max-width: 300px;">
                            ${text}
                        </div>
                        <small class="text-muted d-block text-end">${now}</small>
                    </div>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="d-flex">
                    <img src="https://ui-avatars.com/api/?name=Boutique+Tech&background=2563eb&color=fff" 
                         class="rounded-circle me-2" width="30" height="30" alt="Avatar">
                    <div>
                        <div class="bg-light rounded p-2 mb-1" style="max-width: 300px;">
                            ${text}
                        </div>
                        <small class="text-muted">${now}</small>
                    </div>
                </div>
            `;
        }
        
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>
@endsection
