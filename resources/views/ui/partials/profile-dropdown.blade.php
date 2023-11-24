<div class="dropdown-menu dropdown-menu-right">
    <div class="dropdown-header text-center"><strong>{{ trans('admin.profile_dropdown.account') }}</strong></div>
    <a href="{{ url('profile/edit') }}" class="dropdown-item"><i class="fa fa-user"></i>  {{ trans('admin.profile_dropdown.profile') }}</a>
    <a href="{{ url('profile/password') }}" class="dropdown-item"><i class="fa fa-key"></i>  {{ trans('admin.profile_dropdown.password') }}</a>
    {{-- Do not delete me :) I'm used for auto-generation menu items --}}
    <a href="{{ url('admin/logout') }}" class="dropdown-item"><i class="fa fa-lock"></i> {{ trans('admin.profile_dropdown.logout') }}</a>
</div>
