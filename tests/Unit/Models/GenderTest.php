<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class GenderTest extends TestCase
{
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testFillableAttribute()
    {

        $fillable = ['name', 'is_active'];
        $this->assertEquals($fillable, $this->genre->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [SoftDeletes::class, Uuid::class];
        $genre_traits = array_values(class_uses(Genre::class));
        $this->assertEquals($traits, $genre_traits);
    }

    public function testKeyTypeAttribute()
    {
        $this->assertEquals('string', $this->genre->getKeyType());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->genre->getIncrementing());
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($dates as $date) {
            $this->assertContains($date, $this->genre->getDates());
        }
        $this->assertCount(count($dates), $this->genre->getDates());
    }

    public function testCasts()
    {
        $casts = [
            'is_active' => 'boolean'
        ];
        $this->assertEquals($casts, $this->genre->getCasts());
    }
}
