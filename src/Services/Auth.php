<?php

namespace Proton\Services;
 
use App\Models\User;

class Auth
{
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();
        
        if ($user && password_verify($password, $user->password)) {
          
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_name'] = $user->name;
            return true;
        }

        return false;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    public function check()
    {
        return isset($_SESSION['user_id']);
    }

    public function user()
    {
        if ($this->check()) {
            return User::find($_SESSION['user_id']);
        }
        return null;
    }

    public function id()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function email()
    {
        return $_SESSION['user_email'] ?? null;
    }

    public function name()
    {
        return $_SESSION['user_name'] ?? null;
    }

    public function requireAuth()
    {
        if (!$this->check()) {
            header('Location: /login');
            exit;
        }
    }

    public function guest()
    {
        return !$this->check();
    }
}