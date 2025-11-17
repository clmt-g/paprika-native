<?php

namespace utils\validators;

use Paprika\utils\validators\MailValidator;
use Paprika\utils\validators\NameValidator;
use PHPUnit\Framework\TestCase;

class MailValidatorTest extends TestCase
{
    private MailValidator $validator;
    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nInitializing NameValidator tests...\n");
    }

    public function setUp(): void
    {
        parent::setUp();
        fwrite(STDOUT, __METHOD__ . "\nSetting up test...\n");
        $this->validator = new MailValidator();
    }

    // ============ Tests valides supplémentaires ============

    // -- avec tirets et underscores --
    public function testValidMailWithDashAndUnderscore(): void {
        $result = $this->validator->validate('jean-paul_dupont@test.com');
        $this->assertTrue($result);
    }

    // -- avec chiffres --
    public function testValidMailWithNumbers(): void {
        $result = $this->validator->validate('user123@domain456.com');
        $this->assertTrue($result);
    }

    // -- avec sous-domaine --
    public function testValidMailWithSubdomain(): void {
        $result = $this->validator->validate('user@mail.example.com');
        $this->assertTrue($result);
    }

    // -- extension longue --
    public function testValidMailWithLongExtension(): void {
        $result = $this->validator->validate('contact@example.info');
        $this->assertTrue($result);
    }

    // -- avec point dans le nom --
    public function testValidMailWithDotInName(): void {
        $result = $this->validator->validate('prenom.nom@test.fr');
        $this->assertTrue($result);
    }

    // ============ Tests invalides supplémentaires ============

    // ---- Problèmes avec @ ----

    // -- plusieurs @ --
    public function testMultipleAtSymbols(): void {
        $result = $this->validator->validate('test@@test.com');
        $this->assertFalse($result);
    }

    // -- sans @ --
    public function testWithoutAtSymbol(): void {
        $result = $this->validator->validate('testtest.com');
        $this->assertFalse($result);
    }

    // -- @ au début --
    public function testAtSymbolAtStart(): void {
        $result = $this->validator->validate('@test@test.com');
        $this->assertFalse($result);
    }

    // ---- Problèmes avec le point ----

    // -- point au début du domaine --
    public function testDotAtStartOfDomain(): void {
        $result = $this->validator->validate('user@.example.com');
        $this->assertFalse($result);
    }

    // -- point à la fin du domaine --
    public function testDotAtEndOfDomain(): void {
        $result = $this->validator->validate('user@example.com.');
        $this->assertFalse($result);
    }

    // -- doubles points --
    public function testConsecutiveDots(): void {
        $result = $this->validator->validate('user@test..com');
        $this->assertFalse($result);
    }

    // -- point au début du nom --
    public function testDotAtStartOfName(): void {
        $result = $this->validator->validate('.user@test.com');
        $this->assertFalse($result);
    }

    // -- point à la fin du nom --
    public function testDotAtEndOfName(): void {
        $result = $this->validator->validate('user.@test.com');
        $this->assertFalse($result);
    }

    // ---- Problèmes avec les espaces ----

    // -- espace dans le nom --
    public function testSpaceInName(): void {
        $result = $this->validator->validate('user name@test.com');
        $this->assertFalse($result);
    }

    // -- espace dans le domaine --
    public function testSpaceInDomain(): void {
        $result = $this->validator->validate('user@test domain.com');
        $this->assertFalse($result);
    }

    // -- espaces autour --
    public function testSpacesAround(): void {
        $result = $this->validator->validate(' user@test.com ');
        $this->assertFalse($result);
    }

    // ---- Caractères spéciaux invalides ----

    // -- parenthèses --
    public function testParenthesesInEmail(): void {
        $result = $this->validator->validate('user(name)@test.com');
        $this->assertFalse($result);
    }

    // -- virgules --
    public function testCommaInEmail(): void {
        $result = $this->validator->validate('user,name@test.com');
        $this->assertFalse($result);
    }

    // ---- Domaines invalides ----

    // -- que des chiffres dans le domaine --
    public function testOnlyNumbersInDomain(): void {
        $result = $this->validator->validate('user@12345.678');
        $this->assertFalse($result);
    }

    // -- tiret au début du domaine --
    public function testDashAtStartOfDomain(): void {
        $result = $this->validator->validate('user@-test.com');
        $this->assertFalse($result);
    }

    // -- tiret à la fin du domaine --
    public function testDashAtEndOfDomain(): void {
        $result = $this->validator->validate('user@test-.com');
        $this->assertFalse($result);
    }

    // ---- Cas extrêmes ----

    // -- seulement des espaces --
    public function testOnlySpaces(): void {
        $result = $this->validator->validate('   ');
        $this->assertFalse($result);
    }

    // -- caractères unicode --
    public function testUnicodeCharacters(): void {
        $result = $this->validator->validate('usér@tést.com');
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
