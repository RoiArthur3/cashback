@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Mes notifications</h1>
        <div class="flex space-x-2 mt-4 md:mt-0">
            <button id="mark-all-read" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                <i class="fas fa-check-double mr-2"></i> Tout marquer comme lu
            </button>
            <button id="clear-all" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                <i class="fas fa-trash-alt mr-2"></i> Tout supprimer
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($notifications->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <li class="notification-item {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 transition-colors">
                        <div class="flex items-start p-4">
                            <div class="flex-shrink-0 pt-1">
                                @if(isset($notification->data['icon']))
                                    <i class="{{ $notification->data['icon'] }} text-lg {{ $notification->read_at ? 'text-gray-400' : 'text-blue-500' }}"></i>
                                @else
                                    <i class="fas fa-bell text-lg {{ $notification->read_at ? 'text-gray-400' : 'text-blue-500' }}"></i>
                                @endif
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium {{ $notification->read_at ? 'text-gray-600' : 'text-gray-900' }}">
                                        {{ $notification->data['title'] ?? 'Nouvelle notification' }}
                                    </p>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        <button class="delete-notification text-gray-400 hover:text-red-500" data-id="{{ $notification->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $notification->data['message'] ?? 'Aucun message' }}
                                </p>
                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                                        Voir les détails <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="px-4 py-12 text-center">
                <i class="far fa-bell-slash text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">Aucune notification</h3>
                <p class="mt-1 text-sm text-gray-500">Vous n'avez pas de nouvelles notifications.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Marquer une notification comme lue au clic
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.closest('.delete-notification')) return;
                
                const notificationId = this.dataset.id;
                const url = this.dataset.url;
                
                // Marquer comme lu via AJAX
                fetch(`/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                // Mettre à jour l'interface utilisateur
                this.classList.remove('bg-blue-50');
                this.classList.add('bg-white');
                const unreadBadge = this.querySelector('.unread-badge');
                if (unreadBadge) {
                    unreadBadge.remove();
                }
                
                // Mettre à jour le compteur de notifications non lues
                const unreadCount = document.getElementById('unread-count');
                if (unreadCount) {
                    const count = parseInt(unreadCount.textContent) - 1;
                    unreadCount.textContent = count > 0 ? count : '';
                    if (count <= 0) {
                        unreadCount.classList.add('hidden');
                    }
                }
                
                // Rediriger si l'URL est définie
                if (url) {
                    window.location.href = url;
                }
            });
        });
        
        // Supprimer une notification
        document.querySelectorAll('.delete-notification').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const notificationId = this.dataset.id;
                
                if (confirm('Voulez-vous vraiment supprimer cette notification ?')) {
                    fetch(`/notifications/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const notificationItem = document.getElementById(`notification-${notificationId}`);
                            if (notificationItem) {
                                notificationItem.remove();
                                
                                // Mettre à jour le compteur
                                const unreadCount = document.getElementById('unread-count');
                                if (unreadCount && notificationItem.classList.contains('bg-blue-50')) {
                                    const count = parseInt(unreadCount.textContent) - 1;
                                    unreadCount.textContent = count > 0 ? count : '';
                                    if (count <= 0) {
                                        unreadCount.classList.add('hidden');
                                    }
                                }
                                
                                // Si plus de notifications, afficher un message
                                if (document.querySelectorAll('.notification-item').length === 0) {
                                    const container = document.querySelector('.bg-white');
                                    container.innerHTML = `
                                        <div class="p-8 text-center text-gray-500">
                                            <i class="far fa-bell-slash text-4xl mb-2 text-gray-300"></i>
                                            <p>Aucune notification pour le moment</p>
                                        </div>
                                    `;
                                }
                            }
                        }
                    });
                }
            });
        });
        
        // Marquer toutes les notifications comme lues
        document.getElementById('mark-all-read')?.addEventListener('click', function() {
            fetch('{{ route("notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour l'interface utilisateur
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.classList.remove('bg-blue-50');
                        item.classList.add('bg-white');
                        const unreadBadge = item.querySelector('.unread-badge');
                        if (unreadBadge) {
                            unreadBadge.remove();
                        }
                    });
                    
                    // Mettre à jour le compteur
                    const unreadCount = document.getElementById('unread-count');
                    if (unreadCount) {
                        unreadCount.textContent = '';
                        unreadCount.classList.add('hidden');
                    }
                }
            });
        });
        
        // Supprimer toutes les notifications
        document.getElementById('clear-all')?.addEventListener('click', function() {
            if (confirm('Voulez-vous vraiment supprimer toutes les notifications ? Cette action est irréversible.')) {
                fetch('{{ route("notifications.destroy-all") }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Vider la liste des notifications
                        const container = document.querySelector('.bg-white');
                        container.innerHTML = `
                            <div class="p-8 text-center text-gray-500">
                                <i class="far fa-bell-slash text-4xl mb-2 text-gray-300"></i>
                                <p>Aucune notification pour le moment</p>
                            </div>
                        `;
                        
                        // Mettre à jour le compteur
                        const unreadCount = document.getElementById('unread-count');
                        if (unreadCount) {
                            unreadCount.textContent = '';
                            unreadCount.classList.add('hidden');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
