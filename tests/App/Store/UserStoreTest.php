<?php
namespace App\Store;

use PHPUnit\Framework\TestCase;

/**
 * UserStore test case with phpunit.
 */
class UserStoreTest extends TestCase
{

    /**
     * @var \App\Store\UserStore
     */
    private $userStore;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->userStore = new UserStore();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->userStore = null;
        parent::tearDown();
    }

    /**
     * @expectedException \Exception
     */
    public function testAddExistingUser()
    {
        $this->userStore
            ->addUser('Elie', 'elie29@gmail.com', 'a123456')
            ->addUser('Elie', 'elie29@gmail.com', 'v123456');
    }

    /**
     * @expectedException \Exception
     */
    public function testAddSmallPassword()
    {
        $this->userStore
            ->addUser('Elie', 'elie29@gmail.com', 'me');
    }

    /**
     * Tests UserStore->notifyPasswordFailure()
     */
    public function testNotifyPasswordFailure()
    {
        $user = $this->userStore
            ->addUser('Elie', 'elie29@gmail.com', 'o-123456')
            ->notifyPasswordFailure('elie29@gmail.com')
            ->getUser('elie29@gmail.com');

        self::assertArrayHasKey('failed', $user);
    }

    /**
     * Tests UserStore->getUser()
     */
    public function testGetUser()
    {
        $user = $this->userStore
            ->addUser('Elie', 'elie29@gmail.com', 'kl-123456')
            ->getUser('elie29@gmail.com');

        self::assertArrayHasKey('pass', $user);
    }

    /**
     * @dataProvider usersProvider
     */
    public function testAddUser(string $nom, string $email, string $pass, bool $expectedException)
    {
        if ($expectedException) {
            $this->expectException(\Exception::class);
        }

        $this->userStore->addUser($nom, $email, $pass);

        self::assertArrayHasKey('name', $this->userStore->getUser($email));
    }

    public function usersProvider()
    {
        return [
            'Add user elie' => ['Elie', 'elie29@gmail.com', '123456', false],
            'Add user elie' => ['Elie', 'elie29@gmail.com', 'cv-124', false],
            'Add user with wrong password' => ['Elie', 'elie29@gmail.com', 'ds', true],
            'Add user mike' => ['Mike', 'mike@mail.com', '', true],
        ];
    }
}

