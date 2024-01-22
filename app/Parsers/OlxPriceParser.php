<?php

namespace App\Parsers;

use App\Actions\UpdateAnnouncementPrice;
use App\Entities\Announcement;
use App\Entities\User;
use App\Helpers\Str;
use App\Mail\MailHogMailer;
use App\Repositories\AnnouncementRepository;

class OlxPriceParser extends AbstractParser
{
    public function parse()
    {
        $this->logger->info('Старт перевірки ціни оголошень в базі даних...');

        foreach ((new AnnouncementRepository($this->connection))->all() as $announcement) {
            try {
                $this->checkPrice($announcement);
            } catch (\Throwable $e) {
                $this->logger->error("{$e->getMessage()}. File: {$e->getFile()}. Line: {$e->getLine()}");
            }
        }

        $this->logger->info('Кінець перевірки ціни оголошень в базі даних!');
    }

    public function checkPrice(Announcement $announcement): void
    {
        $url = $announcement->getUrl();
        $crawler = $this->request('GET', $url);
        $priceText = $crawler->filter('.css-12vqlj3')->first()->text();
        $price = Str::make($priceText)
            ->replace(' ', '')
            ->trim(' грн.')
            ->toInt();
        if ($price !== $announcement->getPrice()) {
            (new UpdateAnnouncementPrice)->handle($announcement, $price, $this->connection);
            dump("Оновлено ціну оголошення {$announcement->getUrl()} на {$priceText}");
            $this->logger->info("Оновлено ціну оголошення {$announcement->getUrl()} на {$priceText}");
            $announcementUsers = (new AnnouncementRepository($this->connection))->getUsers($announcement);

            /** @var User $user */
            foreach ($announcementUsers->all() as $user) {
                $mailer = new MailHogMailer(
                    $user->getEmail(),
                    "Оновлено ціну оголошення OLX",
                    "Оновлено ціну оголошення {$announcement->getUrl()} на {$priceText}",
                    "sender@example.com",
                );
                if ($mailer->send()) {
                    dump("Лист успішно відправлено");
                    $this->logger->info("Лист успішно відправлено");
                } else {
                    dump("Помилка при відправленні листа");
                    $this->logger->info("Помилка при відправленні листа");
                }
            }
            return;
        }

        dump("Ціна оголошення {$announcement->getUrl()} не змінилась");
        $this->logger->info("Ціна оголошення {$announcement->getUrl()} не змінилась");
    }
}
