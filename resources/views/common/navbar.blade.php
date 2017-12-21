<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">产品管理后台</a>
    </div>
    <!-- /.navbar-header -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <form action="/search" method="get">

                            <input type="text" style="width: 81%" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </form>

                    </div>
                    <!-- /input-group -->
                </li>
                <li>

                    <a data-toggle="collapse" data-parent="#side-menu"
                       href="#collapseTwo"><i class="fa fa-wrench fa-fw"></i> 产品管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level panel-collapse collapse" id="collapseTwo">
                        <li>
                            <a href="/products/list">所有产品</a>
                        </li>
                        <li>
                            <a href="/products/store">创建产品</a>
                        </li>
                        <li>
                            <a href="notifications.html">Notifications</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="forms.html"><i class="fa fa-edit fa-fw"></i> 评价管理</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
