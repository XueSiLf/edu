<?php
namespace app\index\controller;

use app\index\controller\Base;

use think\Request;

use app\index\model\User as UserModel;

class User extends Base
{
	// 登录界面
    public function login()
    {
        return $this->view->fetch();
    }

    // 验证登录
    // $this->validate($data, $rule, $msg)
    public function checklogin(Request $request)
    {
    	// 初始化返回参数
    	$status = 0;
    	$result = '';
    	
        if($request->isPost())
        {
        	$data = $request->param();
        	// dump($data);
        	// die;

        	// 创建验证规则
        	$rule = [
        		'name|用户名'=>'require', //用户名不能为空
        		'password|密码'=>'require', //密码不能为空
        		'verify|验证码'=>'require|captcha', // 验证码
        	];

        	// 自定义验证失败的提示信息
        	$msg = [
        		'name'=>['require'=>'用户名不能为空,请检查'],
        		'password'=>['require'=>'密码不能为空,请检查'],
        		'verify'=>[
        			'require'=>'验证码不能为空,请检查',
        			'captcha'=>'验证码错误',
        		],
        	];


        	// 进行验证
        	$result = $this->validate($data,$rule,$msg);
        	// dump($result);
        	// die;

        	//如果验证通过则执行
        	if($result === true)
        	{
        		// 构造查询条件
        		$map = [
        			'username'=>$data['name'],
        			'password'=>md5($data['password']),
        		];
        		// 查询用户信息
        		$res = UserModel::get($map);
        		dump($res);
        		die;
        		if($res){
        			$status = 1;
        			$result = '验证通过，点击[确定]进入后台';
        		}else{
        			$result = '没有找到该用户！';
        		}

        	}

        }
        return ['status'=>$status,'message'=>$result,'data'=>$data];


    }

    // 退出登录
    public function logout()
    {

    }
}
