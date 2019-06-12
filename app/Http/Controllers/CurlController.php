<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;//引用Guzzle
class CurlController extends Controller
{
    public function curl_get()
    {
        //访问百度
        $url = "http://www.baidu.com";
        //1.初始化
        $ch = curl_init($url);
        //2.设置参数    TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//0是false  1是true    用于控制浏览器输出  get用false
        //3.执行会话
        curl_exec($ch);
        //4.关闭会话
        curl_close($ch);
    }

    //获取token
    public function curl_token()
    {
        $access_token = cache('access_token');
        if (!empty($access_token)) {
            echo 1;
            return $access_token;
        } else {
            $appid = 'wx69b81371703b53cb';
            $secret = '7943e9fb73c9e07ffb4ca1b9c279f634';
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
            //1.初始化
            $ch = curl_init($url);
            //2.设置参数
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //3.执行会话
            $data = curl_exec($ch);
            //4.关闭会话
            curl_close($ch);
            //5.处理数据
            $data = json_decode($data, true);
            cache(['access_token' => $data['access_token']],60 * 60 * 24 * 1);
            $access_token = cache('access_token');
            echo 2;
        }
    }

    public function curl3()
    {
//        echo 1;die;
//        print_r($_POST);

    }

    //表单测试
    public function form1()
    {
        return view('form.form1');
    }


    //自定义菜单
    public function menu()
    {
        $access_token = $this->curl_token();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
        //组装data数据
        $post_data = [
            "button"=>[
                [
                    "type"=>"view",
                    "name"=>"菜单",
                    "url"=>"https://www.baidu.com/"
                ]
            ]
        ];
        //将数组转换成json
        $post_data=json_encode($post_data,JSON_UNESCAPED_UNICODE);

        //初始化
        $ch=curl_init($url);
        //设置参数
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        //执行会话
        $data=curl_exec($ch);
        //检测错误
        $errno=curl_errno($ch);
        $errmsg=curl_error($ch);

        //关闭会话
        curl_close($ch);

        dd($data);
    }


    //上传文件 视图
    public function upload(){
        return view('form.upload');
    }
    //上传执行
    public function uploaddo(Request $request,$name){
        if ($request->file($name)->isValid()) {
            $photo = $request->file($name);
//            $extension = $request->$name->extension();
            $Extension=$request->image->getClientOriginalExtension();  //获取未处理的上传文件后缀
            $store_result = $photo->storeAs(date('Ymd'),date('YmdHis').rand(10,99).'.'.$Extension);
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
    //curl处理
    public function file(Request $request){
        if($request->hasFile('image')){
            $path=$this->uploaddo($request,'image');
        }

//        print_r(public_path()."/".$path);die;
//        $img="public/image/465ca76366bf2833f9aad0e8521637ad.jpg";
        $img=public_path()."/".$path;
        $url="http://www.1810lumen.com/upload";
        //1初始化
        $ch = curl_init();
        $post_data = array(
            'a'=>'Post',
            'c'=>'Api_Review',
            'file' => $img
        );
        //2设置参数
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);//设为 TRUE ，将在启用 CURLOPT_RETURNTRANSFER 时，返回原生的（Raw）输出
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);//数据
        curl_setopt($ch, CURLOPT_URL,$url);
        //3执行会话
        $info= curl_exec($ch);


        //检测错误
        $errno=curl_errno($ch);
        $errmsg=curl_error($ch);
//        var_dump($errno);
//        var_dump($errmsg);

        //4结束会话
        curl_close($ch);
//        print_r($info);

    }


    public function encryption(){
        $a='qwertyuiop';
        $b=base64_encode(serialize($a));
        $url="http://www.1810lumen.com/encryption";

        //使用Guzzle传值
        $clinet = new Client();
        $response = $clinet ->request("POST",$url,[
            'body'=>$b
        ]);
        echo $response->getBody();




        //初始化
//        $ch=curl_init($url);
//        //设置参数
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
//        curl_setopt($ch,CURLOPT_POST,true);
//        curl_setopt($ch,CURLOPT_POSTFIELDS,$b);
//        //执行会话
//        curl_exec($ch);
//        //检测错误
//        $errno=curl_errno($ch);
//        $errmsg=curl_error($ch);
//
//        //关闭会话
//        curl_close($ch);

    }


}
