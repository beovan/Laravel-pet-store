<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CrawlDataController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        ///
        //take carts list 
        $products = $this->cartService->getProduct();
        ///
        $response = Http::get('https://pawpawpetshop.vn/collections/giam-gia');
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding((string) $response->body(), 'HTML-ENTITIES', 'UTF-8'));

        // dd($dom);

        //Dùng để query tag, class id của 1 thẻ HTML
        $xpath = new \DOMXPath($dom);
        $images_query = $xpath->query('//picture[position() != 2]//img[contains(@class, "img-loop")]');



        $titles = $xpath->query('.//div[contains(@class, "box-pro-detail")] //h3 //a');

        $data = [];

        foreach ($images_query as $key => $image) {
            $data[] = [
                'image' => $image->getAttribute("data-src"),
                'link' => $titles[$key] ? $titles[$key]->getAttribute("href") : '',
                'text' => $titles[$key] ? $titles[$key]->textContent : '',
            ];
        }
        // dd($data);
        return view('crawl.crawl', [
            'title' => 'Hàng mới về',
            'data' => $data,
            'products' => $products,
        ]);
    }

    public function detail($slug)
    {
        //take carts list 
        $products = $this->cartService->getProduct();

        // Assume $slug is the product slug you want to crawl details for
        $url = 'https://pawpawpetshop.vn/products/' . $slug;
        $response = Http::get($url);

        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding((string) $response->body(), 'HTML-ENTITIES', 'UTF-8'));

        $xpath = new \DOMXPath($dom);

        // Update these queries based on the actual HTML structure of the product detail page
        $imgNode = $xpath->query('//div[contains(@class, "hidden-sm hidden-xs")]//img[contains(@class, "product-image-feature")]')->item(0);
        $img = $imgNode ? $imgNode->getAttribute("src") : '';

        $nameNode = $xpath->query('//div[contains(@class, "product-title")]//h1')->item(0);
        $name = $nameNode ? $nameNode->textContent : '';

        $priceNode = $xpath->query('//span[contains(@class, "pro-price")]')->item(0);
        $price = $priceNode ? $priceNode->textContent : '';

        $descriptionItems = $xpath->query('//div[contains(@class, "description-productdetail")]//ul//li');
        $descriptions = [];
        foreach ($descriptionItems as $item) {
            $descriptions[] = $item->textContent;
        }

        return view('crawl.detail', [
            'title' => $name,
            'productDetails' => [
                'img' => $img,
                'name' => $name,
                'price' => $price,
                'descriptions' => $descriptions,
            ],
            'products' => $products,
        ]);
    }
    public function addToDatabase(Request $request)
    {
        $data = $request->all(); // Assuming you are passing the crawled data as POST parameters

        // Assuming $data contains 'image', 'link', and 'text'
        $product = new Product([
            'image' => $data['image'],
            'link' => $data['link'],
            'text' => $data['text'],
            // Add other fields as needed
        ]);

        $product->save();

        return response()->json(['message' => 'Product added to database successfully']);
    }
}
