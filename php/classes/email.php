<?php
namespace deveval\home\deveval;

require_once("autoload.php");

use Edu\Cnm\GigHub\ValidateDate;

/**
 * Email class
 *
 * this class is the basis for email creating for the evaluation.
 *
 * @author Joseph Ramirez <JosephJRamirezWD@gmail.com>
 *
 */
class Email {
	use ValidateDate;

	/**
	 * id for this email; this is the primary key
	 * @var int $emailId ;
	 */
	private $emailId;

	/**
	 * date and time the email was sent, in PHP DateTime object
	 * @var \DateTime $emailTimeSent
	 */
	private $emailTimeSent;

	/**
	 * the email address the email was sent to,
	 * @var string $emailAddressSent
	 */
	private $emailAddressSent;

	/**
	 * construct for this email
	 *
	 * @param int|null $newEmailId id of this email or null it a new email
	 * @param \DateTime|string|null $newEmailTimeSent date and time email was sent or null if set to current date and time
	 * @param string $newEmailAddressSent string containing actual email data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings to long, negative intergers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occur
	 */

public function  __construct(int $newEmailId = null, $newEmailTimeSent = null, string $newEmailAddressSent) {
	try {
		$this->setEmailId($newEmailId);
		$this->setEmailTimeSent($newEmailTimeSent);
		$this->setEmailAddressSent($newEmailAddressSent);
	} catch(\InvalidArgumentException $invalidArgument) {
		//rethrow the exception to the caller
		throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
	} catch(\RangeException $range) {
		//rethrow the exception to the caller
		throw(new \RangeException($range->getMessage(), 0, $range));
	} catch(\TypeError $typeError) {
		// rethrow the exception to caller
		throw(new \TypeError($typeError->getMessage(), 0, $typeError));
	} catch(\Exception $exception) {
		// rethrow the exception to the caller
		throw(new \Exception($exception->getMessage(), 0, $exception));
	}
}

/**
 * accessor method for email id
 *
 *
 * @return int|null value of email id
 */
	public function getEmailId() {
		return ($this->emailId);
	}

	/**
	 * mutator method for email id
	 *
	 * @param int|null value of email id
	 * @throws |RangeException if $newEmailId is not positive
	 * @throws |TypeError if $newEmailId is not an interger
	 */
	public function setEmailId( int $newEmailId = null) {
		// base case: if the email is is null, this is a new email without a mysql assigned (yet)
		if($newEmailId === null) {
			$this->emailId = null;
			return;
		}

		//verify the email id is positive
		if($newEmailId <= 0) {
			throw(new\ RangeException("id not positive"));
		}

		//convert and store the email id
		$this->emailId = $newEmailId;
	}

	/**
	 * accessor method for email time sent
	 *
	 * @return \DateTime value of email time sent
	 */
	public function getEmailTimeSent() {
		return ($this-> emailTimeSent);
	}

	/**
	 * mutator method for email time sent
	 *
	 * @param \DateTime|string|null $newEmailTimeSent email date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newEmailTimeSent is not a valid object or string
	 * @throws \RangeException if $newEmailTimeSent is a date that does not exist
	 */
	public function setEmailTimeSent($newEmailTimeSent = null) {
		// base case: if the date is null, use the current date and time
		if($newEmailTimeSent === null) {
			$this->emailTimeSent = new \DateTime();
			return;
		}
		//store the email created date
		try {
			$newEmailTimeSent = self::validateDateTime($newEmailTimeSent);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument-> getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range-> getMessage(), 0, $range));
		}
		$this->emailTimeSent = $newEmailTimeSent;
	}

/**
 * accessor for emailAddresSent
 *
 * @return string value of email address sent
 */
public function getEmailAddressSent() {
	return ($this->emailAddressSent);
}

/*
 * mutator method for Email Address Sent
 *
 * @param string $newEmailAddressSent new value of email address
 * @throws \InvalidArgumentException if $newEmailAddressSent is not a string or insecure
 * @throws \RangeException if $newEmailAddressSent is > 50 char
 * @throws \TypeError if $newEmailAddressSent is not a string
 */
public function setEmailAddressSent(string $newEmailAddressSent) {
	//verify the email address is secure
	$newEmailAddressSent = trim($newEmailAddressSent);
	$newEmailAddressSent = filter_var($newEmailAddressSent, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newEmailAddressSent) === true) {
		throw(new \RangeException("too many characters"));
	}
	//verify the post content will fit in the database
	if(strlen($newEmailAddressSent) > 50) {
		throw(new \RangeException("too many characters"));
	}
	//store the email address
	$this->emailAddressSent = $newEmailAddressSent;
}

/**
 * inserts emails into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not PDO connection object
 */
public function insert(\PDO $pdo) {
	//enforce the emailId is null (i.e., dont insert an email that already exists)
	if($this->emailId !== null) {
		throw(new \PDOException("This email already exists"));
	}

	//create query template
	$query = "INSERT INTO email(emailId, emailTimeSent, emailAddressSent) VALUES (:emailId, :emailTimeSent, :emailAddressSent)";
	$statement= $pdo->prepare($query);

	//bind the member variables to the place holders in the template
	$formattedDate = $this->emailTimeSent->format("Y-m-d H:i:s");
	$parameters = ["emailId"=> $this->emailId, "emailTimeSent"=> $formattedDate, "emailAddressSent"=> $this->emailAddressSent];
	$statement->execute($parameters);

	//update the null emailId with mysql just inserted
	$this->emailId = intval($pdo->LastInsertId());
}

}

