<?php
/**
 * Poll object
 * This is a simplified version of 
 *
 * @author Simon 'Sphere' Erkelens
 * @package Poll
 */
class Poll extends DataObject {
	
	private static $db = array(
		'Question' => 'Varchar(255)',
		'Multiple' => 'Boolean(false)',
		'Startdate' => 'Date',
		'Enddate' => 'Date',
	);
	
	private static $has_many = array(
		'Answers' => 'Answer',
	);
	
	private static $summary_fields = array(
		'Question',
		'Startdate',
		'Enddate',
	);
	
	private static $default_sort = "Enddate DESC";
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab(
			'Root.Main',
			array(
				$start = DateField::create('Startdate', 'Startdatum'),
				$end = DateField::create('Enddate', 'Einddatum')
			)
		);
		$start->setConfig('showcalendar', true);
		$end->setConfig('showcalendar', true);
		return $fields;
	}
	
	/**
	 * Check if already voted.
	 * If someone tries to sneak in another vote by deleting the cookie, set the Cookie again from Session.
	 * Ofcourse, this is not a failsafe method, but then again, it isn't meant to be.
	 * @return boolean
	 */
	public function isVoted() {
		$cookie = Cookie::get('filmpoll_' . $this->ID);
		$session = Session::get('filmpoll_' . $this->ID);
		if($cookie || $session) {
			Cookie::set('filmpoll_' . $this->ID, 1);
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Mark the the poll has been voted by the user, which determined by browser Cookie or Session
	 */
	function markAsVoted() {
		Cookie::set('filmpoll_' . $this->ID, 1);
		Session::set('filmpoll_' . $this->ID, 1);
	}

}