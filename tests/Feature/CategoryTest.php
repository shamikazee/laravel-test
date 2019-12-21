<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
        use RefreshDatabase;

    /** @test */
    public function testing_category_indexed_format()
    {
        $categories = $this->call('get', '/categories');
        $struct=array("status"=>"","message"=>"","categories"=>"");
        $categories->assertJsonStructure(array("status","message","categories"=>[
            "current_page",
            "data"
        ]));


    }
}
