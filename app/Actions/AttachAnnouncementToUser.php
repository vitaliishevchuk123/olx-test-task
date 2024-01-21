<?php

namespace App\Actions;

use App\Entities\Announcement;
use App\Entities\User;
use Doctrine\DBAL\Connection;

class AttachAnnouncementToUser
{
    public function handle(Announcement $announcement, User $user, Connection $connection): bool
    {
        $queryBuilder = $connection->createQueryBuilder();

        $queryBuilder
            ->insert('announcement_user')
            ->values([
                'user_id' => ':user_id',
                'announcement_id' => ':announcement_id',
            ])
            ->setParameters([
                'user_id' => $user->getId(),
                'announcement_id' => $announcement->getId(),
            ])->executeQuery();

        return true;
    }
}