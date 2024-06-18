<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'blog_category_id',
        'slug',
        'description',
        'content',
        'tags',
        'publish_date',
        'featured_photo',
        'file_id',
        'status'
    ];

    public function blogcategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
