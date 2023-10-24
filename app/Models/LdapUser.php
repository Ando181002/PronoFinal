<?php
// app/Models/LdapUser.php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Adldap\Laravel\Traits\HasLdapUser;

class LdapUser extends Model implements AuthenticatableContract
{
    use Authenticatable, HasLdapUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uid', 'cn', 'sn', 'mail', 'other_attributes'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The LDAP attribute used as the username.
     *
     * @var string
     */
    protected $usernameAttribute = 'uid';

    /**
     * The LDAP attribute used as the common name.
     *
     * @var string
     */
    protected $commonNameAttribute = 'cn';

    /**
     * The LDAP attribute used as the email address.
     *
     * @var string
     */
    protected $emailAttribute = 'mail';

    /**
     * The LDAP attribute used as the user's password.
     *
     * @var string
     */
    protected $passwordAttribute = 'userPassword';

    /**
     * The base DN (Distinguished Name) for LDAP queries.
     *
     * @var string
     */
    protected $baseDn = 'ou=mathematicians,dc=example,dc=com';

    /**
     * Validate the user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(array $credentials)
    {
        $username = $credentials['username'];
        $password = $credentials['password'];
    
        if ($this->customAuthLogic($username, $password)) {
            return true; // L'authentification a réussi
        }
    
        return false;
    }
}

