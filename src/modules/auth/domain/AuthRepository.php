<?php

namespace modules\auth\domain;

use modules\students\domain\StudentEmail;

interface AuthRepository
{
    function check(StudentEmail $email): bool;

    function login(User $user): bool;
}