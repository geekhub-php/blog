<?php


namespace AppBundle\Security;

use AppBundle\Entity\Comment\Comment;
use AppBundle\Entity\User\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;




class CommentVoter extends Voter
{

    const EDIT = 'edit';
    protected function supports($attribute, $subject)
    {

        if (!in_array($attribute, array(self::EDIT))) {
            return false;
        }


        if (!$subject instanceof Comment) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {

            return false;
        }


        $comment = $subject;

        if($attribute=="edit") {

                return $this->canEdit($comment, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

     private function canEdit(Comment $comment, User $user)
    {

        return $user === $comment->getUser();
    }

}