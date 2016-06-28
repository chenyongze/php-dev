<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/27
 * Time: 上午10:22
 */
namespace App\Controllers;

class TestController extends Controller {


    public function __construct() {
        parent::__construct();
    }


    public function index(){
        echo 111;
    }


}