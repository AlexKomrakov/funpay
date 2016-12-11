<?php

namespace funpay;

/**
 * User: komrakov
 * Date: 11.12.16
 * Time: 21:01
 */
class Payment
{

    /**
     * @var
     */
    public $code;

    /**
     * @var
     */
    public $sum;

    /**
     * @var
     */
    public $receiver;

    public function __construct($code, $sum, $receiver)
    {
        $this->code = $code;
        $this->sum = $sum;
        $this->receiver = $receiver;
    }

    /**
     * FIXME Функция не сохраняет валюту указанную в смс.
     * FIXME Исходим из того что оплаты проводятся только в рублях
     *
     * @param $string
     *
     * @return Payment
     *
     * @throws \Exception
     */
    public static function fromSMS($string): Payment
    {
        preg_match('/[^0-9]+(?P<code>[0-9]{4})[^0-9]+(?P<sum>[0-9,]+)[^0-9,]+(?P<receiver>[0-9]+)/s', $string, $matches);
        // Для проверки корректности достаточно проверить наличие только 1 элемента
        if (!isset($matches['code'])) {
            throw new \Exception("Не удалось получить информацию об оплате из строки: $string");
        }

        return new static($matches['code'], $matches['sum'], $matches['receiver']);
    }

}