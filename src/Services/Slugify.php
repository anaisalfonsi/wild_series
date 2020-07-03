<?php


namespace App\Services;

class Slugify
{
    public function generate(string $input) : string
    {
        $utf8 = array(
            '/[áàâãªäå]/u' => 'a',
            '/[@ÁÀÂÃÄÅ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/[ýÿ]/u' => 'y',
            '/[Ý]/u' => 'Y',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/ /' => '-', // espace insécable (équiv. à 0x160)
            '|([^a-zA-Z0-9]+)|' => '-'
        );
        $str = preg_replace(array_keys($utf8), array_values($utf8), $input);

        $str = trim($str, '-');

        $slug = mb_strtolower($str);

        return $slug;
    }
}