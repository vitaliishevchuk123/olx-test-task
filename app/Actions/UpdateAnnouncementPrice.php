<?php

namespace App\Actions;

use App\Entities\Announcement;
use Doctrine\DBAL\Connection;

class UpdateAnnouncementPrice
{
    public function handle(Announcement $announcement, int $price, Connection $connection)
    {
        $queryBuilder = $connection->createQueryBuilder();

        $queryBuilder
            ->update('announcements')
            ->set('price', ':price')
            ->where('id = :id')
            ->setParameters([
                'price' => $price,
                'id' => $announcement->getId(),
            ])
            ->executeQuery();

        return $announcement;
    }
}