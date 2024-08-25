<?php

class Validate
{

    public function validateName($name)
    {
        if (!is_string($name) || !preg_match('/^[a-zA-Zа-яА-Я]+$/u', $name)) {
            return false;
        }
        return true;
    }

    public function validatePhone($phone)
    {
        $phone = preg_replace('/\s+/', '', $phone);

        if (strpos($phone, '+') !== 0) {
            return false;
        }

        if (!ctype_digit(substr($phone, 1))) {
            return false;
        }

        $length = strlen($phone);
        if ($length < 12 || $length > 15) {
            return false;
        }

        return true;
    }

    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function getCountryByPhone($phone)
    {
        $prefix = substr($phone, 0, 2);

        switch ($prefix) {
            case '7':
                return 'Россия';
            case '8':
                return 'Россия';
            case '1':
                return 'США/Канада';
            case '3':
                return 'Китай';
            case '4':
                return 'Франция';
            case '5':
                return 'Бразилия';
            case '6':
                return 'Австралия';
            case '9':
                return 'Индия';
            default:
                return 'Неизвестная страна';
        }
    }
}
