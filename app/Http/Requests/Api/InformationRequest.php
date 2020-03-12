<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/9
 * Time: 17:44
 */

namespace App\Http\Requests\Api;


use App\Model\Admin\Information;
use App\Model\Admin\Recruit;

class InformationRequest
{
    public function addInfoRequest($postData)
    {
        if(!$postData['info_title']){
            return '商品标题不能为空';
        }


        if(!$postData['clearing_form']){
            return '商品类型不能为空';
        }
        if(!in_array($postData['clearing_form'],[1,2,3,4,5,6])){
            return '商品类型参数不正确';
        }
        if(!$postData['info_resource']){
            return '商品主图不能为空';
        }
        if(!$postData['info_partner']){
            return '商品轮播图不能为空';
        }
        if(!$postData['info_type']){
            return '生产类型不能为空';
        }
        if(!$postData['info_number']){
            return '商品数量不能为空';
        }
//        if(!preg_match("/^1[34578]{1}\d{9}$/",$postData['info_mobile'])){
//            return '手机号不正确，请重新输入';
//        }
        if(!$postData['user_id']){
            return '用户id不能为空';
        }
        $res=(new Information())->getdetailInfo(['info_title'=>$postData['info_title']]);
        if(!empty($res)){
            return '商品标题有重复，请重新输入标题';
        }
        return 1;
    }

    public function addRecruitRequest($postData)
    {
        if(!in_array($postData['r_type'],[1,2,3])){
            return '分类id错误';
        }
        if(!$postData['r_designation']){
            return '名称不能为空';
        }
        if(!$postData['r_email']){
            return '邮箱不能为空';
        }
        if(!preg_match("/^1[34578]{1}\d{9}$/",$postData['r_mobile'])){
            return '手机号不正确，请重新输入';
        }
        if(!$postData['r_mobile']){
            return '手机号不能为空';
        }
        if(!$postData['r_address']){
            return '地址不能为空';
        }
        if(!$postData['r_type']){
            return '分类id不能为空';
        }


        $res=(new Recruit())->where(['r_mobile'=>$postData['r_mobile'],'r_type'=>$postData['r_type']])->first();
        if(!empty($res)){
            $data=json_decode( json_encode( $res),true);
            if($data['r_mobile']==$postData['r_mobile']) return '系统已收到此手机号的信息，请更换手机号';
        }
        return 1;
    }



}