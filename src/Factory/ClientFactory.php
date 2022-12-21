<?php

namespace App\Factory;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Client>
 *
 * @method        Client|Proxy create(array|callable $attributes = [])
 * @method static Client|Proxy createOne(array $attributes = [])
 * @method static Client|Proxy find(object|array|mixed $criteria)
 * @method static Client|Proxy findOrCreate(array $attributes)
 * @method static Client|Proxy first(string $sortedField = 'id')
 * @method static Client|Proxy last(string $sortedField = 'id')
 * @method static Client|Proxy random(array $attributes = [])
 * @method static Client|Proxy randomOrCreate(array $attributes = [])
 * @method static ClientRepository|RepositoryProxy repository()
 * @method static Client[]|Proxy[] all()
 * @method static Client[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Client[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Client[]|Proxy[] findBy(array $attributes)
 * @method static Client[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Client[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ClientFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {   
        $firstname=self::faker()->firstName();
        $lastname=self::faker()->lastName();
        
        return [
            'address' => self::faker()->streetadress(),
            'birthdate' => self::faker()->dateTime(),
            'city' => self::faker()->cityName(),
            'email' => transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($firstname)).'.'.transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($lastname)).'@'.self::faker()->domainName(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'zipcode' => self::faker()->departmentNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Client $client): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Client::class;
    }
}
