<?php

namespace tests;

use Paprika\utils\Validators\PhoneValidator;
use PHPUnit\Framework\TestCase;

class PhoneValidatorTest extends TestCase
{
    private PhoneValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new PhoneValidator();
    }

    /**
     * Teste un numéro invalide (trop court ou mauvais format)
     */
    public function testInvalidPhone(): void
    {
        $this->assertFalse(
            $this->validator->validate("12345"),
            "Le numéro '12345' doit être invalide"
        );

        $this->assertFalse(
            $this->validator->validate("abcdefg"),
            "Un numéro avec lettres doit être invalide"
        );

        $this->assertFalse(
            $this->validator->validate("123456789"),
            "ce n'est possible lo"
        );

        $this->assertFalse(
            $this->validator->validate("06123-45678"),
            "Un numéro avec mauvais séparateur doit être invalide"
        );
    }

    /**
     * Teste un numéro valide français national
     */
    public function testValidPhoneNational(): void
    {
        $this->assertTrue(
            $this->validator->validate("0612345678"),
            "Le numéro '0612345678' doit être valide"
        );

        $this->assertTrue(
            $this->validator->validate("0610000000"),
            "c'est bon ca"
        );

        $this->assertTrue(
            $this->validator->validate("0101010101"),
        );
    }

    /**
     * Teste un numéro valide français international
     */
    public function testValidPhoneInternational(): void
    {
        $this->assertTrue(
            $this->validator->validate("+33612345678"),
            "Le numéro '+33612345678' doit être valide"
        );

        $this->assertTrue(
            $this->validator->validate("+4901010101010"),
            "ca marche c'est chez le H(hamza)"
        );
    }

    /**
     * Teste un numéro avec espaces ou séparateurs corrects
     */
    public function testValidPhoneWithSeparators(): void
    {
        $this->assertTrue(
            $this->validator->validate("06 12 34 56 78"),
            "Les numéros avec espaces doivent être valides"
        );

        $this->assertTrue(
            $this->validator->validate("+33 6 12 34 56 78"),
            "Les numéros internationaux avec espaces doivent être valides"
        );
    }
}