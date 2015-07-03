<?php

/**
 * Provide tools functions for general purpose.
 *
 * All quicktools functions begin with underscore (_).
 *
 */

/**
 * Returns the first element of an array, associative or not.
 *
 * Ex : _first(array(4, 5, 6); // Return 4
 * Ex : _first(array("name" => "paul", "age" => 34); // Return "paul"
 *
 * Returns boolean false if the array is empty.
 *
 * @param array $a
 * @return mixed
 */
function _first(array $a) {

    if (empty($a))
        return false;

    if (isset($a[0]))
        return $a[0];

    // It seems that $a is an associative array.
    $k = array_keys($a);
    return $a[$k[0]];

}

/**
 * Returns the last element of an array.
 *
 * Ex : _first(array(4, 5, 6); // Return 6
 * Ex : _first(array("name" => "paul", "age" => 34); // Return 34
 *
 * Returns boolean false if the array is empty.
 *
 * @param array $a
 * @return mixed
 */
function _last(array $a) {

    $cnt = count($a);

    if ($cnt === 0)
        return false;

    $cnt--;

    // We have to test for $a[0] so that _last(array(1=>'a', 2=>'b')) works too.
    if (isset($a[$cnt]) and isset($a[0]))
        return $a[$cnt];

    // It seems that $a is an associative array.
    $k = array_keys($a);
    return $a[$k[$cnt]];

}

/**
 *
 * Abbreviation for *words* : shortcut to php's explode function.
 *
 * Also removes empty strings.
 *
 * Parameters:
 *  - $string : the string to explode
 *  - $sep : the separator, defaults to space (" ")
 *
 * Exemple:
 * <code>
 * _w("these are four elements") == array("these", "are", "four", "elements");
 * foreach (_w("banana apple orange") as $fruit) echo "Fruit : $fruit\n";
 *
 * _w("tada") === (array)"tada" === array("tada")
 * _w("a,b,", ",") === array("a", "b") // removes empty values
 * _w("a,b,,c , e , ,  ", ",") === array("a", "b", "c", "e") // auto trim
 * _w(array("a", "b")) == array("a", "b") // don't change arrays
 * </code>
 *
 * @param mixed $string
 * @param string $sep
 * @return array
 */
function _w($string, $sep = " ") {

    if (empty($string))
        return array();

    if (is_array($string))
        return $string;

    if (is_string($string))
        return _array_clean(explode($sep, $string));

    return (array)$string;

}

/**
 * Abbreviation for *sprintf*.
 *
 * shortcut to php's sprintf function.
 *
 * Parameters: See php's sprintf function.
 *
 * Exemple: _s("%d %s", 5, "foo")
 *
 * @param string $format
 * @return string
 */
function _s($format) {
    $args = func_get_args();
    return call_user_func_array("sprintf", $args);
}

/**
 * Pluralize one or more words.
 *
 * Exemples :
 * <code>
 * _pluralize(3, "house")  -> "3 houses"
 * _pluralize(1, "dog")    -> "1 dog"
 * _pluralize(1, "dog", true) -> "dog"
 *
 * $numRes = 3;
 * $s = "Vous avez " . _pluralize($numRes, "resultat different") . " : "
 * // "Vous avez 3 resultats differents : "
 * </code>
 *
 * @param int $num The number of elements
 * @param string $string the name of elements
 * @param bool $hideNumIfOne do not show $num if it equals 1
 * @return string
 */
function _pluralize($num, $string, $hideNumIfOne = false) {
    if ($num > 1) {
        foreach (explode(" ", $string) as $token)
            $newString[] = $token . 's';
        $newString = join(" ", $newString);
    } else {
        $newString = $string;
        if ($hideNumIfOne) $num = "";
    }
    return trim("$num $newString");
}


/**
 * Convert particules in short version.
 *
 * Example "de alice" become "d'alice".
 *
 * Usage :
 * - _particulize("de", "alice"); // return "d'alice"
 * - _particulize("de", "bob"); // return "de bob"
 *
 * @param string $particule
 * @param string $string
 * @return string
 */
function _particulize($particule, $string) {

    $letter = $string[0];

    $letter = strtolower(remove_accents($letter));

    $short = array("a", "i", "u", "e", "o", "y");

    if (in_array($letter, $short)) {
        $particule = $particule[0] . "'";
    } else {
        $particule = $particule . " ";
    }

    return sprintf("%s%s", $particule, $string);

}

/**
 * Abbreviation for utf8 encode.
 *
 * Shortcut to php's utf8_encode function.
 *
 * The $detect option uses _isUtf8().
 *
 * @param string $s the string to encode
 * @param bool $detect do not encode if the string is already utf8
 * @return string
 */
function _u($s, $detect = false) {
    if ($detect and _isUtf8($s))
        return $s;
    return utf8_encode($s);
}


/**
 * Abbreviation for utf8 decode.
 *
 * Shortcut to php's utf8_decode function.
 *
 * The $detect option uses _isUtf8().
 *
 * @param string $s the string to decode
 * @param bool $detect do not decode if the string is not utf8
 * @return string
 */
function _ud($s, $detect = false) {
    if ($detect and !_isUtf8($s))
        return $s;
    return utf8_decode($s);
}

/**
 * Test if a string is utf8.
 *
 * Uses the php function mb_detect_encoding.
 *
 * Returns true if the string is empty, or even if it has no special chars.
 *
 * This alias exists because the mb_detect_encoding syntax is pretty awkyard.
 *
 * @param string $s
 * @return boolean
 */
function _isUtf8($s) {
    return (mb_detect_encoding($s, 'UTF-8', true) !== false);
}


/**
 * Abbreviation for *json decode*.
 *
 * shortcut to php's json_decode function.
 *
 * <code>
 * $values = _j('{name:"john",age:18}');
 * $values === array("name"=>"john","age"=>18);
 * </code>
 *
 * @param string $json  the string to decode
 * @param bool $assoc decode to an associative array (defaults to true)
 * @return mixed
 */
function _j($json, $assoc = true) {
    return json_decode($json, $assoc);
}

/**
 * Abbreviation for *json encode*.
 *
 * shortcut to php's json_encode function.
 *
 * Returns valid json corresponding to php values.
 *
 * <code>
 * $values = _je(array("name"=>"john","age"=>18));
 * $values === '{"name":"john","age":18}';
 * </code>
 *
 * Note:
 * Strings values *must* be in utf8 !
 *
 * If not you can use <_ua> : $json = _je(_ua($myArray));
 *
 * @param mixed $v value
 * @return string
 */
function _je($v) {
    return json_encode($v);
}



/**
 * Returns the number of occurence of $needle in the $haystack.
 *
 * Works for string, or array.
 *
 * @param string|array $haystack
 * @param string|array $needle
 *
 * @throws Exception on usage on object

 * @return int
 */
function _count($haystack, $needle) {

    if (is_array($haystack)) {
        $stats = array_count_values($haystack);
        if (!isset($stats[$needle]))
            return 0;
        return $stats[$needle];
    }

    if (is_object($haystack))
        throw new Exception("Cannot use _count on object");

    return preg_match_all('/'.preg_quote($needle, "/").'/', $haystack);

}

/**
 * Cleans a string array.
 *
 * Trim strings
 * Removes empty strings (but keeps zero)
 * Removes null values
 *
 * _array_clean(array("a", "", "b", null)) == array("a", "b")
 * _array_clean(array(" a ", "\nb\n")) === array("a", "b")
 *
 * @param array $a
 * @return array
 */
function _array_clean(array $a) {
    $b = array();
    foreach ($a as $v) {
        if ($v === null)
            continue;
        if (is_string($v)) {
            $v = trim($v);
            if (strlen($v) === 0)
                continue;
        }
        $b[] = $v;
    }
    return $b;
}