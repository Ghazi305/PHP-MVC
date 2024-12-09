<?php
namespace Proton\Http;

class Response 
{
    /**
     * @param int $code  setStatusCode
     */  
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * @return $this
     */
    public function back(): self
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        
        header("Location: /");
        exit;
    }
    
    /**
     * return response JSON.
     */
    public function json($data, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * return response  Text.
     */
    public function text($data, $statusCode)
    {
        header('Content-Type: text/plain');
        http_response_code($statusCode);
        echo $data;
        exit;
    }

    /**
     * return response  HTML.
     */
    public function html($data, $statusCode)
    {
        header('Content-Type: text/html');
        http_response_code($statusCode);
        echo $data;
        exit;
    }
} 