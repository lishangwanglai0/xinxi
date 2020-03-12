<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/12
 * Time: 13:46
 */
namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Repository\NodeRepository;

class NodeVerifyController extends BaseController
{

    public function receptionNode(Request $request)
    {
        $phone = $request->only('phone');
        $redis_code=$request->only('random');
        if(!empty($redis_code['random'])){
           $redis_code= $redis_code['random'];
        }else{
            return  return_jsonMessage('随机码不能为空');
        }
        if (!$phone['phone']) return  return_jsonMessage('手机号不能为空');
        if(!preg_match("/^1[3456789]{1}\d{9}$/",$phone['phone'])) return  return_jsonMessage('手机号错误，请重新输入');

        /** 限制时间 一分钟发一条*/
        $start_time=$this->redis->get($redis_code.'time') ?? 0;
        $end_time=time()-$start_time;

        if($end_time){
            if($end_time<900){
                return  return_jsonMessage('请求过快，请稍等');
            }
        }
        $start_number=$this->redis->get($redis_code.'number')?? 0;
        if($start_number>2){
            return  return_jsonMessage('今天请求次数过多，24小时候再试');

        }
        //生成六位随机数
        $code = rand(100000, 999999);
        //发送验证码
        $NoteCodeModel=new NodeRepository();
        $result=$NoteCodeModel->sendNode($phone['phone'],$code);
        $this->redis->set($redis_code.'code',$code);
        $this->redis->set($redis_code.'time',time());
        $this->redis->set($redis_code.'number',$start_number+1);
        if($result['Code']==='OK')
        {
            $this->redis->set($redis_code.'code',$code);
            $this->redis->set($redis_code.'time',time());
            $this->redis->set($redis_code.'number',$start_number+1);
            return  ['msg'=>'验证码发送成功,请注意查收!','data'=>$result['data'],'code'=>200];
        }else {
            return  ['msg'=>'验证码失败,请重新请求!','code'=>0];
        }
    }
}