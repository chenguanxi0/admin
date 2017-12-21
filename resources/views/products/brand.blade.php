<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Laravel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/sb-admin-2.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
    <link rel="stylesheet" href="/css/app.css">

</head>

<body>
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
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>

                    <a data-toggle="collapse" data-parent="#side-menu"
                       href="#collapseTwo"><i class="fa fa-wrench fa-fw"></i> 产品管理<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level panel-collapse collapse" id="collapseTwo">
                        <li>
                            <a href="panels-wells.html">Panels and Wells</a>
                        </li>
                        <li>
                            <a href="buttons.html">Buttons</a>
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
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">产品列表</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>产品列表</span>
                    <a href="/excel/onImport" class="right btn btn-primary import" >导入</a>&nbsp;
                    <a href="/excel/onExport" class="right btn btn-danger export">导出</a>

                    <form action="/excel/import" method='post' enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="file" class="col-md-4 control-label">请选择文件</label>

                            <div class="col-md-6">
                                <input id="fileId1" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> 确认上传
                                </button>

                            </div>
                        </div>
                    </form>

                    <br class="clearBoth">
                </div>
                @if(count($errors)>0)
                    <div class="alert alert-info">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>产品名称</th>
                                <th>model</th>
                                <th>原价</th>
                                <th>现价</th>
                                <th>图片地址</th>
                                <th>分类</th>
                                <th>语言</th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach($products as $product)
                                @if(count($product) > 1)
                                    @foreach($product as $k=>$v)
                                        @if($v->language_id == 1)
                                            <tr>
                                                <td>{{$v->name}}</td>
                                                <td>{{$v->model}}</td>
                                                <td>{{$v->price}}</td>
                                                <td>{{$v->special_price}}</td>
                                                <td>{{$v->image}}</td>
                                                <td>{{$v->category_id}}</td>
                                                <td>
                                                    @foreach($v->samep as $vv)
                                                        <a href="/{{$vv->model}}/{{$vv->language_id}}">{{$vv->languageName($vv->language_id)}}</a>&nbsp;
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @elseif(count($product) == 1)
                                    <tr>
                                        <td>{{$product[0]->name}}</td>
                                        <td>{{$product[0]->model}}</td>
                                        <td>{{$product[0]->price}}</td>
                                        <td>{{$product[0]->special_price}}</td>
                                        <td>{{$product[0]->image}}</td>
                                        <td>{{$product[0]->category_id}}</td>
                                        <td><a href="/{{$product[0]->model}}/{{$product[0]->language_id}}">{{$product[0]->languageName($product[0]->language_id)}}</a></td>
                                    </tr>
                                @endif
                            @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

</div>


<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/sweetalert.min.js"></script>

@if(session('success'))
    <script>
        swal('','数据上传成功!','success')
    </script>
@endif
</body>


</html>