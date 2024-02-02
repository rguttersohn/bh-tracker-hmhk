<?php
namespace App\Http\Controllers\Traits;

trait InvalidMessages{

    private function getInvalidMessage($env):array{
        return [
            'error' => "'{$env}' is not a valid environment"
        ];
    }
}