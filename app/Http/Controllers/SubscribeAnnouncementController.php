<?php

namespace App\Http\Controllers;

use App\Actions\CreateAnnouncement;
use App\Actions\CreateUser;
use App\Entities\Announcement;
use App\Entities\User;
use App\Forms\User\SubscribeAnnouncementForm;
use App\Http\Request;
use App\Repositories\AnnouncementRepository;
use App\Repositories\UserRepository;
use Doctrine\DBAL\Connection;

class SubscribeAnnouncementController extends AbstractController
{
    public function subscribe(Request $request, Connection $connection)
    {
        //1. Валідація даних за допомогою кастомного Form класу
        $form = (new SubscribeAnnouncementForm())
            ->setFields(
                $request->input('email'),
                $request->input('url'),
                $request->input('name'),
            )->validate();

        if ($form->hasValidationErrors()) {
            $this->errorResponse($form->getValidationErrors());
        }

        //2. Перевірка(якщо нема збереження) юзера
        $user = (new UserRepository())->findByEmail($request->input('email'), $connection);

        if (!$user) {
            $user = User::fill(
                $request->input('email'),
                new \DateTimeImmutable(),
                $request->input('name'),
            );
            (new CreateUser())->handle($user, $connection);
        }

        //3. Перевірка(якщо нема збереження) оголошення
        $announcement = (new AnnouncementRepository())->findByUrl($request->input('url'), $connection);

        if (!$announcement) {
            $announcement = Announcement::fill(
                url: $request->input('url'),
                createdAt: new \DateTimeImmutable(),
                price: $request->input('price'),
            );
            (new CreateAnnouncement())->handle($announcement, $connection);
        }

        //4. Перевірка чи є звʼязка юзер - оголошення в БД(якщо нема створюємо)

//        echo json_encode([
//            'name'=> $user->getName(),
//        ], JSON_UNESCAPED_UNICODE);
        echo json_encode([
            'message'=> "Користувача {$user->getName()} підписано на оголошення {$request->input('url')}",
        ], JSON_UNESCAPED_UNICODE);
    }
}
