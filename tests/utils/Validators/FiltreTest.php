<?php

namespace tests\utils\Validators;

use Paprika\utils\Filtre;
use Paprika\utils\Validators\DateNaissanceValidator;
use Paprika\utils\Validators\MailValidator;
use Paprika\utils\Validators\PassWordValidator;
use Paprika\utils\Validators\PhoneValidator;
use PHPUnit\Framework\TestCase;

class FiltreTest extends TestCase
{
    private Filtre $filtre;

    protected function setUp(): void
    {
        $this->filtre = new Filtre();

        // Ajout des validateurs
        $this->filtre->addValidator('password', new PassWordValidator());
        $this->filtre->addValidator('email', new MailValidator());
        $this->filtre->addValidator('phone', new PhoneValidator());
        $this->filtre->addValidator('birthdate', new DateNaissanceValidator());
    }

    public function testAllValid(): void
    {
        $data = [
            'password' => 'Azerty123!Qwe',
            'email' => 'test@example.com',
            'phone' => '+33612345678',
            'birthdate' => '2000-01-01',
        ];

        $results = $this->filtre->execute($data);

        $this->assertTrue($results['password']);
        $this->assertTrue($results['email']);
        $this->assertTrue($results['phone']);
        $this->assertTrue($results['birthdate']);
    }

    public function testSomeInvalid(): void
    {
        $data = [
            'password' => '123456',        // invalie
            'email' => 'invalid-email',      // ivalide
            'phone' => '0612345678',    // valide
            'birthdate' => '2010-01-01',     // trop jeune
        ];

        $results = $this->filtre->execute($data);

        $this->assertFalse($results['password']);
        $this->assertFalse($results['email']);
        $this->assertTrue($results['phone']);
        $this->assertFalse($results['birthdate']);
    }

    public function testEmptyValues(): void
    {
        $data = [
            'password' => '',
            'email' => '',
            'phone' => '',
            'birthdate' => '',
        ];

        $results = $this->filtre->execute($data);

        $this->assertFalse($results['password']);
        $this->assertFalse($results['email']);
        $this->assertFalse($results['phone']);
        $this->assertFalse($results['birthdate']);
    }

    public function testExtraFieldIgnored(): void
    {
        $data = [
            'password' => 'Azerty123!Qwe',
            'email' => 'test@example.com',
            'phone' => '+33612345678',
            'birthdate' => '2000-01-01',
            'extra' => 'value', // ne devrait pas casser le filtre
        ];

        $results = $this->filtre->execute($data);

        $this->assertArrayNotHasKey('extra', $results);
    }
}