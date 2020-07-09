<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Ramsey\Uuid\Uuid;
use Carbon\Exceptions\BadComparisonUnitException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use DatabaseMigrations;

    public function testList()
    {
        $category = factory(Category::class, 1)->create()->first();
        $categoryKeys = array_keys($category->refresh()->getAttributes());

        $this->assertDatabaseCount('categories', 1);
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $categoryKeys
        );
    }

    public function testCreate() {
        $category = Category::create([
            'name' => 'test'
        ])->refresh();
        $this->assertTrue(Uuid::isValid($category->id));
        $this->assertEquals('test', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'test',
            'description' => null
        ]);
        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test',
            'description' => 'test_description'
        ]);
        $this->assertEquals('test_description', $category->description);

        $category = Category::create([
            'name' => 'test',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);
    }

    public function testEdit() {

        /**
         * @var Category $category
         */
        $category = factory(Category::class)->create([
            'description' => 'test_description',
            'is_active' => false,
        ])->first();

        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description_updated',
            'is_active' => true
        ];
        $category->update($data);

        foreach($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }

    }

    public function testDelete() {

        $category = factory(Category::class)->create()->first();
        $category->delete();
        $this->assertCount(0, Category::all());
        $category->forceDelete();
        $this->assertDatabaseCount('categories', 0);

    }
}
