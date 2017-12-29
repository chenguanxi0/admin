@extends('common.master')
@section('title','commits')
@section('content')
   <div class="col-lg-12 contentBox" id="list">
      <div class="panel panel-default">

         <div class="panel-heading">
            <h3>评论列表</h3>


            <br class="clearBoth">
         </div>

      @include('common.errors')
      <!-- /.panel-heading -->
         <div class="panel-body">
            <div class="table-responsive">
               <table class="table table-hover">
                  <thead>
                  <tr>
                     <th>model</th>
                     <th>语言</th>
                     <th>用户名</th>
                     <th>评论内容</th>
                     <th>星级</th>
                     <th>是否通用</th>
                     <th>是否可用</th>
                     <th>来源</th>
                  </tr>
                  </thead>
                  <tbody>
                     @foreach($commits as $k=>$commit)
                        <tr>
                           <td>{{$commit->model}}</td>
                           <td>{{$commit->language_id}}</td>
                           <td>{{$commit->username}}</td>
                           <td>{{$commit->content}}</td>
                           <td>{{$commit->star}}</td>
                           <td>
                              @if($commit->is_usable == 0)
                                 <span class="btn btn-danger">不可用</span>
                              @else
                                 <span class="btn btn-primary">可用</span>
                              @endif
                           </td>
                           <td></td>
                           <td></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>

            </div>

         </div>
         <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
   </div>
@endsection

@section('foot-js')

   @if(session('add'))
      <script>
          swal('','评论添加成功!','success')
      </script>
   @endif

@endsection