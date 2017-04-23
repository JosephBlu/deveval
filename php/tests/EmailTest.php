<?php
/**
 * Created by PhpStorm.
 * User: josephramirez
 * Date: 4/22/17
 * Time: 9:04 PM
 */

namespace deveval\home\deveval;

use Deveval\Home\deveval\Email;
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

	/**
	 * the id f the email sent
	 * @var emailId
	 */
	protected $email = null;

	/**
	 * create dependent objects before running each test
	 */

	//create and insert the email info that was sent
	$this->email = new Email(null, "valid@gmail.com");


}
