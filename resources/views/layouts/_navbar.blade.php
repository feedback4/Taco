<nav class="main-header navbar    navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class='bx bx-menu bx-sm'></i>
                <span class="sr-only">Toggle navigation</span>
            </a>
        </li>


    </ul>

    <ul class="navbar-nav ml-auto">


        <li class="nav-item">


            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>


            <div class="navbar-search-block">
                <form class="form-inline" action="#" method="get">
                    <input type="hidden" name="_token" value="7L6mHsRSyMsVbzBg26D9bf2O4gCgjVtmZqn5Dg1H">

                    <div class="input-group">


                        <input class="form-control form-control-navbar" type="search" name="adminlteSearch"
                               placeholder="search" aria-label="search">


                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                    </div>
                </form>
            </div>

        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>


        <li class="nav-item dropdown user-menu">


            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span>
            admin
        </span>
            </a>


            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                <li class="user-footer">
                    <a class="btn btn-default btn-flat float-right  btn-block " href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-fw fa-power-off"></i>
                        Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        @csrf

                    </form>
                </li>

            </ul>

        </li>


    </ul>

</nav>

