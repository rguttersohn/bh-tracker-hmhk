<?php
namespace App\Http\Controllers;

trait InvalidMessages{

    private function getInvalidMessage($env):array{
        return [
            'error' => "'{$env}' is not a valid environment"
        ];
    }
}