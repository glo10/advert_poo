<?php
  namespace Advert_poo\Tests\Classes;
  use PHPUnit\Framework\TestCase;
  use Advert_poo\Classes\User;
  use Advert_poo\Classes\FilterException;

  class UserTest extends TestCase{
    private $user;

    public function setUp(){
      $this->user = new User(
                              'email@email.com',
                              'firsName',
                              'lastName',
                              '$2y$10$b'
                            );
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

    public function testPswd(){
      $this->assertNotNull($this->user->getPswd());
      $this->assertRegExp("#[\S]{8,30}#",$this->user->getPswd());
      // $this->expectException('Advert_poo\Classes\FilterException',$this->user->getPswd());
      // $this->user->setPswd(' hello world');
    }

    public function testAdvertCollection(){
      $this->assertNull($this->user->getAdvertCollection());

      $this->user->setAdvertCollection(
                                        [
                                          'advert1',
                                          'advert2',
                                          'advert3'
                                        ]
                                      );

      $this->assertTrue(is_array($this->user->getAdvertCollection()));
      $this->assertNotNull($this->user->getAdvertCollection());

      // $this->expectException('\TypeError',$this->user->getAdvertCollection());
      // $this->user->setAdvertCollection('toto');
    }

    /**
    * @dataProvider typeErrorException
    */
    public function testAdvertCollectionType($val,$expected){
      $this->expectException($expected,$this->user->getAdvertCollection());
      $this->user->setAdvertCollection($val);
    }

    //test method save
    // public function testInsertUser(){
      //TODO
    // }
    //
    //test method update
    // public function testUpdateUser(){
      //TODO
    // }
    //
    //test method connect
    // public function testConnectUser(){
      //TODO
    // }

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

    public function typeErrorException(){
      return [
        ['toto','\TypeError'],
        [10,'\TypeError'],
        [10.25,'\TypeError'],
        [true,'\TypeError'],
        ['','\TypeError'],
        [' ','\TypeError'],
        [new \stdClass(),'\TypeError']
      ];
    }
  }
