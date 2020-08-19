<?php

declare(strict_types=1);

namespace App\Bootloader;

use App\Repository\UserRepository;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Bootloader\Auth\AuthBootloader as FrameworkAuthBootloader;

class AuthBootloader extends Bootloader
{
    public function boot(FrameworkAuthBootloader $auth): void
    {
        $auth->addActorProvider(UserRepository::class);
    }
}