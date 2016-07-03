<?php
/**
 * This file is part of {@see arabcoders\password} package.
 *
 * (c) 2015-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\password;

use arabcoders\password\
{
    Interfaces\Password as PasswordInterface,
    Exceptions\PasswordException as PasswordException
};

/**
 * Password Handler
 *
 * @package arabcoders\password
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Password implements PasswordInterface, \Serializable, \JsonSerializable
{

    /**
     * Default iteration Count
     */
    const COST = 10;

    /**
     * Default Hashing Algorithm.
     */
    const ALGO = PASSWORD_BCRYPT;

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $hashed = '';

    /**
     * @var string
     */
    private $salt = '';

    /**
     * @var bool
     */
    private $isHashed = false;

    /**
     * @var int Hashing Algo.
     */
    private $algo = self::ALGO;

    /**
     * @var int
     */
    private $cost = self::COST;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct( array $options = [ ] )
    {
    }

    public function setPassword( string $password ): PasswordInterface
    {
        if ( empty( $password ) )
        {
            throw new PasswordException( '$password is not set' );
        }

        $this->password = $password;

        return $this;
    }

    public function getPassword(): string
    {
        if ( empty( $this->password ) )
        {
            throw new PasswordException( 'Password was not set' );
        }

        return $this->password;
    }

    public function setHash( string $hash ): PasswordInterface
    {
        if ( empty( $hash ) )
        {
            throw new PasswordException( 'hash is empty' );
        }

        if ( password_get_info( $hash )['algo'] === 0 )
        {
            throw new PasswordException( 'The hash is not understandable by the underlying library' );
        }

        $this->hashed = $hash;

        $this->isHashed = true;

        return $this;
    }

    public function getHash(): string
    {
        if ( empty( $this->hashed ) )
        {
            throw new PasswordException( 'Password was not hashed' );
        }

        return $this->hashed;
    }

    public function isHashed(): bool
    {
        return $this->isHashed;
    }

    public function setSalt( string $salt ): PasswordInterface
    {
        if ( empty( $salt ) )
        {
            throw new PasswordException( 'salt is empty' );
        }

        $this->salt = $salt;

        return $this;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setCost( int $cost ): PasswordInterface
    {
        if ( 0 === $cost )
        {
            throw new PasswordException( 'hashing cost is set to 0' );
        }

        $this->cost = $cost;

        return $this;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setAlgo( int $algo ): PasswordInterface
    {
        $this->algo = $algo;

        return $this;
    }

    public function getAlgo(): int
    {
        return $this->algo;
    }

    public function hash(): PasswordInterface
    {
        if ( empty( $this->password ) )
        {
            throw new PasswordException( 'Password or hash was not set' );
        }

        if ( !( $hash = password_hash( $this->getPassword(), $this->getAlgo(), $this->getOptions() ) ) )
        {
            throw new PasswordException( 'Unable to hash password' );
        }

        $this->setHash( $hash );

        $this->isHashed = true;

        return $this;
    }

    public function verify(): bool
    {
        if ( empty( $this->password ) || empty( $this->hashed ) )
        {
            throw new PasswordException( 'Password or hash was not set' );
        }

        return password_verify( $this->getPassword(), $this->getHash() );
    }

    public function needsRehash(): bool
    {
        if ( empty( $this->hashed ) )
        {
            throw new PasswordException( 'hash was not set' );
        }

        return password_needs_rehash( $this->getHash(), $this->getAlgo(), $this->getOptions() );
    }

    protected function getOptions(): array
    {
        $options = [ ];

        if ( !empty( $this->salt ) )
        {
            $options['salt'] = $this->salt;
        }

        if ( !empty( $this->cost ) )
        {
            $options['cost'] = $this->cost;
        }

        return $options;
    }

    public function __debugInfo()
    {
        return [
            'algo' => $this->algo,
            'salt' => $this->salt,
            'cost' => $this->cost,
        ];
    }

    public function __clone()
    {
        throw new \RuntimeException( 'cloning is not allowed.' );
    }

    public function serialize()
    {
        throw new \RuntimeException( 'serializing is not allowed.' );
    }

    public function unserialize( $serialized )
    {
        throw new \RuntimeException( 'serializing is not allowed.' );
    }

    function jsonSerialize()
    {
        throw new \RuntimeException( 'serializing is not allowed.' );
    }
}