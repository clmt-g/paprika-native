<?php

namespace utils\validators;

use Paprika\utils\validators\GradeValidator;
use Paprika\utils\validators\MailValidator;
use PHPUnit\Framework\TestCase;

class GradeValidatorTest extends TestCase
{
    private GradeValidator $validator;

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nInitializing NameValidator tests...\n");
    }

    public function setUp(): void
    {
        parent::setUp();
        fwrite(STDOUT, __METHOD__ . "\nSetting up test...\n");
        $this->validator = new GradeValidator();
    }

    // ============ Tests valides - Tous les grades existants ============

    public function testValidGrade1C(): void
    {
        $result = $this->validator->validate('1C');
        $this->assertTrue($result);
    }

    public function testValidGradeAC(): void
    {
        $result = $this->validator->validate('AC');
        $this->assertTrue($result);
    }

    public function testValidGradeAd(): void
    {
        $result = $this->validator->validate('Ad');
        $this->assertTrue($result);
    }

    public function testValidGradeCa(): void
    {
        $result = $this->validator->validate('Ca');
        $this->assertTrue($result);
    }

    public function testValidGradeCC(): void
    {
        $result = $this->validator->validate('CC');
        $this->assertTrue($result);
    }

    public function testValidGradeCt(): void
    {
        $result = $this->validator->validate('Ct');
        $this->assertTrue($result);
    }

    public function testValidGradeIn(): void
    {
        $result = $this->validator->validate('In');
        $this->assertTrue($result);
    }

    public function testValidGradeLt(): void
    {
        $result = $this->validator->validate('Lt');
        $this->assertTrue($result);
    }

    public function testValidGradeMa(): void
    {
        $result = $this->validator->validate('Ma');
        $this->assertTrue($result);
    }

    public function testValidGradeSC(): void
    {
        $result = $this->validator->validate('SC');
        $this->assertTrue($result);
    }

    public function testValidGradeSg(): void
    {
        $result = $this->validator->validate('Sg');
        $this->assertTrue($result);
    }

    public function testValidGradeSp(): void
    {
        $result = $this->validator->validate('Sp');
        $this->assertTrue($result);
    }

    // ============ Tests invalides ============

    // -- Grade qui n'existe pas --
    public function testInvalidGradeXX(): void
    {
        $result = $this->validator->validate('XX');
        $this->assertFalse($result);
    }
    // -- 1 caractère --
    public function testOneCharacterA(): void
    {
        $result = $this->validator->validate('A');
        $this->assertFalse($result);
    }
    // -- 3 caractères --
    public function testThreeCharactersABC(): void
    {
        $result = $this->validator->validate('ABC');
        $this->assertFalse($result);
    }
    // -- 3 caractères (nombres)
    public function testThreeCharacters123(): void
    {
        $result = $this->validator->validate('123');
        $this->assertFalse($result);
    }
    // -- Vide --
    public function testEmptyString(): void
    {
        $result = $this->validator->validate('');
        $this->assertFalse($result);
    }
    // -- Caractères spéciaux --
    public function testGradeWithSpecialChar(): void
    {
        $result = $this->validator->validate('A@');
        $this->assertFalse($result);
    }

    public function tearDown(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nCleaning up after test...\n");
        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nDONE!\n");
    }
}
