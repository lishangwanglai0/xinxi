<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/9
 * Time: 16:24
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Admin\Information;
use App\Repository\Admin\InformationRepository;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumb[] = ['title' => '信息发布管理', 'url' => route('admin::Information.index')];
    }
        public function index()
    {
        $this->breadcrumb[] = ['title' => '信息发布列表', 'url' => ''];
        return view('admin.info.info_list', ['breadcrumb' => $this->breadcrumb]);
    }

    /**
     * 列表数据
     * @param Request $request
     * @return array
     * @author guoyang
     * @date 2020/3/10  11:43
     */
    public function infoList(Request $request)
    {

        $keyword=$request->only('info_title');
        $page_index=$request->only('page_index') ? $request->only('page_index') : 1;
        $page_amount=$request->only('page_amount') ? $request->only('page_amount'): env('PAGE_LIMIT',18);
        if(!empty($keyword)) $condition['info_title']='%'.$keyword['info_title'].'%';
        $condition['info_status']=1;
        $condition['info_audit']=1;
        $result=InformationRepository::getAdminList($condition,$page_amount,$page_index);

        return $result;
    }

    /**
     * 更新
     * @param Request $request
     * @return mixed
     * @author guoyang
     * @date 2020/3/10  11:55
     */
    public function updateInfo(Request $request)
    {
        $data=$request->only('keyword');
        $state=$request->only('number');
        $info_id=$request->only('info_id');
        if($data['keyword']=='info_status') $state['number']=0;

        $result=[$data['keyword']=>$state['number'],'updated_at'=>time()];
        $res=(new Information())->saveData($info_id,$result);
        return return_message($res);
    }

    /**
     * 更新页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author guoyang
     * @date 2020/3/10  12:04
     */
    public function updateInfoPage(Request $request)
    {
        $info_id=$request->only('info_id');
        $this->breadcrumb[] = ['title' => '信息审核', 'url' => ''];
        $model =InformationRepository::find($info_id['info_id']);
        $info_resource_image=explode(',',$model['info_resource']);
        $info_partner_image=explode(',',$model['info_partner']);
        return view('admin.info.info_detail', ['id' => $info_id['info_id'],'info_partner_image'=>$info_partner_image,'info_resource_image'=>$info_resource_image, 'model' => $model, 'breadcrumb' => $this->breadcrumb]);

    }
}