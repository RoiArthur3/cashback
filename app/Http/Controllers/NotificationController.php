<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Afficher la liste des notifications de l'utilisateur
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->paginate(15);
        
        return view('notifications.index', [
            'notifications' => $notifications
        ]);
    }

    /**
     * Marquer une notification comme lue
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
        ]);

        $notification = Auth::user()->notifications()->where('id', $request->id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Marquer toutes les notifications comme lues
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
