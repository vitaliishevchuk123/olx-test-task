<?php

namespace App\Actions;

use App\Entities\Announcement;
use Doctrine\DBAL\Connection;

class CreateAnnouncement
{
    public function handle(Announcement $announcement, Connection $connection)
    {
        $queryBuilder = $connection->createQueryBuilder();

        $queryBuilder
            ->insert('announcements')
            ->values([
                'url' => ':url',
                'price' => ':price',
                'created_at' => ':created_at',
            ])
            ->setParameters([
                'url' => $announcement->getUrl(),
                'price' => $announcement->getPrice(),
                'created_at' => $announcement->getCreatedAt()->format('Y-m-d H:i:s'),
            ])->executeQuery();

        $announcement->setId($connection->lastInsertId());

        return $announcement;
    }
}