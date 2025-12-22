<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (!function_exists('route_url')) {
    function route_url(string $route, array $params = []): string
    {
        $query = http_build_query(array_merge(['route' => $route], $params));
        return '?' . $query;
    }
}

if (!function_exists('esc')) {
    function esc(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('old_input')) {
    function old_input(array $old, string $key, mixed $default = ''): mixed
    {
        return $old[$key] ?? $default;
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah(int $angka): string
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('build_youtube_embed_src')) {
    function build_youtube_embed_src(?string $videoUrl): string
    {
        if (!$videoUrl) {
            return '';
        }

        $videoUrl = trim($videoUrl);
        $parsed = parse_url($videoUrl);
        $embedBase = $videoUrl;

        if ($parsed && !empty($parsed['host'])) {
            $host = strtolower($parsed['host']);
            if (str_contains($host, 'youtu.be')) {
                $videoId = ltrim($parsed['path'] ?? '', '/');
                if ($videoId) {
                    $embedBase = 'https://www.youtube.com/embed/' . $videoId;
                }
            } elseif (str_contains($host, 'youtube.com')) {
                parse_str($parsed['query'] ?? '', $query);
                if (!empty($query['v'])) {
                    $embedBase = 'https://www.youtube.com/embed/' . $query['v'];
                } elseif (!empty($parsed['path']) && str_contains($parsed['path'], '/embed/')) {
                    $embedBase = $videoUrl;
                }
            }
        }

        if (!str_contains($embedBase, 'youtube.com/embed')) {
            return '';
        }

        $separator = str_contains($embedBase, '?') ? '&' : '?';
        $embedBase .= $separator . 'autoplay=1&mute=1&rel=0&controls=0';

        return htmlspecialchars($embedBase, ENT_QUOTES, 'UTF-8');
    }
}
?>
