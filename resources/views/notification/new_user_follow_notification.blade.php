<li class="notification {{ $notification->unread() ? 'unread' : '' }}">
    <a href="{{ $notification->data['name'] }}">{{ $notification->data['name'] }}</a>关注了你。
</li>