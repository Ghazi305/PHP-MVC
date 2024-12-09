<?php
namespace Proton\Http;

class Response 
{
    /**
     * تعيين كود الحالة للرد (مثل 200, 404, 500، إلخ).
     *
     * @param int $code كود الحالة
     */ 
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * إعادة التوجيه إلى الصفحة السابقة.
     * 
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
     * إرسال استجابة بصيغة JSON.
     */
    public function json($data, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit; // تأكد من إيقاف تنفيذ السكربت بعد إرسال الاستجابة
    }

    /**
     * إرسال استجابة بصيغة نصية.
     */
    public function text($data, $statusCode)
    {
        header('Content-Type: text/plain');
        http_response_code($statusCode);
        echo $data;
        exit; // تأكد من إيقاف تنفيذ السكربت بعد إرسال الاستجابة
    }

    /**
     * إرسال استجابة بصيغة HTML.
     */
    public function html($data, $statusCode)
    {
        header('Content-Type: text/html');
        http_response_code($statusCode);
        echo $data;
        exit; // تأكد من إيقاف تنفيذ السكربت بعد إرسال الاستجابة
    }
} 