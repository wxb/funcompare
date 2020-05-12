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
    private $_old_l_wrapper = '<span class="old-word">';
    private $_old_r_wrapper = '</span>';
    private $_new_l_wrapper = '<span class="new-word">';
    private $_new_r_wrapper = '</span>';

    private function diffArray($array1, $array2)
    {
        $result = array();

        $keys = array_unique(array_merge(array_keys((array) $array1), array_keys($array2)));
        foreach ($keys as $k) {
            if (isset($array1[$k]) && isset($array2[$k])) {
                if (is_array($array1[$k]) && is_array($array2[$k])) {
                    $tmp = $this->diffArray($array1[$k], $array2[$k]);
                    if ($tmp) {
                        $result[$k] = $tmp;
                    }
                } elseif (is_array($array1[$k]) || is_array($array2[$k]) || $array1[$k] != $array2[$k]) {
                    $result[$k]['old'] = $this->_old_l_wrapper . json_encode($array1[$k], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . $this->_old_r_wrapper;
                    $result[$k]['new'] = $this->_old_l_wrapper . json_encode($array2[$k], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . $this->_old_r_wrapper;
                }
            } elseif (isset($array1[$k]) && !isset($array2[$k])) {
                $result[$k]['old'] = $this->_old_l_wrapper . json_encode($array1[$k], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . $this->_old_r_wrapper;
                $result[$k]['new'] = null;
            } elseif (!isset($array1[$k]) && isset($array2[$k])) {
                $result[$k]['old'] = null;
                $result[$k]['new'] = $this->_old_l_wrapper . json_encode($array2[$k], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . $this->_old_r_wrapper;
            }
        }

        return $result;
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
                            array_push($resArr, $this->_new_l_wrapper . $newArr[$p] . $this->_new_r_wrapper);
                        }
                        array_push($resArr, $oldArr[$tmpOldIndex]);
                        $tmpOldIndex++;
                        $tmpNewIndex = $foundKey + 1;
                    } else {
                        array_push($resArr, $this->_old_l_wrapper . $oldArr[$tmpOldIndex] . $this->_old_r_wrapper);
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

    public function compareJson($oldJson, $newJson)
    {
        $oldArr = json_decode($oldJson, true);
        $newArr = json_decode($newJson, true);
        $res = $this->diffArray($oldArr, $newArr);
        return json_encode($res, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function wrapper($oldLeftWrapper, $oldRightWrapper, $newLeftWrapper, $newRightWrapper)
    {
        $this->_old_l_wrapper = $oldLeftWrapper;
        $this->_old_r_wrapper = $oldRightWrapper;
        $this->_new_l_wrapper = $newLeftWrapper;
        $this->_new_r_wrapper = $newRightWrapper;
        return $this;
    }
}