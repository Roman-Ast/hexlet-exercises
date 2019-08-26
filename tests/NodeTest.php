<?php

namespace App\Tests;

require __DIR__ . '/../vendor/autoload.php';

use App\LinkedList\Node;
use function App\LinkedList\reverse;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function testReverse1()
    {
        $list = new Node(true);
        $reversedList = reverse($list);
        $this->assertTrue($reversedList->getValue());
    }

    public function testReverse2()
    {
        $numbers = new Node(1, new Node(2, new Node(3)));
        $reversedNumbers = reverse($numbers);
        $this->assertEquals(3, $reversedNumbers->getValue());
        $this->assertEquals(2, $reversedNumbers->getNext()->getValue());
        $this->assertEquals(1, $reversedNumbers->getNext()->getNext()->getValue());
    }
}