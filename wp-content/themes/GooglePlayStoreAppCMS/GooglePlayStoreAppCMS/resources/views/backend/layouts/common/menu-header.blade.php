<nav class="header-secondary navbar bg-faded shadow">
    <div class="navbar-collapse">
        <a class="navbar-heading hidden-md-down" href="{{ route('backend.index.index') }}">
        <span>Dashboard / @yield('menu')</span>
        </a>
        <ul class="nav navbar-nav pull-xs-right">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('backend.index.index') }}">
                    <i class="material-icons" aria-hidden="true">
                      dashboard
                    </i> Dashboard
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{ route('backend.apps.index') }}">
                    <i class="material-icons" aria-hidden="true">
                      apps
                    </i> Apps
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{ route('backend.submitted-apps.index') }}">
                    <i class="material-icons" aria-hidden="true">
                      developer_mode
                    </i> Submitted Apps
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{ route('backend.category.index') }}">
                    <i class="material-icons" aria-hidden="true">
                      list
                    </i> Categories
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="{{ route('backend.pages.index') }}">
                    <i class="material-icons" aria-hidden="true">
                      pages
                    </i> Pages
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('backend.translation') }}">
                    <i class="material-icons" aria-hidden="true">
                      translate
                    </i> Translation
                </a>
            </li>

            <div class="nav-item nav-link dropdown ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="material-icons" aria-hidden="true">
                      settings
                    </i> Settings
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('backend.settings.general') }}">
                        <i class="material-icons" aria-hidden="true">
                        settings
                        </i> General
                    </a>

                    <a class="dropdown-item" href="{{ route('backend.sitemap.index') }}">
                        <i class="material-icons" aria-hidden="true">
                        format_list_bulleted
                        </i> Generate Sitemap
                    </a>
                    <a class="dropdown-item" href="{{ route('backend.setting.usermgt') }}">
                        <i class="material-icons" aria-hidden="true">
                        people
                        </i> User Management
                    </a>
                    <a class="dropdown-item" href="{{ route('backend.setting.featuredApp') }}">
                        <i class="material-icons" aria-hidden="true">
                            apps
                        </i> Featured App Setup
                    </a>
                    <a class="dropdown-item" href="{{ route('backend.setting.adsmgt') }}">
                        <i class="material-icons" aria-hidden="true">
                            attach_money
                        </i> Advertisement
                    </a>
                </div>
            </div>

            
        </ul>
    </div>
</nav>