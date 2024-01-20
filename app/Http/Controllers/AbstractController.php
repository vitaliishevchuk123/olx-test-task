<?php

namespace App\Http\Controllers;

class AbstractController
{
    public function errorResponse(array $errors)
    {
        echo json_encode($errors, JSON_UNESCAPED_UNICODE);
        exit();
    }
}
