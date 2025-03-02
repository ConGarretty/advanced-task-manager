<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__)."/vendor/autoload.php";

if (method_exists(Dotenv::class, "bootEnv")) {
    (new Dotenv())->bootEnv(dirname(__DIR__)."/.env");
}

$_SERVER["KERNEL_CLASS"] = "App\Kernel";
$_SERVER["DATABASE_URL"] = "mysql://root:root@database:3306/app_test?serverVersion=8.0";

if ($_SERVER["APP_DEBUG"]) {
    umask(0000);
}
