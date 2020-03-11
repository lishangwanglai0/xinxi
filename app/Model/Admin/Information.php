<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/9
 * Time: 18:19
 */

namespace App\Model\Admin;


use App\Model\BaseModel;
use App\Repository\Searchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

//use App\Repository\Searchable;

class Information extends BaseModel
{
    use Searchable;
    protected $table='info_issues';
    protected $guard_name = 'admin';
    protected $primaryKey='info_id';

    public static $searchField = [
        'info_title' => '标题',
        'created_at' => [
            'showType' => 'datetime',
            'title' => '创建时间'
        ]
    ];

    public static $listField = [
        'info_title' => '标题',
        'info_status' => '状态',
        'info_linkman' => '联系人',
    ];
    /**
     *创建信息发布
     * @param $data
     * @return bool
     * @author guoyang
     * @date 2020/3/9  19:16
     */
    public function createInfo($data)
    {
       return DB::table('info_issues')->insert($data);
    }

    /**
     *信息列表
     * @param $condition
     * @param $page
     * @param $limit
     * @author guoyang
     * @date 2020/3/9  19:19
     */
    public function getInfoList($condition,$page,$limit)
    {
       return  $this->page_query($condition,$limit,$page,'updated_at','*');

    }



    /**
     * 获取详情
     * @param $condition
     * @return mixed
     * @author guoyang
     * @date 2020/3/9  19:51
     */
    public function getdetailInfo($condition)
    {
        return DB::table('info_issues')->where($condition)->first();
    }

    /**
     * 更新
     * @param $condition
     * @param $data
     * @return mixed
     * @author guoyang
     * @date 2020/3/9  19:54
     */
    public function saveData($condition,$data)
    {
        return $this->where($condition)->update($data);
    }
    public function find($id)
    {
        return Information::query()->find($id);
    }
}