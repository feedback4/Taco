<aside class="main-sidebar sidebar-dark-primary fixed elevation-4">
    <a href="{{route('home')}}" class="brand-link text-center">
        <span class="brand-text font-weight-light ">
        <b>Taco</b> system
    </span>
    </a>
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('home')}}">
                        <i class='bx bxs-dashboard bx-xs' ></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header ">Interface</li>
                <li class="nav-item has-treeview">
                    <a class="nav-link  " href="">
                        <i class='bx bxs-user-detail bx-xs' ></i>
                        <p>
                            Users
                            <i class='bx bxs-left-arrow right' ></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('users.index')}}">
                                <i class=" "></i>
                                <p>
                                    Manage Users
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('roles.index')}}">
                                <i class=" "></i>
                                <p>
                                    Manage Roles
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview ">
                    <a class="nav-link  " href="">
                        <i class="bx bx-atom bx-xs"></i>
                        <p>
                            Formulas
                            <i class='bx bxs-left-arrow right' ></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('formulas.index')}}">
                                <p>
                                    Manage Formulas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('elements.index')}}">
                                <p>
                                    Manage Elements
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('categories.index')}}">
                                <p>
                                    Manage Categories
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview ">
                    <a class="nav-link  " href="">
                        <i class='bx bx-network-chart bx-xs'></i>
                        <p>
                            Production
                            <i class='bx bxs-left-arrow right' ></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('404')}}">
                                <p>
                                    Manage Production
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('404')}}">
                                <p>
                                    Manage Products
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="{{route('404')}}">
                                <p>
                                    Manage Projects
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('inventory')}}">
                        <i class='bx bx-box bx-xs' ></i>
                        <p>
                            Inventory
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('accounting')}}">
                        <i class='bx bx-line-chart bx-xs' ></i>
                        <p>
                            Accounting
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('dropbox')}}">
                        <p>
                            <i class='bx bxl-dropbox bx-xs' ></i>
                            Dropbox
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="{{route('setting')}}">
                        <p>
                            <i class='bx bx-cog bx-xs' ></i>
                            Setting
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>
