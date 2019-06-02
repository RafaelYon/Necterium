<?php

namespace App\Security\Auth;

use App\Security\Session;
use App\Security\Hash;
use App\Models\User;

class Auth
{
    private const SESSION_KEY = 'security.auth.session_key';
    
    private $id;
    private $user;

    private function __construct(User $user = null)
    {
        if ($user == null)
            return;

        $this->id = $user->id;
        $this->user = $user;
    }

    private function retriveUser()
    {
        if (empty($this->user))
        {
            $this->user = User::find($this->id);
            Session::set(config(self::SESSION_KEY), $this);
        }
    }
    
    public static function getCurrent()
    {
        $instance = Session::get(config(self::SESSION_KEY));

        if (empty($instance))
            return new static();

        return $instance;
    }

    public static function user()
    {
        if (!self::check())
            return null;
        
        $instance = self::getCurrent();

        return $instance->user;
    }

    public static function check() : bool
    {
        $instance = self::getCurrent();

        if (is_null($instance->id))
            return false;
        
        if (!is_numeric($instance->id))
            return false;

        $instance->retriveUser();

        if (empty($instance->user))
        {
            Session::remove(config(self::SESSION_KEY));
            return false;
        }

        return true;
    }

    public static function loginDirect(User $user)
    {
        Session::set(
            config(self::SESSION_KEY),
            new Auth($user)
        );
    }

    public static function attempt($email, $password) : bool
    {
        try
        {
            $user = User::new()->where('email', $email)
                        ->firstOrFail();

            if (!Hash::check($password, $user->password))
                return false;
          
            self::loginDirect($user);

            return true;
        }
        catch (\Exception $ex)
        {
            return false;
        }
    }

    public static function logout()
    {
        Session::remove(config(self::SESSION_KEY));
    }
}