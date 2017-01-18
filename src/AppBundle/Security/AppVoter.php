<?php

namespace AppBundle\Security;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AppVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW        = 'view';
    const EDIT        = 'edit';
    const CREATE_POST = 'create_post';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * AppVoter constructor.
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * @inheritdoc
     */
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::CREATE_POST))) {
            return false;
        }

        // only vote on this objects inside this voter
        if (!($subject instanceof Post || $subject instanceof Comment || $subject instanceof User)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        $roleAdmin = $this->decisionManager->decide($token, array('ROLE_ADMIN'));
        $roleAuthor = $this->decisionManager->decide($token, array('ROLE_AUTHOR'));

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_ADMIN can do anything! The power!
        if ($roleAdmin) {
            return true;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::CREATE_POST:
                if ($roleAuthor) {
                    return true;
                }
        }
    }

    /**
     * @param mixed $subject
     * @param User  $user
     *
     * @return bool
     */
    private function canView($subject, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($subject, $user)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $subject
     * @param User  $user
     *
     * @return bool
     */
    private function canEdit($subject, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $subject->getUser();
    }
}
