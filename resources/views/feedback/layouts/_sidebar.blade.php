<aside class="main-sidebar sidebar-dark bg-gradient-navy text-white fixed elevation-4">
    <a href="{{route('feedback.dashboard')}}" class="brand-link text-center">
        <span class="brand-text font-weight-light ">
        <b>Admin</b> system
    </span>
    </a>
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar  flex-column " data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a class="nav-link  text-white" href="{{route('feedback.dashboard')}}">
                        <i class='bx bxs-dashboard bx-xs' ></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header ">Interface</li>
                <li class="nav-item has-treeview">
                    <a class="nav-link text-white " href="">
                        <i class='bx bxs-user-detail bx-xs' ></i>
                        <p>
                            Admins
                            <i class='bx bxs-left-arrow right' ></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link  text-white" href="{{route('feedback.admins.index')}}">
                                <i class=" "></i>
                                <p>
                                    Manage Admins
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  text-white" href="{{route('feedback.roles.index')}}">
                                <i class=" "></i>
                                <p>
                                    Manage Roles
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview menu-is-opening menu-open">
                    <a class="nav-link  text-white" href="">
                        <i class="bx bx-money bx-xs"></i>
                        <p>
                            Tenants
                            <i class='bx bxs-left-arrow right' ></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a class="nav-link  text-white" href="{{route('feedback.tenants.index')}}">
                                <p>
                                    Manage Tenants
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
    </div>

</aside>
