<?php
namespace utils\validators;

use Paprika\utils\validators\NameValidator;
use PHPUnit\Framework\TestCase;

class NameValidatorTest extends TestCase
{
    private NameValidator $validator;

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nInitializing NameValidator tests...\n");
    }

    public function setUp(): void
    {
        parent::setUp();
        fwrite(STDOUT, __METHOD__ . "\nSetting up test...\n");
        $this->validator = new NameValidator();
    }

    // ============ Tests valides ============
    public function testValidNameSimple(): void
    {
        $result = $this->validator->validate('Jean');
        $this->assertTrue($result, "Name 'Jean' should be valid");
    }

    public function testValidNameWithSpace(): void
    {
        $result = $this->validator->validate('Jean Pierre');
        $this->assertTrue($result, "Name 'Jean Pierre' should be valid");
    }

    public function testValidNameWithHyphen(): void
    {
        $result = $this->validator->validate('Jean-Pierre');
        $this->assertTrue($result, "Name 'Jean-Pierre' should be valid");
    }

    public function testValidNameWithApostrophe(): void
    {
        $result = $this->validator->validate("O'Brien");
        $this->assertTrue($result, "Name 'O'Brien' should be valid");
    }

    public function testValidNameWithAccents(): void
    {
        $result = $this->validator->validate('José');
        $this->assertTrue($result, "Name 'José' should be valid");
    }

    public function testValidNameWithMultipleAccents(): void
    {
        $result = $this->validator->validate('François Léopold');
        $this->assertTrue($result, "Name 'François Léopold' should be valid");
    }

    public function testValidNameMinimumLength(): void
    {
        $result = $this->validator->validate('Leo');
        $this->assertTrue($result, "Name 'Leo' (3 characters) should be valid");
    }

    public function testValidNameMaximumLength(): void
    {
        $result = $this->validator->validate('Jean-Pierre-François-Marie');
        $this->assertTrue($result, "Name 'Jean-Pierre-François-Marie' (32 characters) should be valid");
    }

    public function testValidNameWithMultipleSpaces(): void
    {
        $result = $this->validator->validate('Marie Claire Anne');
        $this->assertTrue($result, "Name 'Marie Claire Anne' should be valid");
    }

    // ============ Tests invalides - Longueur ============
    public function testNameTooShort(): void
    {
        $result = $this->validator->validate('Jo');
        $this->assertFalse($result, "Name 'Jo' (2 characters) should fail");
    }

    public function testNameTooLong(): void
    {
        $result = $this->validator->validate('Jean-Pierre-François-Marie-Anne-Robert');
        $this->assertFalse($result, "Name longer than 32 characters should fail");
    }

    // ============ Tests invalides - Chiffres ============
    public function testNameWithNumbers(): void
    {
        $result = $this->validator->validate('Jean123');
        $this->assertFalse($result, "Name with numbers should fail");
    }

    public function testNameWithOnlyNumbers(): void
    {
        $result = $this->validator->validate('12345');
        $this->assertFalse($result, "Name with only numbers should fail");
    }

    // ============ Tests invalides - Caractères spéciaux ============
    public function testNameWithSpecialCharacterAt(): void
    {
        $result = $this->validator->validate('Jean@Pierre');
        $this->assertFalse($result, "Name with '@' should fail");
    }

    public function testNameWithSpecialCharacterHash(): void
    {
        $result = $this->validator->validate('Jean#Pierre');
        $this->assertFalse($result, "Name with '#' should fail");
    }

    public function testNameWithSpecialCharacterDollar(): void
    {
        $result = $this->validator->validate('Jean$Pierre');
        $this->assertFalse($result, "Name with '$' should fail");
    }

    public function testNameWithSpecialCharacterPercent(): void
    {
        $result = $this->validator->validate('Jean%Pierre');
        $this->assertFalse($result, "Name with '%' should fail");
    }

    public function testNameWithSpecialCharacterAmpersand(): void
    {
        $result = $this->validator->validate('Jean&Pierre');
        $this->assertFalse($result, "Name with '&' should fail");
    }

    // ============ Tests invalides - Symboles ============
    public function testNameWithExclamationMark(): void
    {
        $result = $this->validator->validate('Jean!Pierre');
        $this->assertFalse($result, "Name with '!' should fail");
    }

    public function testNameWithQuestion(): void
    {
        $result = $this->validator->validate('Jean?Pierre');
        $this->assertFalse($result, "Name with '?' should fail");
    }

    public function testNameWithComma(): void
    {
        $result = $this->validator->validate('Jean,Pierre');
        $this->assertFalse($result, "Name with ',' should fail");
    }

    public function testNameWithDot(): void
    {
        $result = $this->validator->validate('Jean.Pierre');
        $this->assertFalse($result, "Name with '.' should fail");
    }

    public function testNameWithSlash(): void
    {
        $result = $this->validator->validate('Jean/Pierre');
        $this->assertFalse($result, "Name with '/' should fail");
    }

    public function testNameWithBackslash(): void
    {
        $result = $this->validator->validate('Jean\\Pierre');
        $this->assertFalse($result, "Name with '\\' should fail");
    }

    public function testNameWithParenthesis(): void
    {
        $result = $this->validator->validate('Jean(Pierre)');
        $this->assertFalse($result, "Name with '()' should fail");
    }

    public function testNameWithBrackets(): void
    {
        $result = $this->validator->validate('Jean[Pierre]');
        $this->assertFalse($result, "Name with '[]' should fail");
    }

    // ============ Tests invalides - Vide/Espaces ============
    public function testNameEmpty(): void
    {
        $result = $this->validator->validate('');
        $this->assertFalse($result, "Empty name should fail");
    }

    public function testNameOnlySpaces(): void
    {
        $result = $this->validator->validate('   ');
        $this->assertFalse($result, "Name with only spaces should fail");
    }

    public function testNameOnlyTabs(): void
    {
        $result = $this->validator->validate("\t\t\t");
        $this->assertFalse($result, "Name with only tabs should fail");
    }

    public function testNameOnlyNewlines(): void
    {
        $result = $this->validator->validate("\n\n\n");
        $this->assertFalse($result, "Name with only newlines should fail");
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