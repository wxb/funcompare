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

### compareText()
```php
use Wxb\Funcompare\Funcompare;

$old = 'A tool compare text differences is funny';
$new = 'A tool that compare text differences';

$fc = new Funcompare();
$res = $fc->compareText($old, $new);
echo $res;

// A tool <span class="new-word">that</span> compare text differences <span class="old-word">is</span> <span class="old-word">funny</span>

```

### compareJson()
```php
use Wxb\Funcompare\Funcompare;

$old = '[{"id":1,"name":"xxx","age":18,"cart":[{"id":100,"name":"rice->你"}], "sex":"男/0"},{"id":2,"name":"aaa","age":18}]';
$new = '[{"id":1,"name":"yyy","age":20,"cart":[{"id":100,"name":"banana/我"}], "sex":1, "address":{"provice":"陕西省","city":"宝鸡市"}},{"id":2,"name":"bbb","age":18}]';


$fc = new Funcompare();
$res = $fc->compareJson($old, $new);
echo $res

// [{"name":{"old":"<span class=\"old-word\">\"xxx\"</span>","new":"<span class=\"old-word\">\"yyy\"</span>"},"age":{"old":"<span class=\"old-word\">18</span>","new":"<span class=\"old-word\">20</span>"},"cart":[{"name":{"old":"<span class=\"old-word\">\"rice->你\"</span>","new":"<span class=\"old-word\">\"banana/我\"</span>"}}],"sex":{"old":"<span class=\"old-word\">\"男/0\"</span>","new":"<span class=\"old-word\">1</span>"},"address":{"old":null,"new":"<span class=\"old-word\">{\"provice\":\"陕西省\",\"city\":\"宝鸡市\"}</span>"}},{"name":{"old":"<span class=\"old-word\">\"aaa\"</span>","new":"<span class=\"old-word\">\"bbb\"</span>"}}]

```

```json
[
    {
        "name":{
            "old":"<span class="old-word">"xxx"</span>",
            "new":"<span class="old-word">"yyy"</span>"
        },
        "age":{
            "old":"<span class="old-word">18</span>",
            "new":"<span class="old-word">20</span>"
        },
        "cart":[
            {
                "name":{
                    "old":"<span class="old-word">"rice->你"</span>",
                    "new":"<span class="old-word">"banana/我"</span>"
                }
            }
        ],
        "sex":{
            "old":"<span class="old-word">"男/0"</span>",
            "new":"<span class="old-word">1</span>"
        },
        "address":{
            "old":null,
            "new":"<span class="old-word">{"provice":"陕西省","city":"宝鸡市"}</span>"
        }
    },
    {
        "name":{
            "old":"<span class="old-word">"aaa"</span>",
            "new":"<span class="old-word">"bbb"</span>"
        }
    }
]
```

### css

```
<style>
    .new-word{background:rgba(245,255,178,1.00)}
    .new-word:after{content:' '; background:rgba(245,255,178,1.00)}
    .old-word{text-decoration:none; position:relative}
    .old-word:after{
        content: ' ';
        font-size: inherit;
        display: block;
        position: absolute;
        right: 0;
        left: 0;
        top: 55%;
        bottom: 30%;
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
    }
</style>
```

### wrapper()
```php
use Funsoul\Funcompare\Funcompare;

$old = 'A tool compare text differences is funny';
$new = 'A tool that compare text differences';

$fc = new Funcompare();
$res = $fc->wrapper('[',']','<','>')->compareText($old, $new);
echo $res;

// A tool <that> compare text differences [is] [funny]
```

# License

MIT