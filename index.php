<?php
session_start();
require_once 'vendor/vladkens/VK/VK.php';
require_once 'vendor/vladkens/VK/VKException.php';

if (!isset($_SESSION['access_token'])) {
    $vkApp = new VK\VK('123456', '123456Kzy5wZu123');
    $authorizeURL = $vkApp->getAuthorizeURL('groups', 'https://fastcast.ru/vkgroupsbackup/app/auth.php');
    $authorizeURL = urldecode($authorizeURL);
}

if (isset($_SESSION['access_token'])) {
    $vkApp = new VK\VK('123456', '123456Kzy5wZu123', $_SESSION['access_token']);

    $requestParams = array(
        'user_id' => $_SESSION['user_id'],
        'extended' => 1,
        'fields' => 'photo_100',
        'offset' => 0,
        'count' => 1000
    );

    $groupsList = $vkApp->api('groups.get', $requestParams);
    $groupsList = $groupsList['response'];
    array_shift($groupsList);
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Бэкап групп и пабликов ВКонтакте</title>
    <style>
        td {
            border: 1px solid black; /* Граница вокруг ячеек */
        }
    </style>
</head>
<body>
    <?php if (!isset($_SESSION['access_token'])) : ?>
        <a href="<?= $authorizeURL ?>">Авторизация</a>
    <?php endif; ?>

    <table>
        <tr>
            <td>Изображение</td>
            <td>Название</td>
            <td>Закрыта?</td>
            <td>Ссылка</td>
        </tr>
    <?php foreach ($groupsList as $group) : ?>
        <tr>
            <td><img src="<?= $group['photo_100'] ?>" alt=""></td>
            <td><p><?= $group['name'] ?></p></td>
            <td><p><?= $group['is_closed'] ?></p></td>
            <td><a href="https://vk.com/club<?= $group['gid'] ?>">Ссылочка</a></td>
        </tr>
    <?php endforeach; ?>
    </table>
</body>
</html>
