<?php

namespace tests;

use Paprika\utils\Validators\MailValidator;
use PHPUnit\Framework\TestCase;

class MailValidatorTest extends TestCase
{
    private MailValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new MailValidator();
    }

    /**
     * Teste un email invalide
     */
    public function testInvalidMail(): void
    {
        $this->assertFalse(
            $this->validator->validate("invalid-mail"),
            "L'email 'invalid-mail' doit être considéré comme invalide"
        );
    }

    /**
     * Teste un email valide
     */
    public function testValidMail(): void
    {
        $this->assertTrue(
            $this->validator->validate("test@example.com"),
            "L'email 'test@example.com' doit être considéré comme valide"
        );
    }

    /**
     * Teste un email avec sous-domaine
     */
    public function testValidMailWithSubdomain(): void
    {
        $this->assertTrue(
            $this->validator->validate("user@mail.example.com"),
            "Les emails avec sous-domaines doivent être valides"
        );
    }

    /**
     * Teste un email avec caractères spéciaux autorisés
     */
    public function testValidMailWithSpecialChars(): void
    {
        $this->assertTrue(
            $this->validator->validate("user.name+alias@example.com"),
            "Les emails avec caractères spéciaux valides doivent être acceptés"
        );
    }

    /**
     * Teste un email vide
     */
    public function testEmptyMail(): void
    {
        $this->assertFalse(
            $this->validator->validate(""),
            "Un email vide doit être considéré comme invalide"
        );
    }
}