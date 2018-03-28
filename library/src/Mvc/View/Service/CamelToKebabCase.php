<?php

namespace Framework\Mvc\View\Service;

class CamelToKebabCase
{
    public static function transform($str, $encoding = 'UTF-8')
    {
        $separatorPattern = '/((?<=[^$])[A-Z0-9])/u';
        $pregReplace = preg_replace($separatorPattern, '-$1', $str);
        $strlen    = mb_strlen($pregReplace, $encoding);
        $firstChar = mb_substr($pregReplace, 0, 1, $encoding);
        $then      = mb_substr($pregReplace, 1, $strlen - 1, $encoding);
        $toTrainCase =  mb_strtoupper($firstChar, $encoding).$then;

        return mb_strtolower($toTrainCase, $encoding);
    }
}