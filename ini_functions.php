<?php
/**
 * @param $file string
 * @param $array array
 * @param int $i
 * @return bool|int|string
 */
function put_ini_file($file, $array, $i = 0) {
    $str = "";
    foreach ($array as $k => $v) {
        if (is_array($v)) {
            $str .= str_repeat(" ", $i * 2) . "[$k]" . PHP_EOL;
            $str .= put_ini_file("", $v, $i + 1);
        } else
            $str .= str_repeat(" ", $i * 2) . "$k = $v" . PHP_EOL;
    }
    if ($file)
        return file_put_contents($file, $str);
    else
        return $str;
}

function parse_ini($filepath) {
    $ini = file($filepath);
    if (count($ini) == 0) {
        return array();
    }
    $sections = array();
    $values = array();
    $globals = array();
    $i = 0;
    foreach ($ini as $line) {
        $line = trim($line);
// Comments
        if ($line == '' || $line{0} == ';') {
            continue;
        }
// Sections
        if ($line{0} == '[') {
            $sections[] = substr($line, 1, -1);
            $i++;
            continue;
        }
// Key-value pair
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ($i == 0) {
// Array values
            if (substr($line, -1, 2) == '[]') {
                $globals[$key][] = $value;
            } else {
                $globals[$key] = $value;
            }
        } else {
// Array values
            if (substr($line, -1, 2) == '[]') {
                $values[$i - 1][$key][] = $value;
            } else {
                $values[$i - 1][$key] = $value;
            }
        }
    }
    for ($j = 0; $j < $i; $j++) {
        $result[$sections[$j]] = $values[$j];
    }
    return $result + $globals;
}