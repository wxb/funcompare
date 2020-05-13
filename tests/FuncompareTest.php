<?php

namespace Funsole\Tests;

use PHPUnit\Framework\TestCase;
use Wxb\Funcompare\Funcompare;

class FuncompareTest extends TestCase
{
    public function testCompareJson()
    {
        $old = '[{"id":1,"name":"xxx","age":18,"cart":[{"id":100,"name":"rice->你"}], "sex":"男/0"},{"id":2,"name":"aaa","age":18}]';
        $new = '[{"id":1,"name":"yyy","age":20,"cart":[{"id":100,"name":"banana/我"}], "sex":1, "address":{"provice":"陕西省","city":"宝鸡市"}},{"id":2,"name":"bbb","age":18}]';

        $fc = new Funcompare();
        $res = $fc->compareJson($old, $new);
        echo $res;

        $this->assertTrue(true);
    }

    public function testCompareArray()
    {
        $old = [
            ["id" => 1, "name" => "xxx", "age" => 18, "cart" => [["id" => 100, "name" => "rice->你"]], "sex" => "男/0"],
            ["id" => 2, "name" => "aaa", "age" => 18],
        ];
        $new = [
            ["id" => 1, "name" => "yyy", "age" => 20, "cart" => [["id" => 100, "name" => "banana/我"]], "sex" => 1, "address" => ["provice" => "陕西省", "city" => "宝鸡市"]],
            ["id" => 2, "name" => "bbb", "age" => 18],
        ];

        $fc = new Funcompare();
        $res = $fc->compareArray($old, $new);
        var_export($res);

        $this->assertTrue(true);
    }

    public function testCompareText()
    {

        $old = 'A tool compare text differences is funny';
        $new = 'A tool that compare text differences';

        $fc = new Funcompare();
        $res = $fc->compareText($old, $new);
        echo $res;

        $this->assertTrue(true);
    }

    public function testLabel()
    {
        $fromA = 'A tool compare text differences is funny';
        $fromB = 'A tool that compare text differences';

        $fc = new Funcompare();
        $res = $fc->label('a', 'b')->compareText($fromA, $fromB);
        echo $res;

        $this->assertTrue(true);
    }

}