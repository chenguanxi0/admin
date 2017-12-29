@extends('common.master')
@section('title','添加品牌')
@section('content')
    <div class="col-lg-12 contentBox" id="detail">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>添加品牌</h3>
            </div>
            @include('common.errors')
            <div class="panel-body">
                <form action="/tool/brand/add" method="post" class="form-horizontal">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">品牌名称:</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center">
                        <button type="submit" class="btn btn-success">添加</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop

@section('foot-js')

    @if(session('success'))
        <script>
            swal('','品牌创建成功!','success')
        </script>
    @endif
@endsection