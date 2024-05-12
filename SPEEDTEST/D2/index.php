<?php 

//Top 5 word, total message send, total message accept, average characteer send, average character accept

$file = file_get_contents('./result.json');
$data = json_decode($file, true);

$chats = $data['chats'];

// var_dump($chats);

$total_message_send = 0;
$total_message_accept = 0;

$average_character_send = [];
$average_character_accept = [];

$words = [];

foreach($chats as $key => $chat){
    // get top 5
    $pisah_kata = explode(' ', $chat['content']);
    foreach($pisah_kata as $kata){
        $words[$kata] = 0;
    }
}

foreach($chats as $key => $chat){
   

    if($chat['Sender'] == 'Dian'){
        $total_message_send++;
        $average_character_send[] = strlen($chat['content']);
    }
    if($chat['Sender'] == 'OpenAi.com'){
        $total_message_accept++;
        $average_character_accept[] = strlen($chat['content']);
    }

    $pisah_kata = explode(' ', $chat['content']);
    foreach($pisah_kata as $kata){
        $words[$kata]++;
    }
}

arsort($words);
$top5words =  array_slice(array_keys($words), 0, 5);
// var_dump($top5words, $words);

$count_average_character_accept = 0;
$count_average_character_send = 0;

foreach($average_character_accept as $number){
    $count_average_character_accept += $number;
}

foreach($average_character_send as $number){
    $count_average_character_send += $number;
}

$count_average_character_accept = $count_average_character_accept / count($average_character_accept);
$count_average_character_send = $count_average_character_send / count($average_character_send);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <p>Top 5 word</p>
        <?php foreach($top5words as $word){
            ?>
                <li><?= $word ?> || total words (<?= $words[$word] ?>)</li>
            <?php
        }
        ?>
        <br>
        <li>Total message send : <?= $total_message_send ?> </li>
        <li>Total 
            message receive : <?= $total_message_accept ?></li>
        <li>Total message average send : <?= round($count_average_character_accept) ?></li>
        <li>Total message average accept : <?= round($count_average_character_send) ?></li>
    </ul>
</body>
</html>