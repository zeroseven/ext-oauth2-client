<?php

namespace Waldhacker\Oauth2Client\Service;

use TYPO3\CMS\Core\SingletonInterface;

class SessionService implements SingletonInterface
{
    /**
     * @var string
     */
    protected string $sessionKey;

    /**
     * Constructor
     */
    public function __construct()
    {
        if (session_id() === '') {
            session_start();
            $this->sessionKey = 'tx_zwi_keycloak';
        }
    }

    /**
     * @param string $sessionKey
     */
    public function setSessionKey(string $sessionKey): void
    {
        $this->sessionKey = $sessionKey;
    }

    /**
     * Returns the current session key
     *
     * @return string
     */
    public function getSessionKey(): string
    {
        return $this->sessionKey;
    }

    /**
     * Exchanges the complete session data
     *
     * @param mixed $data
     */
    public function exchangeData($data): void
    {
        $this->destroy();
        $_SESSION[$this->sessionKey] = $data;
    }

    /**
     * Returns the complete session data
     *
     * @return mixed
     */
    public function getData()
    {
        return $_SESSION[$this->sessionKey];
    }

    /**
     * Sets data inside the session below the given key
     *
     * @param string $key
     * @param mixed $data
     */
    public function setDataByKey(string $key, $data): void
    {
        $_SESSION[$this->sessionKey][$key] = $data;
    }

    /**
     * Returns data of the session defined by the given key
     *
     * @param string $key
     * @return mixed
     */
    public function getDataByKey(string $key)
    {
        return $_SESSION[$this->sessionKey][$key];
    }

    /**
     * Removes data defined by the given key.
     *
     * @param string $key
     */
    public function unsetDataByKey(string $key): void
    {
        unset($_SESSION[$this->sessionKey][$key]);
    }

    /**
     * Removes all session data
     */
    public function destroy(): void
    {
        unset($_SESSION[$this->sessionKey]);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasDataByKey(string $key): bool
    {
        return isset($_SESSION[$this->sessionKey][$key]);
    }
}
