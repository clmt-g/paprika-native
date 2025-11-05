<?php

namespace tests\Utils\Validators;

use Paprika\Utils\Validators\PhoneValidator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Paprika\Utils\Validators\PhoneValidator
 */
class PhoneValidatorTest extends TestCase
{
    private PhoneValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new PhoneValidator();
    }

    public function testInvalidPhone(): void
    {
        $this->assertFalse($this->validator->validate("12345"));
        $this->assertFalse($this->validator->validate("abcdefg"));
        $this->assertFalse($this->validator->validate("123456789"));
        $this->assertFalse($this->validator->validate("06123-45678"));
    }

    public function testValidPhoneNational(): void
    {
        $this->assertTrue($this->validator->validate("0612345678"));
        $this->assertTrue($this->validator->validate("0610000000"));
        $this->assertTrue($this->validator->validate("0101010101"));
    }

    public function testValidPhoneInternational(): void
    {
        $this->assertTrue($this->validator->validate("+33612345678"));
        $this->assertTrue($this->validator->validate("+4901010101010"));
    }

    public function testValidPhoneWithSeparators(): void
    {
        $this->assertTrue($this->validator->validate("06 12 34 56 78"));
        $this->assertTrue($this->validator->validate("+33 6 12 34 56 78"));
    }
}