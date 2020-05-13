funcompare
==========
A tool compare text differences

# 声明
   *  1. 本工具Fork自 https://github.com/funsoul/funcompare
   *  2. 在原工具基础上修改BUG并添加单元测试后输出
   *  3. 由于原作者已不再更新，本人fork后准备长期补充、支持和优化，遂形成本库：https://github.com/wxb/funcompare

# Installation

```
composer require "wxb/funcompare"
```

# Usage

### compareText($oldString, $newString)
```php
use Wxb\Funcompare\Funcompare;

$old = 'A tool compare text differences is funny';
$new = 'A tool that compare text differences';

$fc = new Funcompare();
$res = $fc->compareText($old, $new);
echo $res;

// A tool <new:that> compare text differences <old:is> <old:funny>

```


### compareArray($oldArr, $newArr)
```php
use Wxb\Funcompare\Funcompare;

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

/*
array (
  0 => 
  array (
    'name' => 
    array (
      'old' => 'xxx',
      'new' => 'yyy',
    ),
    'age' => 
    array (
      'old' => 18,
      'new' => 20,
    ),
    'cart' => 
    array (
      0 => 
      array (
        'name' => 
        array (
          'old' => 'rice->你',
          'new' => 'banana/我',
        ),
      ),
    ),
    'sex' => 
    array (
      'old' => '男/0',
      'new' => 1,
    ),
    'address' => 
    array (
      'old' => NULL,
      'new' => 
      array (
        'provice' => '陕西省',
        'city' => '宝鸡市',
      ),
    ),
  ),
  1 => 
  array (
    'name' => 
    array (
      'old' => 'aaa',
      'new' => 'bbb',
    ),
  ),
)
*/
```


### compareJson($oldJson, $newJson)
```php
use Wxb\Funcompare\Funcompare;

$old = '[{"id":1,"name":"xxx","age":18,"cart":[{"id":100,"name":"rice->你"}], "sex":"男/0"},{"id":2,"name":"aaa","age":18}]';
$new = '[{"id":1,"name":"yyy","age":20,"cart":[{"id":100,"name":"banana/我"}], "sex":1, "address":{"provice":"陕西省","city":"宝鸡市"}},{"id":2,"name":"bbb","age":18}]';


$fc = new Funcompare();
$res = $fc->compareJson($old, $new);
echo $res

// [{"name":{"old":"xxx","new":"yyy"},"age":{"old":18,"new":20},"cart":[{"name":{"old":"rice->你","new":"banana/我"}}],"sex":{"old":"男/0","new":1},"address":{"old":null,"new":{"provice":"陕西省","city":"宝鸡市"}}},{"name":{"old":"aaa","new":"bbb"}}]

```

```json
[
    {
        "name":{
            "old":"xxx",
            "new":"yyy"
        },
        "age":{
            "old":18,
            "new":20
        },
        "cart":[
            {
                "name":{
                    "old":"rice->你",
                    "new":"banana/我"
                }
            }
        ],
        "sex":{
            "old":"男/0",
            "new":1
        },
        "address":{
            "old":null,
            "new":{
                "provice":"陕西省",
                "city":"宝鸡市"
            }
        }
    },
    {
        "name":{
            "old":"aaa",
            "new":"bbb"
        }
    }
]
```



### label($oldLabel, $newLabel)
```php
use Wxb\Funcompare\Funcompare;

$fromA = 'A tool compare text differences is funny';
$fromB = 'A tool that compare text differences';

$fc = new Funcompare();
$res = $fc->label('a', 'b')->compareText($fromA, $fromB);
echo $res;

// A tool <b:that> compare text differences <a:is> <a:funny> 
```

# License

MIT