<?php

namespace Tests\Unit;

use App\Models\Candy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CandyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_one_chocho_candy(){
        $candy = new Candy([
            'name' => 'Chocholate',
            'cocoa_content' => 5.5,
            'sugar_content' => 2,
        ]);
        $this->assertTrue($candy->save());
        $this->assertEquals(2,Candy::averageSugarWithCocoa());
    }

    public function test_multi_chocho_candy(){

        Candy::factory()->createMany([
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 5.5,
                'sugar_content' => 2,
            ],
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 5.1,
                'sugar_content' => 3,
            ],
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 15.2,
                'sugar_content' => 10,
            ],
        ]);
        $this->assertEquals(5,Candy::averageSugarWithCocoa());
    }
    
    public function test_multi_chocho_candy_with_free(){
        Candy::factory()->createMany([
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 5.5,
                'sugar_content' => 2,
            ],
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 5.1,
                'sugar_content' => 3,
            ],
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 0,
                'sugar_content' => 13,
            ],
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 15.2,
                'sugar_content' => 10,
            ],
            [  
                'name' => 'Chocholate',
                'cocoa_content' => 0,
                'sugar_content' => 0,
            ],
        ]);
        $this->assertEquals(5,Candy::averageSugarWithCocoa());
    }

    public function test_no_chocholate(){
        $this->assertNan(Candy::averageSugarWithCocoa());
    }
}
