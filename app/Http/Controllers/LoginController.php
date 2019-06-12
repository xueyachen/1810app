<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\model\Login;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    public function login(){
//        redis::set('a',1);
//        $a=redis::get('a');
//        var_dump($a);die;

        $data=[
            'u_name'=>'aa',
            'u_pwd'=>123
        ];
//        $res=DB::table('login')->insertGetId($data);
        $res=Login::insertGetId($data);
        var_dump($res);
    }
}
