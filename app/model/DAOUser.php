<?php

namespace Paprika\model;

class DAOUser
{


    public function find($id) : User {

    }

    public function save(User $user) : bool
    {
    }

    public function update(User $user) : bool {

    }

    public function delete(User $user) : bool {

    }

    public function findAll($offset, $limit) : array { // offset -> pagination

    }

    public function count() : int {

    }

    /** check if a user exist
     * @param string $login
     * @param string $password
     * @return User|null
     */
    public function checkUserExist(string $login, string $password) : ?User {

    }

}