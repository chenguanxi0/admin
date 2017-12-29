<?php

namespace App\Http\Controllers;

use App\Category;
use App\Category_description;
use App\Product;
use App\Product_description;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;


class ExcelController extends Controller
{
    //Excel文件导出功能 By Laravel学院
    public function export(){

//        echo chr(0xEF).chr(0xBB).chr(0xBF);   //只针对csv文件
        $cellData = [
            ['学号','姓名','成绩'],
            ['10001','AAAAA','99'],
            ['10002','BBBBB','92'],
            ['10003','CCCCC','95'],
            ['10004','DDDDD','89'],
            ['10005','EEEEE','96'],
        ];
        Excel::create('学生成绩',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }



    //Excel文件导入功能
    public function import(Request $request){

        //接受数据
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



        //products表操作
        foreach ($res as $k=>$v){
            $products[$k]['model'] = $v[1];
            $products[$k]['special_price'] = $v[5];
            $products[$k]['price'] = $v[4];
            $products[$k]['image'] = $v[3];

            //判断当前分类  默认存在一级分类
            $category_id = Category_description::where('name',$v[6])->first();

            if(!$category_id){
                return redirect()->back()->with('cateIsNull',1);
            }

            $products[$k]['category_id'] = $category_id->category_id;
            $products[$k]['created_at'] = date('Y-m-d H:i:s', time());
            $products[$k]['updated_at'] = date('Y-m-d H:i:s', time());
            //验证
            $validator = Validator::make($products[$k], [
                'model'=>'unique:products|required',
                'special_price'=>'nullable',
                'price'=>'required',
                'image'=>'nullable|string',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

        }

        DB::table('products')->insert($products);

        //product_descriptions表操作
        foreach ($res as $k=>$v){
                    $product_descriptions[$k]['product_model'] = $v[1];
                    $product_descriptions[$k]['language_id'] = $v[0];
                    $product_descriptions[$k]['product_name'] = $v[2];
                    $product_descriptions[$k]['product_description'] = $v[7];
                    $product_descriptions[$k]['created_at'] = date('Y-m-d H:i:s', time());
                    $product_descriptions[$k]['updated_at'] = date('Y-m-d H:i:s', time());

            //验证
            $validator = Validator::make($product_descriptions[$k], [
                'product_model'=>'required',
                'language_id'=>'required',
                'product_name'=>'required',
                'product_description'=>'nullable',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        DB::table('product_descriptions')->insert($product_descriptions);


        return redirect()->back()->with('success','上传成功');


}

}
