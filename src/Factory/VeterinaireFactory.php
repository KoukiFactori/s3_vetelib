<?php

namespace App\Factory;

use App\Entity\Veterinaire;
use App\Repository\VeterinaireRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Veterinaire>
 *
 * @method        Veterinaire|Proxy                     create(array|callable $attributes = [])
 * @method static Veterinaire|Proxy                     createOne(array $attributes = [])
 * @method static Veterinaire|Proxy                     find(object|array|mixed $criteria)
 * @method static Veterinaire|Proxy                     findOrCreate(array $attributes)
 * @method static Veterinaire|Proxy                     first(string $sortedField = 'id')
 * @method static Veterinaire|Proxy                     last(string $sortedField = 'id')
 * @method static Veterinaire|Proxy                     random(array $attributes = [])
 * @method static Veterinaire|Proxy                     randomOrCreate(array $attributes = [])
 * @method static VeterinaireRepository|RepositoryProxy repository()
 * @method static Veterinaire[]|Proxy[]                 all()
 * @method static Veterinaire[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Veterinaire[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Veterinaire[]|Proxy[]                 findBy(array $attributes)
 * @method static Veterinaire[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Veterinaire[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class VeterinaireFactory extends ModelFactory
{
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();

        return [
            'address' => self::faker()->streetAddress(),
            'birthdate' => self::faker()->dateTime(),
            'city' => self::faker()->city(),
            'email' => transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($firstname)).'.'.transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($lastname)).'@'.self::faker()->domainName(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'zipcode' => self::faker()->postcode(),
            'password' => 'miaou'
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Veterinaire $veterinaire) {
                $veterinaire->setPassword($this->passwordHasher->hashPassword($veterinaire, $veterinaire->getPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Veterinaire::class;
    }
}
