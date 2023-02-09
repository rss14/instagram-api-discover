<?php 

require 'vendor/autoload.php';
require 'InstagramService.php';
//header("Content-Type: application/json");

$instagramService = new InstagramService;

$locationId = $_GET['location_id'] ?? '1027564636';

$response = $instagramService->getLocationData($locationId)['native_location_data'];

$data = [
    'location' => [],
    'ranked' => [],
    'recent' => [],
];

if (isset($response['location_info'])) {

    $data = [
        'location' => $response['location_info'],
        'ranked' => [],
        'recent' => [],
    ];

    foreach ($response['ranked']['sections'] as $section) {

        foreach($section['layout_content']['medias'] as $media) {
            $data['ranked'][] = [
                'user' => $media['media']['user'],
                'media' => $media['media']['image_versions2']['candidates'][0] ?? []
            ];
        }        
    }

    foreach ($response['recent']['sections'] as $section) {

        foreach($section['layout_content']['medias'] as $media) {
            $data['recent'][] = [
                'user' => $media['media']['user'],
                'media' => $media['media']['image_versions2']['candidates'][0] ?? []
            ];
        }        
    }

    // echo json_encode($data);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InstagramService</title>
</head>
<body>
    <?php foreach($data['ranked'] as $ranked):?>
        <?php if (isset($ranked['media']['url'])):?>
            <img width="300" src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($ranked['media']['url']));?>">
            <h1>Nome: <?php echo $ranked['user']['full_name'];?>, <a target="_blank" href="https://instagram.com/<?php echo $ranked['user']['username'];?>"><?php echo $ranked['user']['username'];?></a></h1>
            <hr>
        <?php endif;?>
    <?php endforeach;?>

    <?php foreach($data['recent'] as $recent):?>
        <?php if (isset($recent['media']['url'])):?>
            <img width="300" src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($recent['media']['url']));?>">
            <h1>Nome: <?php echo $recent['user']['full_name'];?>, <a target="_blank" href="https://instagram.com/<?php echo $recent['user']['username'];?>"><?php echo $recent['user']['username'];?></a></h1>
            <hr>
        <?php endif;?>
    <?php endforeach;?>
</body>
</html>
