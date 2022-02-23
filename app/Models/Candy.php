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
        $candies = Candy::all();
        $sum = 0;
        $count = 0;
        foreach ($candies as $candy ){
            if($candy->cocoa_content > 0){
                $sum += $candy->sugar_content;
                $count++;
            }
        }
        if ($count === 0){
            return NAN;
        }
        return floatval($sum) / $count;
    }
}
