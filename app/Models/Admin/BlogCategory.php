<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function blog()
    {
        return $this->hasMany(BlogCategory::class, 'blog_category_id');
    }
}
