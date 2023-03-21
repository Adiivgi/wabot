
<?php
$page_access_token = 'EAAP2hAZBDX1QBADtQ4FeTQrBIIVzZBWv2wO6izov1uFcvEJnqJZBRY3hbZAqXEN0RI5bJuSEmnjUZCjWA5pdKCKXedB8OQjfjArslKTITvZCqVmZCZAcojihsnqGvJHlcpxt1IZCLUJdqK8YEKOZAAaURvTd3ZBpkAkE29D8edzbR3VSUdSI0y4NY8JEFD5KoZCu2ekDajTgoZAecWAZDZD';
file_put_contents('incoming.log', file_get_contents('php://input'));
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
$verify_token = "12345"; // Replace with your own verify token

if (isset($_GET['hub_challenge'])) {
file_put_contents('incoming.log', file_get_contents('php://input'));

    $challenge = $_GET['hub_challenge'];
    $token = $_GET['hub_verify_token'];
}
$token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : '';

if ($token === $verify_token) {
file_put_contents('incoming.log', file_get_contents('php://input'));

    header('HTTP/1.1 200 OK');
    echo $challenge;
    die();
}

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

if (isset($data['entry'][0]['messaging'][0]['message']['text'])) {
    // Handle incoming message here
    $message_text = $data['entry'][0]['messaging'][0]['message']['text'];
    $sender_id = $data['entry'][0]['messaging'][0]['sender']['id'];
	    sendMessage($sender_id);

    // Do something with the message and sender ID
}
function sendMessage($recipient_id) {
    $access_token = 'EAAP2hAZBDX1QBAPG1dzsj4eAGwsPycV1BIJp8x5T49sQZAZA745EJbxRQN7htZAEdZC33q2Q6HDPpqKdXfjaHbbsHnMca5E2FXRoiOF2OMsPgZAsFr5NQbxbVtVcq2PpbF8tJmLou0L32VhWaqJHbdK2yodXi8XXiTtRJBKPywTOB6xrycMHJ25uO3kYVY3CkrhQtdcYZBwswZDZD'; // Replace with your own access token
    $url = 'https://graph.facebook.com/v13.0/me/messages?access_token=' . $access_token;
    $message_data = [
        'recipient' => [
            'id' => $recipient_id
        ],
        'message' => [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'button',
                    'text' => 'Your message text here',
                    'buttons' => [
                        [
                            'type' => 'postback',
                            'title' => 'Button 1',
                            'payload' => 'BUTTON_1_PAYLOAD'
                        ],
                        [
                            'type' => 'postback',
                            'title' => 'Button 2',
                            'payload' => 'BUTTON_2_PAYLOAD'
                        ],
                        [
                            'type' => 'postback',
                            'title' => 'Button 3',
                            'payload' => 'BUTTON_3_PAYLOAD'
                        ]
                    ]
                ]
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
}


?>
