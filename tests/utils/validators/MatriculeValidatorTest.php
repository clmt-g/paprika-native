<?php

namespace utils\validators;

use Paprika\utils\validators\MatriculeValidator;
use PHPUnit\Framework\TestCase;

class MatriculeValidatorTest extends TestCase
{
    private MatriculeValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new MatriculeValidator();
    }

    // ============ Tests valides ============

    public function testValidMatricule1(): void
    {
        $result = $this->validator->validate('P000107');
        $this->assertTrue($result);
    }

    public function testValidMatricule2(): void
    {
        $result = $this->validator->validate('P123456');
        $this->assertTrue($result);
    }

    public function testValidMatricule3(): void
    {
        $result = $this->validator->validate('P999999');
        $this->assertTrue($result);
    }

    public function testValidMatriculeWithZeros(): void
    {
        $result = $this->validator->validate('P000000');
        $this->assertTrue($result);
    }

    // ============ Tests invalides ============

    // -- Matricule vide --
    public function testEmptyMatricule(): void
    {
        $result = $this->validator->validate('');
        $this->assertFalse($result);
    }

    // -- Sans P --
    public function testWithoutP(): void
    {
        $result = $this->validator->validate('000107');
        $this->assertFalse($result);
    }

    // -- P minuscule (strict) --
    public function testLowercaseP(): void
    {
        $result = $this->validator->validate('p000107');
        $this->assertFalse($result);
    }

    // -- Trop de chiffres --
    public function testTooManyDigits(): void
    {
        $result = $this->validator->validate('P0001077');
        $this->assertFalse($result);
    }

    // -- Pas assez de chiffres --
    public function testNotEnoughDigits(): void
    {
        $result = $this->validator->validate('P00107');
        $this->assertFalse($result);
    }

    // -- Avec des lettres après P --
    public function testWithLettersAfterP(): void
    {
        $result = $this->validator->validate('P00010A');
        $this->assertFalse($result);
    }

    // -- Avec des espaces --
    public function testWithSpaces(): void
    {
        $result = $this->validator->validate('P 000107');
        $this->assertFalse($result);
    }

    // -- Avec tirets --
    public function testWithDashes(): void
    {
        $result = $this->validator->validate('P-000107');
        $this->assertFalse($result);
    }

    // -- Plusieurs P --
    public function testMultipleP(): void
    {
        $result = $this->validator->validate('PP000107');
        $this->assertFalse($result);
    }

    // -- Chiffres avant P --
    public function testDigitsBeforeP(): void
    {
        $result = $this->validator->validate('123P000107');
        $this->assertFalse($result);
    }

    // -- Autre lettre que P --
    public function testWrongLetter(): void
    {
        $result = $this->validator->validate('A000107');
        $this->assertFalse($result);
    }

    // -- Caractères spéciaux --
    public function testSpecialCharacters(): void
    {
        $result = $this->validator->validate('P@00107');
        $this->assertFalse($result);
    }
}
