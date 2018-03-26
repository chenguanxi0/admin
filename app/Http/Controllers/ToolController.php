<?php

namespace App\Http\Controllers;

use App\MyClass\timeDeal;
use App\Brand;
use App\Category;
use App\Product;
use App\Product_description;
use App\Commit;
use App\Language;
use App\UploadLog;
use App\Web;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use App\classic\DbManage;

class ToolController extends Controller
{
    public function index()
    {
       return view('tool/index');
    }
    public function uploadList()
    {
       $uploadLogs = UploadLog::all();
       return view('tool/uploadList',compact('uploadLogs'));
    }
    public function logDelete(UploadLog $uploadLog)
    {
        $uploadLog->delete();
        return back()->with('delete',1);
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

        //1.首先查询网站的语言
        $web = Web::query()->where('url',str_replace('www.','',$request->url))->first();

        //2.调用相应语言的model的评论
        if ($web){

            $language_id = $web->language_id;
            $brand_id = $web->brand_id;

            $num = Product::query()
                ->where('model',$request->model)
                ->first()->commitsNum;

            $modelCommits = Commit::query()
                ->where('model',$request->model)
                ->where('language_id',$language_id)
                ->orderBy('id','desc')->get()->take($num);

            return response()->json($modelCommits);
        }

    }
    public function updateBatch($tableName = "", $multipleData = array()){

        if( $tableName && !empty($multipleData) ) {

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE ".$tableName." SET ";
            foreach ( $updateColumn as $uColumn ) {
                $q .=  $uColumn." = CASE ";

                foreach( $multipleData as $data ) {
                    $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
                }
                $q .= "ELSE ".$uColumn." END, ";
            }
            foreach( $multipleData as $data ) {
                $whereIn .= "'".$data[$referenceColumn]."', ";
            }
            $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }

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
        $this->validate($request,[
            'name'=>'string|required|unique:brands'
        ]);
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->save();
        return redirect()->back()->with('success',1);
    }
    public function languageAdd(Request $request)
    {
        if ($request->method() == 'GET'){
            return view('tool/languageAdd');
        }
        $this->validate($request,[
            'name'=>'string|required|unique:languages',
            'code'=>'string|required|unique:languages',
        ]);
        $language = new Language;
        $language->name = $request->name;
        $language->code = $request->code;
        $language->save();
        return redirect()->back()->with('success',1);
    }

    public function zip()
    {
        $filename = str_replace('\\', '/', public_path()).'/storage/mk/2017032211095413531.jpg';
        Zipper::make('storage/zip/test.zip')->add($filename)->close();
        dd($filename);
    }
}
