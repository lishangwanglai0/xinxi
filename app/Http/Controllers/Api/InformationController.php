<?php
/**
 * Created by PhpStorm=>'
 * User: lx
 * Date: 2020/3/9
 * Time: 16:30
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\InformationRequest;
use App\Model\Admin\Information;
use App\Model\Admin\Recruit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformationController extends BaseController
{
    const settle_type=[1=>'CPS模式', 2=>'CPA模式', 3=>'CPT模式', 4=>'CPC模式', 5=>'CPM模式', 6=>'ROI'];


    /**
     * 信息发布写入
     * @param InformationRequest $informationRequest
     * @author guoyang
     * @date 2020/3/9  16:52
     */
    public function addPostMessageInfo(Request $request)
    {
       $postData=$request->only('info_title','clearing_form','info_resource','info_partner','info_type','info_number','user_id');
        $res=(new InformationRequest())->addInfoRequest($postData);
        if($res===1){
            $postData['created_at']=time();
            $res=(new Information())->createInfo($postData);
        }
        return return_jsonMessage($res);
    }

    /**
     * 上传图片
     * @param Request $request
     * @return array
     * @author guoyang
     * @date 2020/3/10  19:07
     */
    public function uploadImg(Request $request)
    {
//        dd(storage_path());die;
        $a=$request->file('avatar');
        if(!$a){
            return ['code'=>0,'msg'=>'请上传图片'];
        }
        $data['path'] = $request->file('avatar')->store("avatars/".date('Y-m-d',time()),'admin_img');
        $data['path']= '/upload/image/'.$data['path'];
        $data['code']=200;
        return $data;

    }
    /**
     * 信息列表
     * @param Request $request
     * @return array
     * @author guoyang
     * @date 2020/3/9  19:24
     */
    public function getPostMessageInfo(Request $request)
    {
        $keyword=$request->only('keyword');
        $page_index=$request->only('page_index');
        $page_amount=$request->only('page_amount');
        $page_index= !empty($page_index['page_index']) ? $page_index['page_index'] : 1;
        $page_amount= !empty($page_amount['page_amount']) ? $page_amount['page_amount'] : env('PAGE_LIMIT',18);
        $condition['info_status']=1;
        $condition['info_audit']=2;
        $where='';
        if(!empty($keyword['keyword']))     $where=$keyword['keyword'];
        $result=(new Information())->getInfoList($condition,$where,$page_index,$page_amount);
        return return_jsonMessage($result);

    }

    /**
     * 获取详情
     * @param Request $request
     * @return array
     * @author guoyang
     * @date 2020/3/10  8:51
     */
    public function getdetailInfo(Request $request)
    {
        $info_id=$request->only('info_id');
        if(!$info_id['info_id']) return return_jsonMessage('id不能为空');
        $data=(new Information())->getdetailInfo($info_id);
        $data=json_decode( json_encode( $data),true);
        return return_jsonMessage($data);
    }

    /**
     * 新增招募
     * r_type 1合伙人招募  2交易时招募 3入驻企业招募
     * @param Request $request
     * @return array
     * @author guoyang
     * @date 2020/3/10  9:18
     */
    public function addRecruitInfo(Request $request)
    {
        $postData=$request->only('r_designation','r_email','r_mobile','r_address','r_type');
        $res=(new InformationRequest())->addRecruitRequest($postData);
        if($res===1){
            $postData['created_at']=time();
            $res=(new Recruit())->insert($postData);
        }
        return return_jsonMessage($res);
    }
}