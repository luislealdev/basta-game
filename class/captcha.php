<?php
class Captcha
{
    function captcha()
    {
        $result = 0;
        // CAPTCHA
        $operators = "+-*/";
        $ope1 = $operators[rand(0, 3)];
        $ope2 = $operators[rand(0, 3)];

        $dig1 = rand(1, 9);
        $result = $dig1;
        $dig2 = rand(1, 9);
        $dig3 = rand(1, 9);

        $result = $this->resolve($dig1, $dig2, $ope1);
        $result = $this->resolve($result, $dig3, $ope2);

        $cap = $dig1 . $ope1 . $dig2 . $ope2 . $dig3;
        return $cap . '=' . $result;
    }

    function resolve($digit1, $digit2, $operator)
    {
        switch ($operator) {
            case '+':
                return $digit1 + $digit2;
            case '-':
                return $digit1 - $digit2;
            case '*':
                return $digit1 * $digit2;
            case '/':
                return $digit1 / $digit2;
        }
    }
}

$oCaptcha = new Captcha();
