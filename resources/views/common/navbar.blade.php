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
                            <a data-toggle="collapse" href="#collapseMy2">所有产品<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level panel-collapse collapse" id="collapseMy2">
                                <li>
                                    <a href="/products/list?is_usable=1">可用产品</a>
                                </li>
                                <li>
                                    <a href="/products/list?is_usable=0">已下架评论</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/products/store">创建产品</a>
                        </li>
                        <li>
                            <a href="/tool/readme">上传说明</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#side-menu"
                       href="#collapseThree"><i class="fa fa-edit fa-fw"></i> 评论管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level panel-collapse collapse" id="collapseThree">
                        <li>
                            <a data-toggle="collapse" href="#collapseMy">所有评价<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level panel-collapse collapse" id="collapseMy">
                                <li>
                                    <a href="/commits?is_usable=1">可用评论</a>
                                </li>
                                <li>
                                    <a href="/commits?is_usable=0">不可用评论</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="/commits/add">添加评论</a>
                        </li>
                        <li>
                            <a href="/tool/readme">上传说明</a>
                        </li>

                    </ul>

                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#side-menu"
                       href="#collapseSeven"><i class="fa fa-random fa-fw "></i> 分类管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level panel-collapse collapse" id="collapseSeven">
                        <li>
                            <a href="/categorys">所有分类</a>
                        </li>
                        <li>
                            <a href="/categorys/add">添加分类</a>
                        </li>
                    </ul>

                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#side-menu"
                       href="#collapseFive"><i class="fa fa-file fa-fw "></i> 网站管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level panel-collapse collapse" id="collapseFive">
                        <li>
                            <a href="/tool/category">所有网站</a>
                        </li>
                        <li>
                            <a href="/webs/add">新建网站</a>
                        </li>
                    </ul>

                </li>
                <li>
                    <a data-toggle="collapse" data-parent="#side-menu"
                       href="#collapseFour"><i class="fa fa-cog  fa-fw"></i> 工具<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level panel-collapse collapse" id="collapseFour">
                        <li>
                            <a href="/tool/category">分类</a>
                        </li>
                        <li>
                            <a href="/tool/commit">评论</a>
                        </li>
                        <li>
                            <a href="/tool/brand/add">添加品牌</a>
                        </li>
                        <li>
                            <a href="/tool/backupbtn">备份/恢复</a>
                        </li>


                    </ul>

                </li>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
