<?php

namespace App\Http\Controllers;

use App\Actions\CreateUser;
use App\Entities\User;
use App\Forms\User\SubscribeAnnouncementForm;
use App\Http\Request;
use App\Repositories\UserRepository;
use Doctrine\DBAL\Connection;

class SubscribeAnnouncementController extends AbstractController
{
    public function subscribe(Request $request, Connection $connection)
    {
        $form = (new SubscribeAnnouncementForm())
            ->setFields(
                $request->input('email'),
                $request->input('url'),
                $request->input('name'),
            )->validate();

        if ($form->hasValidationErrors()) {
            $this->errorResponse($form->getValidationErrors());
        }

        //1. Перевірка(якщо нема збереження) юзера
        $user = (new UserRepository())->findByEmail($request->input('email'), $connection);

        if (!$user) {
            $user = User::fill(
                $request->input('email'),
                new \DateTimeImmutable(),
                $request->input('name'),
            );
            (new CreateUser())->handle($user, $connection);
        }

        //2. Перевірка(якщо нема збереження) оголошення
        //3. Перевірка чи є звʼязка юзер - оголошення в БД(якщо нема створюємо)

//        echo json_encode([
//            'name'=> $user->getName(),
//        ], JSON_UNESCAPED_UNICODE);
        echo json_encode([
            'message'=> "Користувача {$user->getName()} підписано на оголошення {$request->input('url')}",
        ], JSON_UNESCAPED_UNICODE);
    }
}
