<?php

namespace App\Services\ToolsV2;

/** Saisie refusée : le message est affiché tel quel à l'utilisateur (HTTP 422). */
class InvalidInputException extends \RuntimeException
{
}
