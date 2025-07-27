@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Mes notifications</h1>
        <button id="mark-all-read" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
            <i class="fas fa-check-double mr-2"></i> Tout marquer comme lu
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($notifications->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <li class="notification-item {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 transition-colors">
                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block p-4" data-id="{{ $notification->id }}">
                            <div class="flex items-start">
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
                                        <span class="text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $notification->data['message'] ?? 'Aucun message' }}
                                    </p>
                                </div>
                                @if(!$notification->read_at)
                                    <div class="ml-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Nouveau
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </a>
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
        document.querySelectorAll('.notification-item a').forEach(link => {
            link.addEventListener('click', function(e) {
                const notificationId = this.dataset.id;
                if (!notificationId) return;
                
                fetch('{{ route("notifications.markAsRead") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id: notificationId })
                });
            });
        });

        // Marquer toutes les notifications comme lues
        document.getElementById('mark-all-read').addEventListener('click', function(e) {
            e.preventDefault();
            
            fetch('{{ route("notifications.markAllAsRead") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      document.querySelectorAll('.notification-item').forEach(item => {
                          item.classList.remove('bg-blue-50');
                          item.classList.add('bg-white');
                          const icon = item.querySelector('i.text-blue-500');
                          if (icon) {
                              icon.classList.remove('text-blue-500');
                              icon.classList.add('text-gray-400');
                          }
                          const title = item.querySelector('.text-gray-900');
                          if (title) {
                              title.classList.remove('text-gray-900');
                              title.classList.add('text-gray-600');
                          }
                          const newBadge = item.querySelector('.bg-blue-100');
                          if (newBadge) {
                              newBadge.remove();
                          }
                      });
                  }
              });
        });
    });
</script>
@endpush

@endsection
