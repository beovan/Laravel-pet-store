<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory,Searchable;
    protected $fillable = [
        'title', 
        'content',
        'thumb',
    ];

    public function toSearchableArray(){
        return [
            'title'=> $this->title, 
            'content'=> $this->content,
            'thumb'=> $this->thumb
        ];

    }
}
