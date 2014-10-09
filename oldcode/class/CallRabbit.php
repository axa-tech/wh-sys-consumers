<?php
 require_once '/home/thomas/vendor/autoload.php';
                use PhpAmqpLib\Connection\AMQPConnection;
                use PhpAmqpLib\Message\AMQPMessage;

class CallRabbit{
	

	public function send($message,$queue){
		$exchangeName = $queue;
$queueName = $queue;
$connection = new AMQPConnection('localhost', 5672, 'axa', 'password','/axa');
$channel = $connection->channel();
$channel->queue_declare($queueName,false, true, false, false);
$channel->exchange_declare($exchangeName, 'direct', false, false, false);
$channel->queue_bind($exchangeName,$queueName);

/*		$connection = new AMQPConnection('localhost', 5672, 'axa', 'password',"/axa");
		$channel = $connection->channel();


		$channel->queue_declare('hello', false, false, false, false);
*/
		$msg = new AMQPMessage($message);
		$channel->basic_publish($msg, '', $queue);

		echo " [x] Sent 'Hello World!'\n";

		$channel->close();
		$connection->close();

	}
	function __construct(){
		require_once '/home/thomas/vendor/autoload.php';	
		//use PhpAmqpLib\Connection\AMQPConnection;
                //use PhpAmqpLib\Message\AMQPMessage;

	}
	public function sendtest(){
		$queue="update-plateform";
$message="{blabla}";
/* require_once '/home/thomas/vendor/autoload.php';
                use PhpAmqpLib\Connection\AMQPConnection;
                use PhpAmqpLib\Message\AMQPMessage;
*/

$exchangeName = $queue;
$queueName = $queue;
$connection = new AMQPConnection('localhost', 5672, 'axa', 'password','/axa');
$channel = $connection->channel();
$channel->queue_declare($queueName,false, true, false, false);
$channel->exchange_declare($exchangeName, 'direct', false, false, false);
$channel->queue_bind($exchangeName,$queueName);

/*              $connection = new AMQPConnection('localhost', 5672, 'axa', 'password',"/axa");
                $channel = $connection->channel();


                $channel->queue_declare('hello', false, false, false, false);
*/
                $msg = new AMQPMessage($message);
                $channel->basic_publish($msg, '', $queue);

                echo " [x] Sent 'Hello World!'\n";

                $channel->close();
                $connection->close();

	}

}

?>




