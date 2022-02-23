<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candy extends Model
{
    use HasFactory;

    protected $fillable = ["name", "cocoa_content", "sugar_content"];

    static public function averageSugarWithCocoa(): float
    {
        $avg = Candy::where('cocoa_content','>',0)->average('sugar_content');
        if ($avg === null){
            return NAN;
        }
        return $avg;
    }

    static public function nonChochoSugarFreeCount(){
        if (Candy::count() === 0){
            return NAN;
        }
        $count = Candy::where('cocoa_content','=',0)->where('sugar_content','=',0)->count();
        return $count;
    }
    
}
