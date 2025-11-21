<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\CustomResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use CustomResponse;

    public function index(Request $request)
    {
        $user = auth()->user();
        $type = $request->get('type', 'all'); // all, unread, read

        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->limit(50);

        if ($type === 'unread') {
            $query->where('is_read', false);
        } elseif ($type === 'read') {
            $query->where('is_read', true);
        }

        $notifications = $query->get()->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => app()->getLocale() === 'ar' ? $notification->message_ar : $notification->message_en,
                'is_read' => $notification->is_read,
                'time_ago' => $notification->created_at->diffForHumans(),
                'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $this->success([
            'notifications' => $notifications,
            'unread_count' => Notification::where('user_id', $user->id)->where('is_read', false)->count(),
        ], 'Notifications fetched successfully');
    }

    public function markAsRead($id)
    {
        $user = auth()->user();
        $notification = Notification::where('user_id', $user->id)->findOrFail($id);
        
        $notification->is_read = true;
        $notification->save();

        $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

        return $this->success([
            'unread_count' => $unreadCount,
        ], 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

        return $this->success([
            'unread_count' => $unreadCount,
        ], 'All notifications marked as read');
    }

    public function getUnreadCount()
    {
        $user = auth()->user();
        $count = Notification::where('user_id', $user->id)->where('is_read', false)->count();

        return $this->success([
            'unread_count' => $count,
        ], 'Unread count fetched successfully');
    }
}
