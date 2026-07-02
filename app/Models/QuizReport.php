<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizReport extends Model
{
    use HasFactory;

    protected $table = 'quiz_report';
    protected $primaryKey = 'report_id';
    protected $fillable = ['user_id', 'category_id', 'score', 'total', 'completed', 'answers'];

    protected $casts = [
        'answers' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
