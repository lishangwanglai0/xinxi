<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 2020/3/9
 * Time: 17:29
 */

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


}