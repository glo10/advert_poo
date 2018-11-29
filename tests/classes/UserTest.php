<?php
  namespace Advert_poo\Tests\Classes;
  use PHPUnit\Framework\TestCase;
  use Advert_poo\Classes\User;
  use Advert_poo\Classes\FilterException;

  class UserTest extends TestCase{
    private $user;

    public function setUp(){
      $this->user = new User('email@email.com','firsName','lastName');
    }

    public function tearDown(){
      $this->user = null;
    }

    /**
     * @dataProvider userAttributes
     */
    public function testUserClass($attr,$userClass){
      $this->assertClassHasAttribute($attr,$userClass);
    }

    public function testEmail(){
      $this->assertSame('email@email.com',$this->user->getEmail());

      $this->assertInstanceOf(User::class,$this->user);

      $this->expectException('Advert_poo\Classes\FilterException',$this->user->getEmail());
      $this->user->setEmail('');

      $this->expectException('Advert_poo\Classes\FilterException',$this->user->getEmail());
      $this->user->setEmail(100000);

      $this->expectException('Advert_poo\Classes\FilterException',$this->user->getEmail());
      $this->user->setEmail('fake@');
    }

    public function testFirstName(){
      $this->assertSame('firsName',$this->user->getFirstName());
      $this->assertNotNull($this->user->getFirstName());
    }

    public function testLastName(){
      $this->assertSame('lastName',$this->user->getLastName());
      $this->assertNotNull($this->user->getLastName());
      $this->expectException('Advert_poo\Classes\FilterException',$this->user->getLastName());
      $this->user->setLastName('a');
    }

    public function userAttributes(){
      return [
        ['email',User::class],
        ['firstName',User::class],
        ['lastName',User::class],
        ['pswd',User::class],
        ['pdo',User::class],
        ['advertCollection',User::class]
      ];
    }
    //
    // public function testPswd(){
    //
    // }
    //
    // public function testAdvertCollection(){
    //
    // }
    //
    // public function testInsertUser(){
    //
    // }
    //
    // public function testUpdateUser(){
    //
    // }
    //
    // public function testConnectUser(){
    //
    // }
  }
