<?php

class Helper
{
    public static function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }

    public static function timeAgo(DateTime $dateTime): string
    {
        $diff = (new DateTime())->getTimestamp() - $dateTime->getTimestamp();
        if ($diff < 3600) {
            $minutes = max(1, (int)floor($diff / 60));
            return "{$minutes} minutes ago";
        }
        if ($diff < 86400) {
            $hours = max(1, (int)floor($diff / 3600));
            return "{$hours} hours ago";
        }
        return $dateTime->format('d/m/Y');
    }
}

