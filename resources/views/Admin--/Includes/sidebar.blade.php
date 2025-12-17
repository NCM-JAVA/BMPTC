

<aside class="col-2 admin-sidebar">

    @php
        $currentRoute = Route::currentRouteName();
    @endphp

    <ul class="nav flex-column">
        <li><a href="{{ route('admin.index') }}" class="nav-link {{ $currentRoute == 'admin.index' ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.profile.view') }}" class="nav-link {{ $currentRoute == 'admin.profile.view' ? 'active' : '' }}"><i class="bi bi-person-lines-fill me-2"></i> View Profile</a></li>
        <li><a href="{{ route('admin.manage-user.index') }}" class="nav-link {{ $currentRoute == 'admin.manage-user.index' ? 'active' : '' }}"><i class="bi bi-people-fill me-2"></i> User Management</a></li>
        <li><a href="{{ route('admin.mobile-content.index') }}" class="nav-link {{ $currentRoute == 'admin.mobile-content.index' ? 'active' : '' }}"><i class="bi bi-phone-fill me-2"></i> Manage Mobile App Content</a></li>
        <!-- <li><a href="#" class="nav-link"><i class="bi bi-flag-fill me-2"></i> Manage Country</a></li> -->
        <li><a href="{{ route('admin.manage-hazard.index') }}" class="nav-link {{ $currentRoute == 'admin.manage-hazard.index' ? 'active' : '' }}"><i class="bi bi-exclamation-triangle-fill me-2"></i> Manage Hazard</a></li>
        <li><a href="{{ route('admin.manage-state.index') }}" class="nav-link {{ $currentRoute == 'admin.manage-state.index' ? 'active' : '' }}"><i class="bi bi-geo-alt-fill me-2"></i> Manage State</a></li>
        <li><a href="{{ route('admin.manage-district.index') }}" class="nav-link {{ $currentRoute == 'admin.manage-district.index' ? 'active' : '' }}"><i class="bi bi-map-fill me-2"></i> Manage Districts</a></li>
        <!-- <li><a href="#" class="nav-link"><i class="bi bi-building me-2"></i> Manage State Nodal Agency</a></li> -->
        <li><a href="#" class="nav-link"><i class="bi bi-bug-fill me-2"></i> Reported Bugs</a></li>
        <!-- <li><a href="#" class="nav-link"><i class="bi bi-list-task me-2"></i> Requested Features</a></li> -->
        <li><a href="#" class="nav-link"><i class="bi bi-graph-up-arrow me-2"></i> Manage Audit</a></li>
    </ul>
</aside>




