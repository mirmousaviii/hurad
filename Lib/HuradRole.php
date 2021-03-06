<?php
/**
 * Role & Capabilities library
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */

/**
 * Class HuradRole
 */
class HuradRole
{
    /**
     * Roles
     *
     * @var array
     */
    protected static $roles = [];

    /**
     * Capabilities
     *
     * @var array
     */
    protected static $caps = [];

    /**
     * Add role
     *
     * @param string $slug         Role slug
     * @param string $name         Role name
     * @param array  $capabilities Role capabilities
     */
    public static function addRole($slug, $name, array $capabilities = [])
    {
        if (!self::roleExists($slug)) {
            self::$roles[$slug] = [
                'name' => $name,
                'capabilities' => $capabilities
            ];
            Configure::write('Hurad.roles', self::$roles);
        }
    }

    /**
     * Check exist role or not
     *
     * @param string $roleSlug Role slug
     *
     * @return bool
     */
    public static function roleExists($roleSlug)
    {
        return Hash::check(self::$roles, $roleSlug);
    }

    /**
     * Get role
     *
     * @param string $roleSlug Role slug
     *
     * @return null If role not exist return null otherwise return role
     */
    public static function getRole($roleSlug)
    {
        if (self::roleExists($roleSlug)) {
            return self::$roles[$roleSlug];
        } else {
            return null;
        }
    }

    /**
     * Remove role
     *
     * @param string $roleSlug Role slug
     *
     * @return bool
     */
    public static function removeRole($roleSlug)
    {
        if (self::roleExists($roleSlug)) {
            unset(self::$roles[$roleSlug]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Add capability to role
     *
     * @param string $roleSlug Role slug
     * @param string $cap      Role Capability
     */
    public static function addCap($roleSlug, $cap)
    {
        if (self::roleExists($roleSlug)) {
            if (!self::capExists($roleSlug, $cap)) {
                self::$caps[$roleSlug][] = $cap;
                $result = Hash::insert(self::$roles, $roleSlug . '.capabilities', self::$caps[$roleSlug]);

                self::$roles = $result;
                Configure::write('Hurad.caps', self::$caps);
            }
        }
    }

    /**
     * Check capability exist or not
     *
     * @param string $roleSlug Role slug
     * @param string $cap      Role capability
     *
     * @return bool
     */
    public static function capExists($roleSlug, $cap)
    {
        if (count(self::$caps) > 0 && isset(self::$caps[$roleSlug])) {
            return in_array($cap, self::$caps[$roleSlug]);
        } else {
            return false;
        }
    }
}
