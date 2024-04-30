<?php
include 'nobox.php';


header("Content-Type:application/json");
$conn = mysqli_connect('localhost', 'root', '', 'botpress-nobox-pelanggaran-siswa');
mysqli_set_charset($conn, 'utf8');
$method = $_SERVER['REQUEST_METHOD'];
$results = array();


$query = mysqli_query($conn, 'SELECT * FROM token');
$firstRow = mysqli_fetch_assoc($query);
$token = $firstRow['token'];

// echo $token

// $channelId = null;
// $nobox = new Nobox($token);
// $channelListResponse = $nobox->getChannelList();
// if ($channelListResponse->IsError) {
//     echo "Login first to get channel";
// } else {
//     $data = $channelListResponse->Data;
//     foreach ($data as $item) {
//         // echo "<option value=\"$item->Id\">$item->Nm</option>";
//         $channelId = $item->Id;
//     }
// }


// if ($method == 'POST') {
//     $linkId = null;
//     $channelId = 1;
//     $accountIds = $_POST['noOrtu']; //
//     $bodyType = 1; //
//     $body = $_POST['pelanggaran']; //
//     $attachment = []; //
//     $nobox = new Nobox($token);
//     $tokenResponse = $nobox->sendInboxMessage($linkId, $channelId, $accountIds, $bodyType, $body, $attachment);
//     echo json_encode($tokenResponse);

// echo $linkId;
// echo "===";
// echo $channelId;
// echo "===";
// echo $accountIds;
// echo "===";
// echo $bodyType;
// echo "===";
// echo $body;
// echo $attachment;
// }
// <?php
include 'nobox.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your PHP function code here
    $data = json_decode(file_get_contents("php://input"), true);

    $token = $_COOKIE['token'];
    $extId = $data['ExtId'];
    $channelId = $data['ChannelId'];
    $accountIds = $data['AccountIds'];
    $bodyType = $data['BodyType'];
    $body = $data['Body'];
    $attachment = $data['Attachment'];
    $nobox = new Nobox($token);
    $tokenResponse = $nobox->sendInboxMessageExt($extId, $channelId, $accountIds, $bodyType, $body, $attachment);
    echo json_encode($tokenResponse);
}
