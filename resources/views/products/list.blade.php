@extends('common.master')

@section('title','list')

@section('content')
    <div class="col-lg-12 contentBox" id="list">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3>产品列表</h3>
                <form action="/excel/import" method='post' enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <button type="submit" class="btn btn-primary" style="float: right;">
                                <i class="fa fa-btn fa-sign-in"></i> 确认上传
                            </button>
                        <div class="col-md-2" style="float: right;">
                            <input id="fileId1" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file"/>
                        </div>
                    </div>
                </form>
                <form action="/products/list" method="post">
                    <select name="language_id" id="language_id" onchange="getvalue(this)">
                            <option value="all">所有语言</option>
                        @foreach($languages as $language)
                            <option value="{{$language->id}}">{{$language->code}}</option>
                        @endforeach
                    </select>
                    <select  name="category_id" id="category_id">

                    </select>
                </form>
                <br class="clearBoth">
            </div>

        @include('common.errors')
        <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>状态</th>
                            <th>产品名称</th>
                            <th>model</th>
                            <th>原价(美元)</th>
                            <th>现价(美元)</th>
                            <th>图片地址</th>
                            <th>当前分类</th>
                            <th>语言</th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($products as $product)

                            <tr>
                                <td>
                                    @if($product->is_usable == 0)
                                    <span class="btn btn-danger">已下架</span>
                                    @else
                                        <span class="btn btn-primary">可用</span>
                                    @endif
                                </td>
{{--                                <td>{{$product->language_description_1()[0]->product_name}}</td>--}}
                                <td>{{$product->model}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->special_price}}</td>
                                <td><img src="/storage/{{$product->image}}" alt="" width="50"></td>
                                <td id="{{$product->category_id}}">{{$product->category_name->name}}</td>
                                <td>

                                    @foreach($product->product_description as $language_id)
                                        <a class="btn btn-info" href="/products/{{$product->model}}/{{$language_id->languageName->id}}">{{$language_id->languageName->code}}</a>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
@endsection

@section('foot-js')
    @if(session('success'))
        <script>
            swal('','数据上传成功!','success')
        </script>
    @endif
    @if(session('hasProduct'))
        <script>
            swal('','产品重复!','success')
        </script>
    @endif
    @if(session('delete'))
        <script>
            swal('','成功删除产品!','success')
        </script>
    @endif
    @if(session('cateIsNull'))
        <script>
            swal('分类不存在','请检查表中分类','error')
        </script>
    @endif

    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
        function getvalue(){
            if($('#language_id').val() == 'all'){
                window.location.reload();
            }
                $.ajax({
                    type: "POST",
                    url: "/products/ajax/language",
                    data: {language_id:$('#language_id').val()},
                    dataType: "json",
                    success: function(data){
                        var string = '';
                        $.each( data, function(index, content)
                        {
                            string += '<option value='+content.category_id+'>'+content.name+'</option>';
                            $('#category_id').html(string);
//                            console.log( "the man's no. is: " + index + ",and " + content.name + " is learning " + content.category_id );
                        });
                    }
                });
        }
    </script>
@endsection
