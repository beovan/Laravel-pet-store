<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory,Searchable;

    protected $fillable = [
        'name',
        'description',
        'content',
        'menu_id',
        'price',
        'price_sale',
        'active',
        'thumb'
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id')
            ->withDefault(['name' => '']);
    }
    public function toSearchableArray(){
        return [
            'name'=> $this->name,
            'description'=> $this->description,
            'content'=> $this->content,
            'menu_id'=> $this->menu_id,
            'price'=> $this->price,
            'price_sale'=> $this->price_sale,
            'active'=> $this->active,
            'thumb' => $this->thumb
        ];

    }
}
