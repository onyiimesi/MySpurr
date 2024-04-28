<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioProjectImage extends Model
{
    protected $table = "portfolio_project_images";

    use HasFactory;

    protected $fillable = [
        'talent_id',
        'talent_portfolio_id',
        'image',
        'file_id'
    ];

    public function talentportfolio()
    {
        return $this->belongsTo(TalentPortfolio::class, 'talent_portfolio_id');
    }
}
