<?php

namespace Tests\Unit;

use App\Models\Candy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CandyTest extends TestCase
{
    use DatabaseMigrations;

    public function fill_data_only_chocho(){
        Candy::factory()->createMany([
            [  
                'name' => 'Chocholate1',
                'cocoa_content' => 5.5,
                'sugar_content' => 2,
            ],
            [  
                'name' => 'Chocholate2',
                'cocoa_content' => 5.1,
                'sugar_content' => 4,
            ],
            [  
                'name' => 'Chocholate3',
                'cocoa_content' => 15.2,
                'sugar_content' => 10,
            ],
            [  
                'name' => 'Chocholate4',
                'cocoa_content' => 15.2,
                'sugar_content' => 0,
            ],
        ]);
    }

    public function fill_data_only_non_chocho(){
        Candy::factory()->createMany([
            [  
                'name' => 'ChocholateNon1',
                'cocoa_content' => 0,
                'sugar_content' => 13,
            ],
            [  
                'name' => 'ChocholateNon2',
                'cocoa_content' => 0,
                'sugar_content' => 0,
            ],
            [  
                'name' => 'ChocholateNon3',
                'cocoa_content' => 0,
                'sugar_content' => 2.3,
            ],
        ]);
    }

    public function fill_data_multipart(){
        $this->fill_data_only_chocho();
        $this->fill_data_only_non_chocho();
    }

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

        $this->fill_data_only_chocho();
        $this->assertEquals(4,Candy::averageSugarWithCocoa());
    }
    
    public function test_multi_chocho_candy_with_free(){
        $this->fill_data_multipart();
        $this->assertEquals(4,Candy::averageSugarWithCocoa());
    }

    public function test_no_chocholate(){
        $this->assertNan(Candy::averageSugarWithCocoa());
    }

    public function test_chocho_count_only_chocho(){
        $this->fill_data_only_chocho();
        $this->assertEquals(0,Candy::nonChochoSugarFreeCount());
    }

    public function test_chocho_count_only_non_chocho(){
        $this->fill_data_only_non_chocho();
        $this->assertEquals(1,Candy::nonChochoSugarFreeCount());
    }

    public function test_chocho_count_multipart(){
        $this->fill_data_multipart();
        $this->assertEquals(1,Candy::nonChochoSugarFreeCount());
    }

    public function test_chocho_count_only_empty(){
        $this->assertNan(Candy::nonChochoSugarFreeCount());
    }

    public function test_lowers_sugar_non_free(){
        $this->fill_data_multipart();
        $this->assertEquals(Candy::lowersSugarCandyNonFree()->name,"Chocholate1");
    }

    public function test_lowest_sugar_non_free_only_free(){
        Candy::factory()->createMany([
            [  
                'name' => 'ChocholateNon2',
                'cocoa_content' => 0,
                'sugar_content' => 0,
            ],
            [  
                'name' => 'Chocholate4',
                'cocoa_content' => 15.2,
                'sugar_content' => 0,
            ]
        ]);
        $this->assertNull(Candy::lowersSugarCandyNonFree());
    }
    
    public function test_lowest_sugar_non_fre_empty(){
        $this->assertNull(Candy::lowersSugarCandyNonFree());
    }
}
