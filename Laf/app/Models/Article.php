<?php
/**
 * Created by PhpStorm.
 * User: wb-bj-dn-245
 * Date: 16/6/27
 * Time: 上午11:20
 */
namespace App\Models;

class Article extends Model{

    protected $table = 'articles';

    protected $fillable = [
        'id',
        'title',
        'content',
    ];
}