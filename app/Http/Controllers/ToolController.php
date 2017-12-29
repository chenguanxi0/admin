<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Category_description;
use App\Commit;
use App\Product_commit;
use App\Web;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use App\classic\DbManage;

class ToolController extends Controller
{
    public function index()
    {
       return view('tool/index');
    }
    public function uploadImages(Request $request)
    {

        if ($request->method() == 'GET'){
            return view('tool/uploads');
        }
        $name = Input::file('uploadfile')->getClientOriginalName();
        $path = $request->file('uploadfile')->storeAs('brands',$name);
        return redirect()->back()->with('upload',1);
    }
    public function category(Request $request)
    {
        $cd = Category_description::where('name','Adidas')->first();
//        dd($cd->findCategory->allChildrenCategorys);

        $categorys_1 = Category::with('allChildrenCategorys')->find(1);
        $categorys_1 = $categorys_1->toArray();
        $res[0] = $categorys_1;
        $categorys = $this->tree2html($res);
        return view('tool/category',compact('categorys'));

    }
    public function readme()
    {
       return view('tool/readme');
    }

    //
    public function tree2html($tree) {
        echo '<ul>';
        foreach($tree as $leaf) {
            echo '<li>' .'<a href='.$leaf['id'].'>'.$leaf['name'].'</a>';
            if(! empty($leaf['all_children_categorys'])) $this->tree2html($leaf['all_children_categorys']);
            echo '</li>';
        }
        echo '</ul>';
    }
    public function getChildId()
    {

    }
    public function commit(Request $request)
    {
        //先判断是否有此产品的评论
        $p = Commit::where('model',$request->model)->get();
        $web = Web::where('url',$request->url)->get()->toArray();
        $language_id = $web ? $web[0]['language_id'] : 1 ;
        if ($p->first()){
            //存在该产品的评论，直接掉评论
                $commits=Commit::query()
                    ->where('model',$request->model)
                    ->where('language_id',$language_id)
                    ->take(6)
                    ->orderBy('created_at','desc')
                    ->get()
                    ->toArray();

        }else{
            //不存在就直接调用通用评论
            $commits=Commit::query()
                ->where('is_common',1)
                ->where('language_id',$language_id)
                ->take(6)
                ->orderBy('created_at','desc')
                ->get()
                ->toArray();
        }
        return response()->json($commits);
    }

    public function backupsql()
    {

        $mysql = Config::get('database.connections.mysql'); //从配置文件中获取数据库信息
   //分别是主机，用户名，密码，数据库名，数据库编码
        $db = new DBManage ( 'localhost', $mysql['username'], $mysql['password'], $mysql['database'], 'utf8' );
   // 参数：备份哪个表(可选),备份目录(可选，默认为backup),分卷大小(可选,默认2000，即2M)

        $filename = '/storage/sql/'.$db->backup('','storage/sql/',2000);

        return $filename;
    }
    public function backupbtn()
    {
        $filename = $this->backupsql();
        return view('tool/backupbtn',compact('filename'));
    }
    public function brandAdd(Request $request)
    {
        if ($request->method() == 'GET'){
            return view('tool/brandAdd');
        }
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->save();
        return redirect()->back()->with('success',1);
    }


}
