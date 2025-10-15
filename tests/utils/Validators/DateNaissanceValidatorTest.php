<?php

namespace tests;

use Paprika\utils\Validators\DateNaissanceValidator;
use PHPUnit\Framework\TestCase;

class DateNaissanceValidatorTest extends TestCase
{
    private DateNaissanceValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new DateNaissanceValidator();
    }

    /**
     * Teste une date valide (entre 18 et 120 ans)
     */
    public function testValidDate(): void
    {
        $validDate = (new \DateTime('-25 years'))->format('Y-m-d');
        $this->assertTrue(
            $this->validator->validate($validDate),
            "Une personne de 25 ans doit être valide"
        );
    }

    /**
     * Teste une date trop jeune (<18 ans)
     */
    public function testTooYoung(): void
    {
        $tooYoung = (new \DateTime('-17 years'))->format('Y-m-d');
        $this->assertFalse(
            $this->validator->validate($tooYoung),
            "Une personne de 17 ans doit être invalide"
        );
    }

    /**
     * Teste une date trop âgée (>120 ans)
     */
    public function testTooOld(): void
    {
        $tooOld = (new \DateTime('-121 years'))->format('Y-m-d');
        $this->assertFalse(
            $this->validator->validate($tooOld),
            "Une personne de 121 ans doit être invalide"
        );
    }

    /**
     * Teste une date invalide (mauvais format)
     */
    public function testInvalidFormat(): void
    {
        $this->assertFalse(
            $this->validator->validate('31/12/2000'),
            "Une date au format non Y-m-d doit être invalide"
        );

        $this->assertFalse(
            $this->validator->validate('2000-02-30'),
            "Une date inexistante doit être invalide"
        );
    }

    /**
     * Teste une date limite (exactement 18 ans)
     */
    public function testExactly18(): void
    {
        $exact18 = (new \DateTime('-18 years'))->format('Y-m-d');
        $this->assertTrue(
            $this->validator->validate($exact18),
            "Une personne de 18 ans doit être valide"
        );
    }

    /**
     * Teste une date limite (exactement 120 ans)
     */
    public function testExactly120(): void
    {
        $exact120 = (new \DateTime('-120 years'))->format('Y-m-d');
        $this->assertTrue(
            $this->validator->validate($exact120),
            "Une personne de 120 ans doit être valide"
        );
    }
}