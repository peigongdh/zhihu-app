<li class="notification {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{ $notification->unread() ? "/notification/{$notification->id}?redirect_url=/user/{$notification->data['id']}" : "/user/{$notification->data['id']}"}}">{{ $notification->data['name'] }}</a>关注了你。
</li>