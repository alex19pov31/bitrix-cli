<?php

namespace Alex19pov31\BitrixCli;

class Helper
{

    public static function copyFolder($fromDir, $toDir, $upd = true, $force = true)
    {
        if (is_dir($fromDir)) {
            $toDir = static::mkdirSafe($toDir, $force);
            if (!$toDir) {
                return;
            }
            $d = dir($fromDir);
            while (false !== ($entry = $d->read())) {
                if ($entry != '.' && $entry != '..') {
                    static::copyFolder("$fromDir/$entry", "$toDir/$entry", $upd, $force);
                }

            }
            $d->close();
        } else {
            static::copySafe($fromDir, $toDir, $upd);
        }
    }

    public static function mkdirSafe($dir, $force)
    {
        if (file_exists($dir)) {
            if (is_dir($dir)) {
                return $dir;
            } else if (!$force) {
                return false;
            }

            unlink($dir);
        }
        return (mkdir($dir, 0777, true)) ? $dir : false;
    }

    public static function copySafe($f1, $f2, $upd)
    {
        $time1 = filemtime($f1);
        if (file_exists($f2)) {
            $time2 = filemtime($f2);
            if ($time2 >= $time1 && $upd) {
                return false;
            }

        }
        $ok = copy($f1, $f2);
        if ($ok) {
            touch($f2, $time1);
        }

        return $ok;
    }

    public static function compileTemplate(string $filePath, array $dataUpdate): void
    {
        $keys = array_keys($dataUpdate);
        $values = array_values($dataUpdate);
        $data = str_replace($keys, $values, file_get_contents($filePath));
        file_put_contents($filePath, $data);
    }

    public static function compileFolder(string $path, array $dataUpdate): void
    {
        $d = dir($path);
        while (false !== ($entry = $d->read())) {
            if ($entry != '.' && $entry != '..') {
                $el = "$path/$entry";
                if (is_dir($el)) {
                    static::compileFolder($el, $dataUpdate);
                    continue;
                }

                if (is_file($el)) {
                    static::compileTemplate($el, $dataUpdate);
                }
            }
        }
    }

    public static function getLangMessages(string $path): array
    {
        $d = @dir($path);
        $langMessage = [];
        while ($d && false !== ($entry = $d->read())) {
            $MESS = [];
            if ($entry != '.' && $entry != '..') {
                $el = "$path/$entry";
                if (is_dir($el)) {
                    $langMessage = array_merge($langMessage, static::getLangMessages($el));
                    continue;
                }

                if (is_file($el)) {
                    require_once $el;
                    preg_match("/lang\/[^\/]+\/(.+)/", $el, $match);
                    $langMessage[$match[1]] = isset($MESS) ? (array) $MESS : [];
                }
            }
        }

        return $langMessage;
    }

    public static function getTemplatePath(string $subDir = ''): string
    {
        return __DIR__ . '/templates' . $subDir;
    }

    public static function getCurrentPath(string $subDir = ''): string
    {
        return realpath('./') . $subDir;
    }

    public static function strToCamelCase(string $str, array $delimiter = ['-', '_', '.', ' ']): string
    {
        foreach ($delimiter as $d) {
            $str = static::toCamelCase($str, $d);
        }

        return $str;
    }

    public static function toCamelCase(string $str, string $delimiter = '-'): string
    {
        $result = '';
        $data = explode($delimiter, $str);
        foreach ($data as $part) {
            $result .= ucfirst($part);
        }

        return $result;
    }
}
