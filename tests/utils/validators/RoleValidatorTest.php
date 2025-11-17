<?php

namespace utils\validators;

use Paprika\utils\validators\RoleValidator;
use PHPUnit\Framework\TestCase;

class RoleValidatorTest extends TestCase
{
    private RoleValidator $validator;

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\nInitializing RoleValidator tests...\n");
    }

    public function setUp(): void
    {
        parent::setUp();
        fwrite(STDOUT, __METHOD__ . "\nSetting up test...\n");
        $this->validator = new RoleValidator();
    }

    // ============ Tests valides - Tous les rôles existants ============

    public function testValidRoleDefault(): void
    {
        $result = $this->validator->validate('default');
        $this->assertTrue($result);
    }

    public function testValidRoleSecretaire(): void
    {
        $result = $this->validator->validate('secretaire');
        $this->assertTrue($result);
    }

    public function testValidRoleAdmin(): void
    {
        $result = $this->validator->validate('admin');
        $this->assertTrue($result);
    }

    // ============ Tests invalides ============

    public function testInvalidRoleEmpty(): void
    {
        $result = $this->validator->validate('');
        $this->assertFalse($result);
    }

    public function testInvalidRoleUnknown(): void
    {
        $result = $this->validator->validate('user');
        $this->assertFalse($result);
    }

    public function testInvalidRoleSpecialChars(): void
    {
        $result = $this->validator->validate('adm!n');
        $this->assertFalse($result);
    }

    public function testInvalidRoleNumeric(): void
    {
        $result = $this->validator->validate('123');
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
