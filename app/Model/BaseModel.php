<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/9
 * Time: 19:09
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function page_query($condition,$page_size,$page_index,$order,$field)
    {
        $count = $this->where($condition)->count();
        if ($page_size == 0) {
            $list = $this->select($field)
                ->where($condition)
                ->order($order)
                ->get();
            $page_count = 1;
        } else {
            $start_row = $page_size * ($page_index - 1);
            $list = $this->select($field)
                ->where($condition)
                ->orderBy($order,'desc')
                ->offset($start_row)
                ->limit($page_size)
                ->get();
            if ($count % $page_size == 0) {
                $page_count = $count / $page_size;
            } else {
                $page_count = (int) ($count / $page_size) + 1;
            }
        }
        return array(
            'data' => $list,
            'count' => $count,
            'page_count' => $page_count
        );
    }
}