<?php

namespace App\Helpers;

class Text
{

    public static function excerpt(string $content, int $limit = 60)
    {
//        on vérifie si le contenu n'est pas inférieur à la limite
        if (mb_strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . ' ...';
    }
}