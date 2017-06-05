<?php
session_start();
require_once '../vendor/vladkens/VK/VK.php';
require_once '../vendor/vladkens/VK/VKException.php';

$vkApp = new VK\VK('123456', '123456Kzy5wZu123');

if (isset($_GET['code'])) {
    try {
        $accessToken = $vkApp->getAccessToken($_GET['code'], 'https://yourdomain.ru/vkgroupsbackup/app/auth.php');
        $_SESSION['access_token'] = $accessToken['access_token'];
        $_SESSION['user_id'] = $accessToken['user_id'];

        header('Location: https://yourdomain.ru/vkgroupsbackup/index.php');
        exit;
    } catch (\VK\VKException $e) {
        $e->getMessage();
    }

}
