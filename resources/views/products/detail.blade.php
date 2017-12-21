@extends('common.master')

@section('title','detail')

@section('content')
    <div class="col-lg-12 contentBox" id="detail">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>产品详情</h3>
            </div>
            @include('common.errors')
        <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="">
                    <form method="post" action="/products/{{$product->model}}/{{$lanProduct->language_id}}/update" class="form-horizontal">
                       {{csrf_field()}}
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">产品名称:</label>
                            <div class="col-sm-8">
                                <input type="text" name="product_name" class="form-control" id="name" value="{{$lanProduct->product_name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="model" class="col-sm-2 control-label">产品model:</label>
                            <div class="col-sm-8">
                                <input disabled type="text" name="model" class="form-control" id="model" value="{{$product->model}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category" class="col-sm-2 control-label">当前分类:</label>
                            <div class="col-sm-8">
                                <input disabled type="text" name="category" class="form-control" id="category" value="{{$product->category_name->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">产品原价:</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price" value="{{$product->price}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="special_price" class="col-sm-2 control-label">产品现价:</label>
                            <div class="col-sm-8">
                                <input type="text" name="special_price" class="form-control" id="special_price" value="{{$product->special_price}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_description" class="col-sm-2 control-label">产品描述:</label>
                            <div class="col-sm-8">
                                    <textarea name="product_description" rows="4" class="form-control" id="product_description" >
                                          {{$lanProduct->product_description}}
                                    </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="updated_at" class="col-sm-2 control-label" >最后一次修改时间:</label>
                            <div class="col-xs-2">
                                <input disabled type="text" class="form-control" id="updated_at" value="{{$lanProduct->updated_at}}">
                            </div>
                        </div>
                        <br>
                        <div class="form-group" style="text-align: center">
                            <a class="btn btn-danger" href="/products/{{$product->model}}/{{$lanProduct->language_id}}/delete">
                                <i class="fa fa-trash-o fa-lg"></i> 删除产品
                            </a>
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-pencil"></i> 更新产品
                            </button>
                        </div>

                    </form>



                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
@endsection

@section('foot-js')
    @if(session('update'))
        <script>
            swal('','成功修改产品信息!','success')
        </script>
    @endif
    @if(session('updateFail'))
        <script>
            swal('','成功修改产品失败!','error')
        </script>
    @endif
@endsection
