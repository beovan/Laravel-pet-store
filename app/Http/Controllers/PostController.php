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
        $posts = $this->postService->get_page();
        return view('post.post',[
            'title' => 'Bài viết',
            "posts" =>  $posts,
            'menus' => $menus,
            'products' => $products,
        ]);
    }
    public function view_detail($id = '')
    {
        $menus = $this->menu->show();
        $products = $this->productService->getSidebar();
        $post = $this->postService->show_detail($id);

        return view('post.detail',[
            'title' => 'Bài viết',
            "post" =>  $post,
            'menus' => $menus,
            'products' => $products,
        ]);
    }
}
