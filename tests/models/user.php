<?php

require_once(dirname(__FILE__)."../../app/models/user.php");

class UserTest extends PHPUnit_Framework_TestCase{

	public function setUp(){ }
  	public function tearDown(){ }

  	public testFind(){
  		$usr = new User(array(
  				'id' => 1,
  				'email' => 'a@a.fr',
  				'password' => 'azraaefaefa',
  				'nickname' => 'toto',
  				'created' => '2014-01-02'
  			));

  		// Create a stub for the SomeClass class.
        $stub = $this->getMockBuilder('Model')
                     ->disableOriginalConstructor()
                     ->getMock();

        // Configure the stub.
        $stub->expects($this->any())
             ->method('execute')
             ->will($this->returnValue(array(

             	)));
  	}

}

?>