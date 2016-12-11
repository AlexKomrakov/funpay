<?php

namespace tests;

use funpay\Payment;
use PHPUnit\Framework\TestCase;

/**
 * User: komrakov
 * Date: 11.12.16
 * Time: 21:11
 *
 * @coversDefaultClass funpay\Payment
 */
class PaymentTest  extends TestCase
{

    /**
     * @covers ::fromSMS
     */
    public function testFromSMS()
    {
        $string = "Пароль: 3926 Спишется 301,51р. Перевод на счет 410014316957023";
        $payment = Payment::fromSMS($string);
        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals('3926', $payment->code);
        $this->assertEquals('301,51', $payment->sum);
        $this->assertEquals('410014316957023', $payment->receiver);

        $string = "Пароль: 3926\nСпишется 301,51р.\rПеревод на счет 410014316957023";
        $payment = Payment::fromSMS($string);
        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals('3926', $payment->code);
        $this->assertEquals('301,51', $payment->sum);
        $this->assertEquals('410014316957023', $payment->receiver);

        $string = "Изменено слово: 3926\nСпишется рублей 301,51р.\rПеревод на лицевой счет 410014316957023";
        $payment = Payment::fromSMS($string);
        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertEquals('3926', $payment->code);
        $this->assertEquals('301,51', $payment->sum);
        $this->assertEquals('410014316957023', $payment->receiver);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Не удалось получить информацию об оплате из строки: Изменено слово: 3926Спишется рублей 301,51р');
        $string = "Изменено слово: 3926Спишется рублей 301,51р";
        Payment::fromSMS($string);
    }
    
}