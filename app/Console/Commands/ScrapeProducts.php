<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\ProductScraper;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ScrapeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:products';

    protected $description = 'Scrape products and add them to the database';



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://pawpawpetshop.vn/collections/giam-gia');
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding((string) $response->body(), 'HTML-ENTITIES', 'UTF-8'));
    
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
        Product::created($data);
        print_r($data);
    }
}
