<div class="row" style="margin-top: 10px;margin-bottom: 20px;">
    <div class="col-md-8 col-md-offset-2">
        <ul class="nav nav-tabs">
            <li role="presentation" class="{{ url()->current() == route('setting_info') ? 'active' : '' }}"><a href="{{ route('setting_info') }}">个人信息</a></li>
            <li role="presentation" class="{{ url()->current() == route('setting_avatar') ? 'active' : '' }}"><a href="{{ route('setting_avatar') }}">更换头像</a></li>
            <li role="presentation" class="{{ url()->current() == route('setting_password') ? 'active' : '' }}"><a href="{{ route('setting_password') }}">重设密码</a></li>
        </ul>
    </div>
</div>