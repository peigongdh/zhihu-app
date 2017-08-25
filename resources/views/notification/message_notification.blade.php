<li class="notification {{ $notification->unread() ? 'unread' : '' }}">
    {{ $notification->data['name'] }}给你发了一条<a
            href="{{ $notification->unread() ? "/notification/{$notification->id}?redirect_url=/message/{$notification->data['dialog_id']}" : "/message/{$notification->data['dialog_id']}"}}">私信。</a>
</li>