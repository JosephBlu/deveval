<?php
/**
 * Created by PhpStorm.
 * User: josephramirez
 * Date: 4/22/17
 * Time: 9:04 PM
 */

namespace deveval\home\deveval;


/**
 * Full PHPUnit test for the Email class
 *
 * This is a complete PHPUnit test of the Email class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see email
 * @author Joseph Ramirez <JosephJRamirezWD@gmail.com>
 **/
class EmailTest extends \PHPUnit_Framework_TestCase {

	/**
	 *timestamp of the emai; this starts as null and is assigned later
	 * @var DateTime $VALID_EMAILTIMESENT
	 */
	protected $VALID_EMAILTIMESENT = null;

	/**
	 * Email address of the recipient
	 *@var string $VALID_EMAILADDRESSSENT
	 */
	protected $VALID_EMAILADDRESSSENT = "Email sent";

//	/**
//	 * the id f the email sent
//	 * @var emailId
//	 */
//	protected $email = null;

	/**
	 * create dependent objects before running each test
	 */

	//calculate the date (just use the time unit test was setup)
	$this->VALID_EMAILTIMESENT = new\DateTime;

	/**
	 * test inserting a valid email and verify the actual mySQl data matches
	 */
public function testInsertValidEmail(){
	//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("email");

	//create a new email and insert it into mySQL
	$email = new Email(null, $this->VALID_EMAILTIMESENT, $this->VALID_EMAILADDRESSSENT );
	$email->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$pdoEmail = Email::getEmailbyEmailId($this->getPDO(), $email->getEmailId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("email"));
	$this->assertEquals($pdoEmail->getEmailTimeSent(), $this->VALID_EMAILTIMESENT);
	$this->assertEquals($pdoEmail->getEmailAddressSent(), $this->VALID_EMAILADDRESSSENT);
}


}
