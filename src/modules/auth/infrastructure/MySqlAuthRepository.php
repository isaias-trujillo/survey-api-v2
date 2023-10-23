<?php

namespace modules\auth\infrastructure;

use Error;
use modules\auth\domain\User;
use modules\auth\domain\AuthRepository;
use modules\shared\infrastructure\MySqlRepository;
use modules\shared\infrastructure\queries\Select;
use modules\students\domain\StudentEmail;
use modules\teachers\domain\Teacher;

class MySqlAuthRepository extends MySqlRepository implements AuthRepository
{

    function login(User $user): bool
    {
        $email = new StudentEmail($user['username']);
        if (!$this->check( $email )) {
            throw new Error("No se encontró al usuario.");
        }
        $query = "select dataalumno_id from dataalumno where upper(Correo) = upper(:email) and Codigo = :code limit 1";
        $parameters = [
            'email' => $user['username'],
            'code' => $user['password'],
        ];

        $request = new Select( $query, $parameters );
        $PDO = $this->connect();
        if (!$request->one( $PDO )) {
            throw new Error( "Contraseña incorrecta" );
        }
        return true;
    }

    function check(StudentEmail $email): bool
    {
        $query = "select dataalumno_id from dataalumno where upper(Correo) = upper(:email) limit 1";
        $parameters = [
            'email' => $email['value'],
        ];

        $request = new Select( $query, $parameters );
        $PDO = $this->connect();

        return !empty($request->one($PDO));
    }
}