<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Support\Enum;

/**
 * Description of RoleTypes
 *
 * @author Dinkic
 */
class RoleTypes
{
    const ADMIN = 'admin';
    const USER = 'user';
    const MANAGER = 'manager';

    public static function all()
    {
        return [
            self::ADMIN,
            self::USER,
            self::MANAGER,

        ];
    }
    
    public static function stringify()
    {
        return implode(",", self::all());
    }
}
