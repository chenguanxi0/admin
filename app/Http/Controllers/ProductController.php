<?php

namespace App\Http\Controllers;

use App\Product;
use App\Product_description;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    //品牌选择
    public function brand()
    {
        return view('products/brand');
    }
    //产品列表
    public function productsList()
    {
        $products = Product::query()->paginate(10);
        return view('products/list',compact('products'));
    }
    //产品详情
    public function detail($model,$language_id)
    {
        //产品的公共信息
        $product = Product::where('model',$model)->first();

        //产品带语言的信息
        $lanProduct = $product->product_description->where('language_id',$language_id)->first();

        return view('products/detail',compact('product','lanProduct'));
    }
    //创建产品
    public function store(Request $request)
    {

       if ($request->method() == 'GET'){
           return view('/products/store');
       }else{

       }
    }
    //删除产品
    public function delete($model,$language_id)
    {
        $result = Product_description::where('product_model',$model)->where('language_id',$language_id)->delete();
        $model_2 = Product_description::where('product_model',$model)->get();
        if (!$model_2->first()){
            Product::where('model',$model)->delete();
        }
        return redirect('products/list')->with('delete',true);
    }
    //修改产品
    public function update($model,$language_id,Request $request)
    {
        //验证
        $this->validate($request,[
            'special_price'=>'nullable',
            'price'=>'required',
            'product_name'=>'required'
        ]);

        //product表
        $data_1['special_price'] = $request->special_price;
        $data_1['price'] = $request->price;
        $product = new Product;

        $data_2['product_name'] = $request->product_name;
        $data_2['product_description'] = $request->product_description;
        $product_description = new Product_description;


        if ($product->where('model',$model)->update($data_1) && $product_description->where('product_model',$model)->update($data_2)){
            return redirect()->back()->with('update',true);
        }else{
            return redirect()->back()->with('updateFail',true);
        }

        //product_description表
    }
    //搜索产品
    public function search(Request $request)
    {
        //根据名字和model来搜索产品
        $products = Product_description::where('product_model','like','%'.$request->search.'%')
            ->orWhere('product_name','like','%'.$request->search.'%')->paginate(10);

        //将peoduct_description模型 转为product模型
        foreach ($products as $k=>$v){
            $products[$k] = $v->product;
            }

        $products->setPath('?search='.$request->search);
        return view('search',compact('products'));
    }
}
