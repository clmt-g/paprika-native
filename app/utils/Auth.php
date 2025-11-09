<?php

namespace Paprika\utils;

use Paprika\model\User;

class Auth
{

    private array $link = [
        'default' => [
            'pompier_show', 'caserne_show'
        ],
        'secretaire' => [
            'pompier_show', 'caserne_show',
            'pompier_save',
            'pompier_delete',
            'pompier_update'
        ],
        'admin' => [
            'pompier_show', 'caserne_show',
            'pompier_save', 'caserne_save',
            'pompier_delete', 'caserne_delete',
            'pompier_update', 'caserne_update',
            'user_show',
            'user_save',
            'user_delete',
            'user_update'
        ]
    ];
    // ...

    /** check if user exist in DB, and login
     * @param string $log
     * @param string $password
     * @return User|null
     */
    public static function login(string $log, string $password): ?User
    {
        // TODO : check user exist with DAO
        // TODO : create session and store defined data in seesion
        $_SESSION = [
            'auth' => [
                'id' => $id,
                'nom' => $nom,
                'prenom' => $prenom,
                'role' => $role
            ]
        ];
        // TODO : log actions to log file...
    }

    public static function logout() : void {
        // TODO : delete 'auth' in $_SESSION and redirect to login page
    }

    /** check if a user is already logged
     * @return bool
     */
    public static function isLogged(): bool {
        // TODO : check if 'auth' is defined in $_SESSION
    }

    public static function has(string $role) : bool {
        // renvoie si l'utilisateur à le bon role en vérifiant en session
    }

    public static function can(string $perm) : bool {
        // dit si un user à les droits de faire une action (coder en dure)
        // recupère le rôle dans la session et vérifie qu'il à le droit
    }

}