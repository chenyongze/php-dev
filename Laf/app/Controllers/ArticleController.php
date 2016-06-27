<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/27
 * Time: 上午11:23
 */
namespace App\Controllers;

use App\Models\Article;
use App\Servies\View;

class ArticleController extends Controller
{

    public function __construct() {
        parent::__construct();
    }


    public function home()
    {
        $articles = Article::all()->toArray();

        ss($articles);
//        $this->smarty->assign('list',$articles);
//        $this->smarty->display("home/index.tpl");
    }


    public function view(){
        $this->view = View::make('home')->with('list',Article::all()->toArray())
            ->withTitle('MFFC :-D')
            ->withFuckMe('OK!');

    }
}