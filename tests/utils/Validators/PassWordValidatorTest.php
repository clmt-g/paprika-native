<?php

namespace tests;

use Paprika\utils\Validators\PassWordValidator;
use PHPUnit\Framework\TestCase;

class PassWordValidatorTest extends TestCase
{
    private PassWordValidator $validator;

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nYES IT WORKS!\n");
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new PassWordValidator();
    }

    // ----------------- CAS DE TEST -----------------

    public function testPasswordTooShort(): void
    {
        self::assertFalse($this->validator->validate('A1!bc')); // 5 caractères
    }

    public function testPasswordNoUppercase(): void
    {
        self::assertFalse($this->validator->validate('abcdef1234!@#')); // 13 caractères, pas de majuscule
    }

    public function testPasswordNoLowercase(): void
    {
        self::assertFalse($this->validator->validate('ABCDEFGHI123!')); // 14 caractères, pas de minuscule
    }

    public function testPasswordNoNumber(): void
    {
        self::assertFalse($this->validator->validate('Abcdefghijk!')); // 13 caractères, pas de chiffre
    }

    public function testPasswordNoSpecialChar(): void
    {
        self::assertFalse($this->validator->validate('Abcdefgh1234')); // 13 caractères, pas de spécial
    }

    public function testPasswordValidSimple(): void
    {
        self::assertTrue($this->validator->validate('Abcd1234!@#$')); // 13 caractères, ok
    }

    public function testPasswordValidLong(): void
    {
        self::assertTrue($this->validator->validate('LongPassword123!')); // 16 caractères, ok
    }

    public function testPasswordLettersAndNumbers(): void
    {
        self::assertFalse($this->validator->validate('Abcd12345678')); // 12 caractères, pas de spécial
    }

    public function testPasswordLettersAndSpecial(): void
    {
        self::assertFalse($this->validator->validate('Abcd!@#$%^&*')); // 12 caractères, pas de chiffre
    }

    public function testPasswordComplex(): void
    {
        self::assertTrue($this->validator->validate('1abcd!@#EfgH')); // 13 caractères, ok
    }

    // ----------------- FIN DES TESTS -----------------

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nDONE\n");
    }
}