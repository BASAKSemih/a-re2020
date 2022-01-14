<?php

namespace App\Security\Voter;

use App\Entity\Thermician;
use App\Entity\Ticket;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ThermicianActiveVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return 'CAN_EDIT' === $attribute
            && $subject instanceof Ticket;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        /* @var Ticket $subject */
        return $subject->getActiveThermician() === $user;
    }
}
