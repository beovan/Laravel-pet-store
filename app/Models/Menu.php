<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Menu extends Model
{
    use HasFactory,Searchable;

    protected  $fillable = [
        'name',
        'parent_id',
        'description',
        'content',
        'active'
    ];

    public  function products()
    {
        return $this->hasMany(Product::class, 'menu_id','id');
    }

    public function toSearchableArray(){
        return [
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'description' => $this->description,
            'content' => $this->content,
            'active' => $this->active
        ];

    }
}
