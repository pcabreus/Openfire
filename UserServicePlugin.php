<?php

namespace Pcabreus\Openfire;

/***
 * Class UserServicePlugin
 * Openfire plugin userService for user manage.
 *
 * This version of plugin is declared as obsolete by Openfire, but still work. In the future will be migrate to RESTful
 *
 * @package Pcabreus\Openfire
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class UserServicePlugin
{
    const TYPE_ADD = 'add';
    const TYPE_UPDATE = 'update';
    const TYPE_DELETE = 'delete';

    private $consoleAdminHost;
    private $secret;

    /**
     * @param $consoleAdminHost http://example.com:9090
     * @param $secret
     */
    public function __construct($consoleAdminHost, $secret)
    {
        $this->consoleAdminHost = $consoleAdminHost;
        $this->secret = $secret;
    }

    /**
     * @param $username
     * @param $password
     * @param null $name
     * @param null $email
     * @param array $groups
     * @return string
     */
    public function addUser($username, $password, $name = null, $email = null, array $groups = null)
    {
        return $this->buildRequest(UserServicePlugin::TYPE_ADD, $username, $password, $name, $email, $groups);
    }

    /**
     * @param $username
     * @param null $password
     * @param null $name
     * @param null $email
     * @param array $groups
     * @return string
     */
    public function updateUser($username, $password = null, $name = null, $email = null, array $groups = null)
    {
        return $this->buildRequest(UserServicePlugin::TYPE_UPDATE, $username, $password, $name, $email, $groups);
    }

    /**
     * @param $username
     * @return string
     */
    public function deleteUser($username)
    {
        return $this->buildRequest(UserServicePlugin::TYPE_DELETE, $username);
    }

    /**
     * @param $type
     * @param $username
     * @param null|string $password
     * @param null|string $name
     * @param null|string $email
     * @param array $groups
     * @return string
     */
    public function buildRequest($type, $username, $password = null, $name = null, $email = null, array $groups = null)
    {
        $request = sprintf(
            '%s/plugins/userService/userservice?type=%s&secret=%s&username=%s',
            $this->consoleAdminHost,
            $type,
            $this->secret,
            $username
        );
        if ($password) {
            $request .= sprintf('&password=%s', $password);
        }

        if ($name) {
            $request .= sprintf('&name=%s', urlencode($name));
        }
        if ($email) {
            $request .= sprintf('&email=%s', $email);
        }
        if ($groups) {
            $request .= sprintf('&groups=%s', $groups);
        }

        return $request;
    }

} 