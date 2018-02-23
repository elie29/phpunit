<?php

namespace App\Store;

use Assert\Assertion;

class UserStore
{

    protected $users = array();

    /**
     * Add a new user to the store.
     *
     * @param string $name user's name.
     * @param string $mail user's email.
     * @param string $pass user's password.
     *
     * @return \App\Store\UserStore
     * @throws \Assert\InvalidArgumentException
     */
    public function addUser(string $name, string $mail, string $pass): self
    {
        Assertion::keyNotExists($this->users, $mail);
        Assertion::minLength($pass, 5);

        $this->users[$mail] = array(
            'pass' => $pass,
            'mail' => $mail,
            'name' => $name
        );
        return $this;
    }

    /**
     * Set a fail message in the store.
     *
     * @param string $mail User's mail.
     *
     * @return \App\Store\UserStore
     */
    public function notifyPasswordFailure(string $mail): self
    {
        if (isset($this->users[$mail])) {
            $this->users[$mail]['failed'] = time();
        }

        return $this;
    }

    /**
     * Return user's info.
     *
     * @param string $mail User's mail.
     *
     * @return mixed [pass, mail, name, ?failed]
     */
    public function getUser(string $mail): array
    {
        return $this->users[$mail];
    }
}
