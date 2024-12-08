<?php

namespace Proton\Http;

use Symfony\Component\VarDumper\VarDumper;

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
            exit; // تأكد من إنهاء السكربت بعد التوجيه
        }

        // في حال عدم وجود HTTP_REFERER، التوجيه إلى الصفحة الرئيسية
        header("Location: /");
        exit;
    }

    /**
     * إرسال استجابة بتنسيق JSON.
     * 
     * @param mixed $data البيانات التي سيتم إرسالها بتنسيق JSON
     * @param int $statusCode كود الحالة (اختياري، الافتراضي هو 200)
     * @return void
     */
    public function json($data, int $statusCode = 200): void
    {
        // تعيين كود الحالة
        $this->setStatusCode($statusCode);

        // تحديد نوع المحتوى
        header('Content-Type: application/json; charset=UTF-8');

        // إرسال البيانات بتنسيق JSON
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit; // تأكد من إنهاء السكربت بعد إرسال البيانات
    }

    /**
     * إرسال استجابة بتنسيق نصي.
     * 
     * @param string $text النص الذي سيتم إرساله
     * @param int $statusCode كود الحالة (اختياري، الافتراضي هو 200)
     * @return void
     */
    public function text(string $text, int $statusCode = 200): void
    {
        // تعيين كود الحالة
        $this->setStatusCode($statusCode);

        // تحديد نوع المحتوى
        header('Content-Type: text/plain; charset=UTF-8');

        // إرسال النص
        echo $text;
        exit; // تأكد من إنهاء السكربت بعد إرسال البيانات
    }

    /**
     * إرسال استجابة بتنسيق HTML.
     * 
     * @param string $html المحتوى HTML الذي سيتم إرساله
     * @param int $statusCode كود الحالة (اختياري، الافتراضي هو 200)
     * @return void
     */
    public function html(string $html, int $statusCode = 200): void
    {
        // تعيين كود الحالة
        $this->setStatusCode($statusCode);

        // تحديد نوع المحتوى
        header('Content-Type: text/html; charset=UTF-8');

        // إرسال HTML
        echo $html;
        exit; // تأكد من إنهاء السكربت بعد إرسال البيانات
    }
}