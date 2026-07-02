<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Word extends Model
{
    use HasFactory;

    protected $table = 'words';
    protected $fillable = ['english_word', 'tagalog_word', 'example_sentence', 'category_id'];

    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
