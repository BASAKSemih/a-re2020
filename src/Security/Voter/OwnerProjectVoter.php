<?php

namespace App\Security\Voter;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class OwnerProjectVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === 'IS_OWNER'
            && $subject instanceof \App\Entity\Project;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();
        return $subject->getUser() === $user;
    }
}
