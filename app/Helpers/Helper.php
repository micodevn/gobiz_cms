<?php

namespace App\Helpers;

use App\Http\Services\FileService;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Helper
{
    public static function getDayNameOfWeek($dayOfWeek): string
    {
        return match ($dayOfWeek) {
            0 => 'T2',
            1 => 'T3',
            2 => 'T4',
            3 => 'T5',
            4 => 'T6',
            5 => 'T7',
            6 => 'CN',
            default => '',
        };
    }

    public static function removeUnicode($str): array|string|null
    {
        // In thường
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        // In đậm
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str; // Trả về chuỗi đã chuyển
    }

    public static function changeToSlug($str, $lowerCase = false): array|string|null
    {
        $slug = self::removeUnicode($str);
        $lowerCase && $slug = strtolower($slug);
        $slug = str_replace(' ', '-', $slug);
        return preg_replace('/[^A-Za-z0-9\-_.]/', '', $slug);
    }

    public static function makeUrl($baseUrl, ...$args): string
    {
        return $baseUrl . self::makePath(...$args);
    }

    public static function makeResourceUrl($path): array|string
    {
        return config('cdn.static_domain') . $path;
        if (str_contains($path, 'resource/video/word')) {
            $path = str_replace(' ', '-', $path);
        } else {
            $path = str_replace(' ', '%20', $path);
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if (str_starts_with($path, '/uploads')) {
            return self::makeUrl(config('cdn.static_domain'), str_replace('/uploads', '/', $path));
        }

        $domain = request('static_domain', null) ? request('static_domain') : config('cdn.domain');
        return self::makeUrl($domain, FileService::UPLOAD_ROOT, $path);
    }

    public static function makePath(...$args)
    {
        $path = '';

        foreach ($args as $arg) {
            $path .= '/' . $arg;
        }

        return preg_replace('~/+~', '/', $path);
    }

    /**
     * @param $size
     * @return void
     */
    public static function setUploadSize($size)
    {
        ini_set('post_max_size', $size);
        ini_set('upload_max_filesize', $size);
    }

    public static function arrayColumn($array, $column)
    {
        return array_values(array_unique(array_column($array, $column)));
    }

    /**
     * @param        $array
     * @param string $key
     *
     * @return array
     */
    public static function reAssignKey($array, $key)
    {
        $new_array = [];
        if (is_array($array)) {
            foreach ($array as $item) {
                $item = is_array($item) ? $item : json_decode($item, true);
                !empty($item[$key]) && $new_array[$item[$key]] = $item;
            }
        }
        return $new_array;
    }

    public static function generateTokenApi()
    {
        return hash('sha256', \Str::random(80));
    }

    private static function expand(&$result, $keys, $value)
    {
        if (count($keys) === 1) {
            $result[$keys[0]] = $value;
            return $result;
        }

        $path = null;

        foreach ($keys as $index => $key) {
            $path .= is_null($path) ? $key : '.' . $key;

            if (!Arr::exists($result, $path)) {
                Arr::add($result, $path, []);
            }


            if ($index === count($keys) - 1) {
                Arr::set($result, $path, $value);
                return $result;
            }
        }

        return $result;
    }

    public static function expandFlattened($arr)
    {
        $result = [];
        foreach ($arr as $key => $value) {
            $keys = explode('.', $key);

            $result = self::expand($result, $keys, $value);
        }
        return $result;
    }


    public static function flattenKeysRecursively(array $array, $parentKey = ''): array
    {
        $result = [];
        self::recursiveFlattenKey($array, $result, $parentKey);
        return $result;
    }

    private static function recursiveFlattenKey(array $array, array &$result, string $parentKey): void
    {
        foreach ($array as $key => $value) {
            $itemKey = ($parentKey ? $parentKey . '.' : '') . $key;
            if (is_array($value)) {
                self::recursiveFlattenKey($value, $result, $itemKey);
            } else {
                $result[$itemKey] = $value;
            }
        }
    }


    public static function flattenKeysBracketRecursively(array $array, $parentKey = ''): array
    {
        $result = [];
        self::recursiveFlattenKeyBracket($array, $result, $parentKey);
        return $result;
    }

    private static function recursiveFlattenKeyBracket(array $array, array &$result, string $parentKey): void
    {
        foreach ($array as $key => $value) {
            $itemKey = $parentKey . '[' . $key . ']';
            if (is_array($value)) {
                self::recursiveFlattenKeyBracket($value, $result, $itemKey);
            } else {
                $result[$itemKey] = $value;
            }
        }
    }

    public static function emptyArray($array): bool
    {
        $empty = true;
        if (is_array($array)) {
            foreach ($array as $value) {
                if (!self::emptyArray($value)) {
                    $empty = false;
                }
            }
        } elseif (!empty($array)) {
            $empty = false;
        }
        return $empty;
    }

    public static function fromCamelCase($input)
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ?
                strtolower($match) :
                lcfirst($match);
        }
        return implode('_', $ret);
    }

    public static function recursiveFind(&$array, $needle_key = []): bool
    {
        foreach ($array as $key => &$value) {
            if (in_array($key, $needle_key)) {
                $value = (int)$value;
            }
            if (is_array($value)) {
                if (($result = self::recursiveFind($value, $needle_key)) !== false)
                    return $result;
            }
        }
        return false;
    }


    public static function utf8ize($json)
    {
        if (is_array($json)) {
            foreach ($json as $k => $v) {
                $json[$k] = self::utf8ize($v);
            }
        } else if (is_string($json)) {
            return utf8_encode($json);
        }
        return $json;
    }

    public static function buildTree(array &$elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
                unset($elements[$element['id']]);
            }
        }
        return $branch;
    }

    public static function convertArrayKeyToSnake($array)
    {
        $snakeData = [];
        foreach ($array as $key => $value) {
            $snakeData[Str::snake($key)] = $value;
        }

        return $snakeData;
    }

}
