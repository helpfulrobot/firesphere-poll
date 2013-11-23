<?php
/**
 * Create the Form itself.
 *
 * @author Simon 'Sphere' Erkelens
 */
class PollForm extends Form {
	
	protected $poll;
	
	public function __construct($controller, $name, $poll) {
                if(!$poll) {
                        user_error("The poll doesn't exist.", E_USER_ERROR);
                }

                $this->poll = $poll;
                
                $data = $poll->Answers()->map('ID', 'Title');
                
                if($poll->Multiple) {
                        $choiceField = CheckboxSetField::create('PollChoices', $poll->Question, $data);
                }
                else {
                        $choiceField = OptionsetField::create('PollChoices', '', $data);
                }
                
                $fields = FieldList::create(
                        $choiceField
                );
                
                $actions = FieldList::create(
                        FormAction::create('submitPoll', 'Verstuur')
                );

		$validator = RequiredFields::create(array('PollChoices'));
		
                parent::__construct($controller, $name, $fields, $actions, $validator);
        }
        
        public function submitPoll($data, $form) {
                $choices = Answer::get()->filter(array('ID' => $data['PollChoices']));

                if($choices) {
                        foreach($choices as $choice) {
                                $choice->Votecount = $choice->Votecount + 1;
				$choice->write();
				$choice->Poll()->markAsVoted();
                        }
                }
		$this->controller->redirectBack();
        }
	
	/**
         * Renders the poll using the PollForm.ss
         */
        public function forTemplate() {
                if (!$this->poll || !$this->poll->Answers()->count()) {
			return null;
		}
		/** DefaultForm holds the actual voting-form */
		$this->DefaultForm = $this->renderWith('Form');
                return $this->customise($this)->renderWith(
			array(
                                'PollForm',
                                'Form'
                        )
		);
        }
	
	/**
         * Collate the information from PollForm and Poll to figure out if the results should be shown.
         */
        public function getShouldShowResults() {
                return $this->poll->isVoted();
        }
}