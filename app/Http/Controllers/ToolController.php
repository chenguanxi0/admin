<?php

namespace App\Http\Controllers;


use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\App;
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
use Illuminate\Support\Facades\Storage;
use Mail;
use Maatwebsite\Excel\Facades\Excel;


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
        
    }
    public function optionsAdd(Request $request)
    {
        if ($request->method() == 'GET'){
//            $a = Storage::get('1.txt');
//            $b = json_decode($a,true);
//            dd($b);
//            dd(json_encode($a));
            return view('tool.optionsAdd');
        }

        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $_FILES;
        $excel_file_path = $file['file']['tmp_name'];
        $excel = App::make('excel');//excel类
        $excel->load($excel_file_path, function($reader) use( &$res ) {
            $reader = $reader->getSheet(0);
            $res = $reader->toArray();
            unset($res[0]);//去除表头
        });
//        dd($res);
        $url = $request->web;
        $optionName = $request->optionName;
        $language = $request->language;
        //products_options  第一张表
        $sql_1 = "INSERT INTO `products_options`(`products_options_id`, `products_options_name`) VALUES (0,'".$optionName."')";

        //products_options_values  第二章张表
        //products_options_values_to_products_options 第三张表
        $optionValuesArrs = array();
        $modelArrs = array();
        foreach ($res as $k=>$v){
            $modelArrs[$k+1]['model'] = $v[0];
            $singleArrs = explode('|',$v[1]);
            $modelArrs[$k+1]['option_value'] = $singleArrs;
           foreach ($singleArrs as $kk=>$vv){
               if (!in_array($vv,$optionValuesArrs)){
                   array_push($optionValuesArrs,$vv);
               }
           }
        }
        $sql_2 = "INSERT INTO `products_options_values` (`products_options_values_id`,`language_id`, `products_options_values_name`, `products_options_values_sort_order`) VALUES (1,".$language.",'--- please select ---',1)";
        $sql_3 = "INSERT INTO `products_options_values_to_products_options` ( `products_options_id`, `products_options_values_id`) VALUES (0,0)";
        for ($i=1;$i<=count($optionValuesArrs);$i++){
            $sql_2 .= ",('".($i+1)."',".$language.",'".$optionValuesArrs[$i-1]."',"."'".($i+1)."'".")";
            $sql_3 .= ",(0,".$i.")";
        }
        $ch = curl_init();
        /***在这里需要注意的是，要提交的数据不能是二维数组或者更高
         *例如array('name'=>serialize(array('tank','zhang')),'sex'=>1,'birth'=>'20101010')
         *例如array('name'=>array('tank','zhang'),'sex'=>1,'birth'=>'20101010')这样会报错的*/
        $data = array('sql_1' => $sql_1, 'sql_2' => $sql_2,'sql_3' => $sql_3,'modelArrs'=>json_encode($modelArrs),'optionValuesArrs'=>json_encode($optionValuesArrs));

        curl_setopt($ch, CURLOPT_URL, $url.'/options.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result){
            return back();
        }else{
            return false;
        }

    }

    public function optionsSql(Request $request){
        if ($request->method() == 'GET'){
            return view('tool.optionsSql');
        }
    }

    public function excelDel(Request $request)
    {
        if ($request->method() == 'GET'){
            return view('tool.excelDel');
        }

        if(!$request->hasFile('file')){
            exit('上传文件为空！');
        }
        $file = $_FILES;
        $excel_file_path = $file['file']['tmp_name'];
        $excel = App::make('excel');//excel类
        $excel->load($excel_file_path, function($reader) use( &$res ) {
            $reader = $reader->getSheet(0);
            $res = $reader->toArray();
//            unset($res[0]);//去除表头
        });
        
        $arr = array();
        foreach ($res as $k=>$v){
            $links = explode('|',$v[1]);
            foreach ($links as $kk=>$vv){
                array_push($arr,array($v[0],$vv));
            }
        }
        array_unshift($arr,['分类','link']);
        $res = Excel::create('link',function($excel) use ($arr){
            $excel->sheet('score', function($sheet) use ($arr){
                $sheet->rows($arr);
            });
        })->export('xls');


    }
    public function sourceCode()
    {
       $code = file_get_contents('http://zc043-en.esnmd.com');

           if(strpos($code,'<span style="display: none">OK</span>')){
               $name = '学院君';
               $flag = Mail::send('emails.test',['name'=>$name],function($message){
                   $to = '491788533@qq.com';
                   $message ->to($to)->subject('测试邮件');
               });
               if($flag){
                   echo '发送邮件成功，请查收！';
               }else{
                   echo '发送邮件失败，请重试！';
               }
           };

    }
}
