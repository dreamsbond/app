<?php namespace App\Authorization;

use App\Data\Seeds\PassportSeed;
use App\Json\Schemes\UserSchema as Schema;
use Limoncello\Application\Contracts\Authorization\ResourceAuthorizationRulesInterface;
use Limoncello\Auth\Contracts\Authorization\PolicyInformation\ContextInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @package App
 */
class UserRules implements ResourceAuthorizationRulesInterface
{
    use RulesTrait;

    /** Action name */
    const ACTION_VIEW_USERS = 'canViewUsers';

    /** Action name */
    const ACTION_MANAGE_USERS = 'canManageUsers';

    /** Action name */
    const ACTION_VIEW_USER_POSTS = 'canViewUserPosts';

    /** Action name */
    const ACTION_VIEW_USER_COMMENTS = 'canViewUserComments';

    /**
     * @inheritdoc
     */
    public static function getResourcesType(): string
    {
        return Schema::TYPE;
    }

    /**
     * @param ContextInterface $context
     *
     * @return bool
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function canViewUsers(ContextInterface $context): bool
    {
        return self::hasScope($context, PassportSeed::SCOPE_ADMIN_USERS);
    }

    /**
     * @param ContextInterface $context
     *
     * @return bool
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function canManageUsers(ContextInterface $context): bool
    {
        return self::hasScope($context, PassportSeed::SCOPE_ADMIN_USERS);
    }

    /**
     * @param ContextInterface $context
     *
     * @return bool
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function canViewUserPosts(ContextInterface $context): bool
    {
        return self::ctxHasCurrentAccount($context);
    }

    /**
     * @param ContextInterface $context
     *
     * @return bool
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function canViewUserComments(ContextInterface $context): bool
    {
        return self::ctxHasCurrentAccount($context);
    }
}
