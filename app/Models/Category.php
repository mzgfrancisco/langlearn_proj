<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['category_name', 'module'];

    public $timestamps = false;
    public function words()
    {
        return $this->hasMany(Word::class, 'category_id');
    }

    public function quizReports()
    {
        return $this->hasMany(QuizReport::class, 'category_id');
    }
}
