<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
<div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
            <li  class="{{ request()->is('admin/dashboard') ? 'active current-page' : '' }}"><a href = "{{ route('admin.dashboard')}}"><i class="fa fa-home"></i> Dashboard </a></li>
            <li  class="{{ request()->is('admin/payrecord') ? 'active current-page' : '' }}"><a href = "{{ route('admin.payrecord')}}"><i class="fa fa-money"></i> Payment </a></li>
            <li  class="{{ request()->is('admin/payrecord_global') ? 'active current-page' : '' }}"><a href = "{{ route('admin.payrecord_global')}}"><i class="fa fa-money"></i> Payment Global </a></li>
            <li  class="{{ request()->is('admin/activity') ? 'active current-page' : '' }}"><a href = "{{ route('admin.activity')}}"><i class="fa fa-book"></i> Activity </a></li>
            <li  class="{{ request()->is('admin/counter_stats') ? 'active current-page' : '' }}"><a href = "{{ route('admin.counter_stats')}}"><i class="fa fa-book"></i> Counter Stats </a></li>            
            <li  class="{{ request()->is('admin/setting') ? 'active current-page' : '' }}"><a href = "{{ route('admin.setting')}}"><i class="fa fa-cog"></i> Setting </a></li>
    </ul>
</div>

</div>
<!-- /sidebar menu -->