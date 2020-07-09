<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        $genre = factory(Genre::class, 1)->create()->first();
        $genreKeys = array_keys($genre->refresh()->getAttributes());

        $this->assertDatabaseCount('genres', 1);
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genreKeys
        );
    }

    public function testCreate() {
        $genre = Genre::create([
            'name' => 'test'
        ])->refresh();
        $this->assertTrue(Uuid::isValid($genre->id));
        $this->assertEquals('test', $genre->name);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test',
            'is_active' => false
        ]);
        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'test',
            'is_active' => true
        ]);
        $this->assertTrue($genre->is_active);
    }

    public function testEdit() {

        /**
         * @var Genre $genre
         */
        $genre = factory(Genre::class)->create([
            'is_active' => false,
        ])->first();

        $data = [
            'name' => 'test_name_updated',
            'is_active' => true
        ];
        $genre->update($data);

        foreach($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }

    }

    public function testDelete() {

        $genre = factory(Genre::class)->create()->first();
        $genre->delete();
        $this->assertCount(0, Genre::all());
        $genre->forceDelete();
        $this->assertDatabaseCount('categories', 0);

    }
}
