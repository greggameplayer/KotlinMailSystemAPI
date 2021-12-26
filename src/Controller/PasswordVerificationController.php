<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Process;

class PasswordVerificationController extends AbstractController
{

    public static function password_verification($password, $hash): bool
    {
        $process = new Process(['doveadm', 'pw', '-s', 'SSHA512', '-t', $hash, '-p', $password]);
        $process->run();

        return $process->isSuccessful();
    }

}
