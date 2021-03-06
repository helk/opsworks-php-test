<?php

    require_once dirname(__FILE__) . "/../vendor/autoload.php";

    require_once dirname(__FILE__) . "/../../db.php";

    define("SQS_REGION", getenv("SQS_REGION"));
    define("SQS_JOBS_URL", getenv("SQS_JOBS_URL"));

    if(isset($_SERVER['REQUEST_METHOD'])){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//Parse incoming SQS message
			$message_id = $_SERVER['HTTP_X_AWS_SQSD_MSGID'];
            $message_body = file_get_contents('php://input');
            print_r(array($message_id, $message_body));
            addUser("$message_id@test.com");
            die();
		}
	}

    $aws = Aws\Common\Aws::factory(array(
        "region" => SQS_REGION,
        "signature" => "v4"
    ));

    $client = $aws->get('Sqs');
    $result = $client->receiveMessage(array(
        'QueueUrl'	=> SQS_JOBS_URL,
        'MaxNumberOfMessages' => 1
    ));
    if ( $result->get('Messages') ){
        foreach ($result->get('Messages') as $message) {
            print_r($message);
            $message_id = $message['MessageId'];
            addUser("$message_id@test.com");
        }
    }
    echo "Queue processed OK \n";
        
?>