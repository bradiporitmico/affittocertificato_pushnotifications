<?php
namespace AffittoCertificato;


class NotificationHandler {


	private $callables;
	private $post;
	private $response;

	const EVENT_SHARINGCURRICULUM = 'sharingCurriculum';

	public function __construct(){
		$this->post = file_get_contents('php://input');
		$this->callables = [];

		$this->response = new \stdClass();
		$this->response->error = false;
	}

	/**
	 * Set listner for "sharing curriculum"  event
	 *
	 * @param      callable  $callable  Any form of callable function / method
	 */
	public function onCurriculum ($callable){
		$this->on (self::EVENT_SHARINGCURRICULUM, $callable);
		return $this;
	}

	/**
	 * Set listner for a specified type of event. 
	 * The callable function may return a value (not mandatory and in any form you want [string, object, number, ...]) as further description for action results, if there's one it will be added as "payload" to json response and passed to AffittoCertificato caller.
	 * If callable wants to inform the caller that something has gone wrong it MUST throw an Exception with a descriptive note in it
	 *
	 * @param      string     $eventType  The name (as a string) of the event which you want to be registered for
	 * @param      callable    $callable   Any form of callable function / method
	 *
	 * @throws     Exception  Thrown if callable $parameter is not a callable method
	 */
	public function on ($eventType, $callable){
		if (!is_callable($callable))
			throw new \Exception("'\$callable' parameter must be a callable function or class method");
		$this->callables[$eventType] = $callable;
		return $this;
	}


	/**
	 * Execute the handler logic and produce a json answer as result.
	 * 
	 *
	 * @throws     Exception  (description)
	 */
	public function run(){
		try{

			// get datas from post
			$data = json_decode($this->post);

			// request validation
			if (!isset($data->event))
				throw new \Exception("Event type not defined", -1);

			// get the callable that handle $data->event
			if (!isset($this->callables[$data->event]))
				throw new \Exception("No handler has been defined for event '{$data->event}'", -2);
			$callable = $this->callables[$data->event];

			// check for payload from caller
			if (!isset ($data->payload))
				throw new \Exception("No payload from caller", -3);

			// get results from handler logic
			$this->response->payload = $callable($data->payload);
			$this->response->hasPayload = isset($this->response->payload);
				
			
		}catch(\Exception $e){
			$this->response->error = true;
			$this->response->errorMessage = $e->getMessage();
			$this->response->errorCode = $e->getCode();
		}finally{
			// return output to caller
			header ('Content-type: application/json');
			echo json_encode($this->response);
		}
	}
}






