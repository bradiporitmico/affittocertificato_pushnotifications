<?php
	

require_once __DIR__.'/../src/NotificationHandler.php';

$handler = new AffittoCertificato\NotificationHandler();

// this register to a basic event named 'sharingCurriculum'. 
// In other words the method ->onCurriculm is an alias to ->on ('sharingCurriculum')
$handler->onCurriculum(function($data){
	

	// do your logic
	// code ...
	// code ...
	// code ...
	// code ...
});


// this register to a event named 'future_eventname_not_yet_implemented'
$handler->on('future_eventname_not_yet_implemented',function($data){
	return "You should implement this awesome event... really";
});

// run the push notification handler logic and return results to the AffittoCertificato caller
$handler->run();

// that's it!

