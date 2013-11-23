<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of PollAdmin
 *
 * @author Simon 'Sphere' Erkelens
 */
class PollAdmin extends ModelAdmin {
	
	private static $managed_models = array(
		'Poll',
	);
	
	private static $menu_title = 'Polls';
	
	private static $url_segment = 'poll';

}