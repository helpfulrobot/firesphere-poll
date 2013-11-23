<?php
/**
 * Description of Answer
 *
 * @author Simon 'Sphere' Erkelens
 */
class Answer extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Votecount' => 'Int',
	);
	
	private static $has_one = array(
		'Poll' => 'Poll',
	);
	
	private static $summary_fields = array(
		'Title',
		'Votecount',
	);
	
	/**
	 * Calculate the current standing of the options
	 * @param Integer $min Optionally calculate a +1/-1 to the result. Useful for using a nice gradient at the end of the bar.
	 * Options:	0 => Remove a value of 1 from the result.
	 *		1 => Add 1 to result.
	 *		Any other => Just return the result.
	 * @return Integer $return current value of the current calculated answer.
	 */
	public function Percentage($min = 0) {
		$answers = $this->Poll()->Answers();
		$sum = 0;
		foreach($answers as $id => $answer) {
			$sum = $sum + $answer->Votecount;
		}
		if($sum == 0) $sum = $this->Votecount;
		$return = (int)(($this->Votecount / $sum) * 100);
		if($min == 1 && $return < 100) {
			$return = $return + 1;
		}
		if($min == 0 && $return > 0) {
			$return = $return - 1;
		}
		return $return;
		
	}

}