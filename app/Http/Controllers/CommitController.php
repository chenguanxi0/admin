<?php

namespace App\Http\Controllers;

use App\Commit;
use App\Language;
use Illuminate\Http\Request;

class CommitController extends Controller
{
    public function index(Request $request)
    {
        $is_usable = $request->is_usable;

        if ($is_usable == null){ //所有评论

            $commits = Commit::query()->orderBy('is_usable','desc')->paginate(10);
        }else{

            $commits = Commit::query()->where('is_usable',$is_usable)->paginate(10);
        }


      return view('commits/index',compact('commits'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'GET'){
            $languages = Language::all();
            return view('commits/add',compact('languages'));
        }
        $this->validate($request,[
            'model'=>'required|integer',
            'language_id'=>'required|integer',
            'username'=>'required|string',
            'content'=>'required|string',
        ]);
        $commit = new Commit();
        $commit->content = $request->content;
        $commit->model = $request->model;
        $commit->star = $request->star;
        $commit->language_id = $request->language_id;
        $commit->is_common = $request->is_common == true ? 1 : false;
        $commit->is_admin = true;
        $commit->username = $request->username;

        $commit->save();

        return redirect('commits')->with('add',1);
    }


}
