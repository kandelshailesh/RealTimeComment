<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connections sfgfgfgfg! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $data) {

        $from_id = $from->resourceId;
        $data1 = json_decode($data);
        $type = $data1->type;
        echo $type;
        switch ($type) {
            case 'comment':
            $userid=$data1->userid;
            $message=$data1->commentmsg;
            $imageid=$data1->postid;
            $conns = mysqli_connect("localhost:3308", "root", "", "Comment");
            $userquery=mysqli_query($conns,"INSERT INTO `commentrecord` (`Comment`,`CommenterID`,`ImageID`) values ('$message',$userid,$imageid)");
            $imagequery=mysqli_query($conns,"UPDATE `Image` set `count`=`count`+1 where `ImageID`=$imageid ");
            mysqli_close($conns);
                foreach ($this->clients as $client) {
                 {
                    echo "comment";
                    $client->send($data);
                 }
                 }
                break;
            
            case 'typing':
                foreach ($this->clients as $client) {
                 
                    if($from!=$client)
                    {
                    $client->send($data);
                }
                 }
                break;

            case 'photo':
                foreach($this->clients as $client){
                    $client->send($data);
                }
                break;

                 }
}

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
?>