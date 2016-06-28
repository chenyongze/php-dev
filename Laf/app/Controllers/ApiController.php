<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/27
 * Time: 上午10:22
 */
namespace App\Controllers;


class ApiController extends Controller {


    public function __construct() {
        parent::__construct();
    }


    public function index(){
        \AtsResponse::success(array(
            'id' => 1,
            'name' => 'xxxx'
        ));
    }


}