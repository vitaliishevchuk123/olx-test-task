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
        $user = (new UserRepository())->findByEmail($request->input('email'), $connection);

        if (!$user) {
            $user = User::fill(
                $request->input('email'),
                new \DateTimeImmutable(),
                $request->input('name'),
            );
            (new CreateUser())->handle($user, $connection);
        }
        dd($user);
        //TODO Юзер створено і збережено в базу, далі треба зберегти оголошення і звязку їхню в півот таблицю
    }
}
