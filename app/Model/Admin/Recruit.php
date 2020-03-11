<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/10
 * Time: 9:24
 */

namespace App\Model\Admin;


class Recruit extends Model
{
    protected $table='recruit';

    public function getFirstInfo($condition)
    {
        return DB::table('info_issue')->where($condition)->first();
    }

}