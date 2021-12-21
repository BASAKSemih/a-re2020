<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class OwnerProjectVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return 'IS_OWNER' === $attribute
            && $subject instanceof Project;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();
        /** @var Project $subject */
        return $subject->getUser() === $user;
    }
}
