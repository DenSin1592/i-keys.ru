<?php namespace App\Services\Auth;

use App\Models\AdminUser;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\UserInterface;
use Illuminate\Hashing\HasherInterface;

/**
 * Class AdminUserProvider
 * Auth provider for admin user. It checks activity and ip.
 *
 * @package App\Services\Auth
 */
class AdminUserProvider extends EloquentUserProvider
{
    private $ipDisableRestriction;

    public function __construct(HasherInterface $hasher, array $ipDisableRestriction = [])
    {
        parent::__construct($hasher, 'App\Models\AdminUser');
        $this->ipDisableRestriction = $ipDisableRestriction;
    }

    public function retrieveById($identifier)
    {
        return $this->filter(parent::retrieveById($identifier));
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->filter(parent::retrieveByToken($identifier, $token));
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->filter(parent::retrieveByCredentials($credentials));
    }

    /**
     * Filter user with additional restrictions.
     *
     * @param UserInterface|null $adminUser
     * @return UserInterface|null
     */
    private function filter(UserInterface $adminUser = null)
    {
        if (!$adminUser instanceof AdminUser) {
            return null;
        }

        if (!$adminUser->active) {
            return null;
        }

        if (!$this->allowedForIp($adminUser)) {
            return null;
        }

        return $adminUser;
    }

    /**
     * Check if admin user is allowed for current user ip.
     *
     * @param AdminUser $adminUser
     * @return bool
     */
    private function allowedForIp(AdminUser $adminUser)
    {
        if (in_array(\App::environment(), $this->ipDisableRestriction)) {
            return true;
        }

        if (empty($adminUser->allowed_ips)) {
            return true;
        }

        return in_array(\Request::getClientIp(), $adminUser->allowed_ips);
    }
}
