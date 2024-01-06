<?php

namespace App\Http\Controllers;

use App\Http\Services\Menu\MenuService;
use App\Http\Services\Post\PostService;
use App\Http\Services\Product\ProductService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected  $postService;
    protected $menu;
    protected $productService;
    //Giới hạn hiện thị sản phẩm 
    const LIMIT = 5;
    public function __construct(PostService $postService,MenuService $menu,ProductService $productService)
    {
        $this->postService = $postService;
        $this->menu = $menu;
        $this->productService = $productService;
    }
    public function index()
    {
        $menus = $this->menu->show();
        $products = $this->productService->getSidebar();


        return view('post.post',[
            'title' => 'Bài viết',
            "post" => $this->postService->show(),
            'menus' => $menus,
            'products' => $products,
        ]);
    }
}
