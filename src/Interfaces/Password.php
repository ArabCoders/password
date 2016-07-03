<?php
/**
 * This file is part of {@see arabcoders\password} package.
 *
 * (c) 2015-2016 Abdul.Mohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\password\Interfaces;

use arabcoders\password\
{
    Exceptions\PasswordException
};

/**
 * Password Interface
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
Interface Password
{
    /**
     * Set Password
     *
     * @param string $password
     *
     * @throws PasswordException  if password is empty.
     *
     * @return Password
     */
    public function setPassword( string $password ): Password;

    /**
     * Get cleartext Password.
     *
     * @return string
     */
    public function getPassword(): string;

    /**
     * Set Hash
     *
     * @param string $hash
     *
     * @throws PasswordException  if $hash is empty or unreadable by underlying library.
     *
     * @return Password
     */
    public function setHash( string $hash ): Password;

    /**
     * Get Hashed Password
     *
     * @return string
     */
    public function getHash(): string;

    /**
     * Check whether the password is Hashed or not.
     *
     * @return bool
     */
    public function isHashed(): bool;

    /**
     * set Salt do not use it if you dont know what you are doing
     * let the underlying password librarry handles it.
     *
     * @param string $salt
     *
     * @throws PasswordException  if $salt is empty.
     *
     * @return Password
     */
    public function setSalt( string $salt ): Password;

    /**
     * get Salt.
     *
     * @return string
     */
    public function getSalt(): string;

    /**
     * Set Iteration Count Cost.
     *
     * @param int $cost
     *
     * @return Password
     */
    public function setCost( int $cost ): Password;

    /**
     * get Cost.
     *
     * @return int
     */
    public function getCost(): int;

    /**
     * set Hashing Algo.
     *
     * @param int $algo
     *
     * @return Password
     */
    public function setAlgo( int $algo ): Password;

    /**
     * get Hashing Algo.
     *
     * @return int
     */
    public function getAlgo(): int;

    /**
     * Hash the password
     *
     * @return Password
     */
    public function hash(): Password;

    /**
     * Check wether the password and hash matches
     *
     * @return bool
     */
    public function verify(): bool;

    /**
     * Check whether The hash need to be rehashed for new settings.
     *
     * @return bool
     */
    public function needsRehash(): bool;

}