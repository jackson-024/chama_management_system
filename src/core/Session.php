<?php

namespace app\core;

class Session
{
    // session constants
    protected const FLASH_KEY = "flash_messages";
    protected const FLASH_KEY_ERROR = "flash_messages_error";
    protected const FLASH_KEY_SUCCESS = "flash_messages_success";

    public function __construct()
    {
        // initialize session
        session_start();

        // check if any message exists on the session
        // if null set to empty array
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        // if found loop through 
        foreach ($flashMessages as $key => &$flashMessage) {
            // set to be removed
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    // 
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'removed' => false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    // the work of destruct will be to clear the session
    // 
    public function __destruct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove']) {
                // unset($_SESSION[self::FLASH_KEY][$key]);
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
