<?php

/**
 * 声明
 *  1. 本工具Fork自 https://github.com/funsoul/funcompare
 *  2. 在原工具基础上修改BUG并添加单元测试后输出
 *  3. 由于原作者已不再更新，本人fork后准备长期补充、支持和优化，遂形成本库：https://github.com/wxb/funcompare。如果发现问题环境提Issue
 */

/*
 * This file is part of the funsoul/funcompare.
 *
 * (c) funsoul <funsoul.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Wxb\Funcompare;

/*
 * A tool compare text differences.
 *
 * @author    funsoul <funsoul.org>
 * @copyright 2018 funsoul <funsoul.org>
 *
 * @link      https://github.com/funsoul/funcompare
 * @link      http://funsoul.org
 */

class Funcompare
{
    private $_oldLabel = 'old';
    private $_newLabel = 'new';

    public function label($oldLabel, $newLabel)
    {
        !empty($oldLabel) && $this->_oldLabel = $oldLabel;
        !empty($newLabel) && $this->_newLabel = $newLabel;
        return $this;
    }

    public function compareText($oldString, $newString)
    {
        $oldArr = preg_split('/\s+/', $oldString);
        $newArr = preg_split('/\s+/', $newString);
        $resArr = array();

        $oldCount = count($oldArr) - 1;
        $tmpOldIndex = 0;
        $tmpNewIndex = 0;
        $end = false;

        while (!$end) {
            if ($tmpOldIndex <= $oldCount) {
                if (isset($oldArr[$tmpOldIndex]) && isset($newArr[$tmpNewIndex]) && $oldArr[$tmpOldIndex] === $newArr[$tmpNewIndex]) {
                    array_push($resArr, $oldArr[$tmpOldIndex]);
                    $tmpOldIndex++;
                    $tmpNewIndex++;
                } else {
                    $foundKey = array_search($oldArr[$tmpOldIndex], $newArr, true);
                    if ($foundKey != '' && $foundKey > $tmpNewIndex) {
                        for ($p = $tmpNewIndex; $p < $foundKey; $p++) {
                            array_push($resArr, sprintf('<%s:%s>', $this->_newLabel, $newArr[$p]));
                        }
                        array_push($resArr, $oldArr[$tmpOldIndex]);
                        $tmpOldIndex++;
                        $tmpNewIndex = $foundKey + 1;
                    } else {
                        array_push($resArr, sprintf('<%s:%s>', $this->_oldLabel, $oldArr[$tmpOldIndex]));
                        $tmpOldIndex++;
                    }
                }
            } else {
                $end = true;
            }
        }

        $textFinal = '';
        foreach ($resArr as $val) {
            $textFinal .= $val . ' ';
        }
        return $textFinal;
    }

    public function compareArray($oldArr, $newArr)
    {
        $result = array();

        $keys = array_unique(array_merge(array_keys((array) $oldArr), array_keys($newArr)));
        foreach ($keys as $k) {
            if (isset($oldArr[$k]) && isset($newArr[$k])) {
                if (is_array($oldArr[$k]) && is_array($newArr[$k])) {
                    $tmp = $this->compareArray($oldArr[$k], $newArr[$k]);
                    if ($tmp) {
                        $result[$k] = $tmp;
                    }
                } elseif (is_array($oldArr[$k]) || is_array($newArr[$k]) || $oldArr[$k] != $newArr[$k]) {
                    $result[$k][$this->_oldLabel] = $oldArr[$k];
                    $result[$k][$this->_newLabel] = $newArr[$k];
                }
            } elseif (isset($oldArr[$k]) && !isset($newArr[$k])) {
                $result[$k][$this->_oldLabel] = $oldArr[$k];
                $result[$k][$this->_newLabel] = null;
            } elseif (!isset($oldArr[$k]) && isset($newArr[$k])) {
                $result[$k][$this->_oldLabel] = null;
                $result[$k][$this->_newLabel] = $newArr[$k];
            }
        }

        return $result;
    }

    public function compareJson($oldJson, $newJson)
    {
        $oldArr = json_decode($oldJson, true);
        $newArr = json_decode($newJson, true);
        $res = $this->compareArray($oldArr, $newArr);
        return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

}