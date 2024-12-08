<?php

declare(strict_types=1);

namespace Proton\View;

class View 
{
    public static function make(string $view, $params = []): void
    {
        if (!is_array($params)) {
            $params = ['data' => $params];
        }

        $baseContent = self::getBaseContent();
        $viewContent = self::getViewContent($view, false, $params);

        echo str_replace('{{content}}', $viewContent, $baseContent);
    }

    public static function makeError(string $error): void
    {
        try {
            echo self::getViewContent($error, true);
        } catch (\RuntimeException $e) {
            echo "<h1>Error: Unable to load error view.</h1>";
            echo "<p>{$e->getMessage()}</p>";
        }
    }

    protected static function getBaseContent(): string
    {
        $filePath = base_path() . '/views/layouts/main.php';

        if (!file_exists($filePath)) {
            throw new \RuntimeException("Layout file not found: {$filePath}");
        }

        ob_start();
        include $filePath;
        return ob_get_clean();
    }

    protected static function getViewContent($view, $isError = false, $params = [])
    {
        $viewPath = self::resolveViewPath($view, $isError);

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View file not found: {$viewPath}");
        }

        foreach ($params as $key => $value) {
            if (is_string($value)) {
                $params[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }

        extract($params);

        ob_start();
        include $viewPath;
        return ob_get_clean();
    }

    protected static function resolveViewPath(string $view, bool $isError): string
    {
        $basePath = $isError ? view_path() . 'errors/' : view_path();

        if (str_contains($view, '.')) {
            $viewParts = explode('.', $view);
            foreach ($viewParts as $part) {
                if (is_dir($basePath . $part)) {
                    $basePath .= $part . '/';
                }
            }
            return $basePath . end($viewParts) . '.php';
        }

        return $basePath . $view . '.php';
    }
} 