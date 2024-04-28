<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TalentPortfolio extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'talent_id',
        'title',
        'category_id',
        'featured_image',
        'link',
        'description',
        'tags',
        'is_draft',
        'file_id'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function portfolioprojectimage()
    {
        return $this->hasMany(PortfolioProjectImage::class, 'talent_portfolio_id');
    }
}
