<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testSetterName(): void
    {
        $category = new Category();
        $category->setName('test');
        $this->assertEquals('test', $category->getName());
    }
}
