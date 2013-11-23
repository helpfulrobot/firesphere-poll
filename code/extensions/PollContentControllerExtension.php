<?php
/**
 * Adds the poll to the ContentController to make it usable on the frontend.
 *
 * @author Simon 'Sphere' Erkelens
 */
class PollContentControllerExtension extends DataExtension {
	
	/**
	 * If there is a poll available within range, take the last one and return that poll.
	 * @return mixed:boolean|String False if none found. String of HTML if found.
	 */	
	public function PollForm() {
		$poll = Poll::get()->filter(array('Startdate:LessThan' => date('Y-m-d'), 'Enddate:GreaterThan' => date('Y-m-d')));
		if($poll->count()){
			return PollForm::create(Controller::curr(), 'PollForm', $poll->last());
		}
		return false;
	}
}