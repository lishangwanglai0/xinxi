<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/10
 * Time: 14:36
 */

namespace App\Repository\Admin;

use App\Model\Admin\Information;
use App\Repository\Searchable;

class InformationRepository
{
     use Searchable;

    public static function getAdminList($condition,$perPage,$page=1)
    {
        $data = Information::query()
            ->where(function ($query) use ($condition) {
                Searchable::buildQuery($query, $condition);
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('info_id', 'desc')
            ->paginate($perPage);

        $data->transform(function ($item) {
            xssFilter($item);
            $item->editUrl = route('admin::information.save_layout', ['info_id' => $item->info_id]);
            $item->deleteUrl = route('admin::information.save', ['info_id' => $item->info_id,'keyword'=>'info_status']);
            $item->parentName = $item->pid == 0 ? '顶级菜单' : $item->parent->name;
            return $item;
        });

        return [
            'code' => 0,
            'msg' => '',
            'count' => $data->total(),
            'data' => $data->items(),
        ];
    }
    public static function find($id)
    {
        return Information::query()->find($id);
    }
}