<?php
// This is global bootstrap for autoloading
if (getenv('APPLICATION_ENV') === 'testing') {
    $host = getenv('DB_HOST');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD') ?: '';
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_NAME');

    echo "recreating test database ..." . PHP_EOL;

    $databaseIntro = 'mysql -h' . $host . ' -u' . $user . ' -P' . $port;
    if (!empty($password)) {
        $databaseIntro .= ' -p' . $password;
    }

    $tablesToTruncate = ['oauth_access_tokens', 'oauth_refresh_tokens'];

    exec($databaseIntro . ' -e "SET FOREIGN_KEY_CHECKS=0"');
    foreach ($tablesToTruncate as $item) {
        $command = $databaseIntro . ' ' . $database . ' -e "TRUNCATE TABLE ' . $item . ';"';
        exec($command);
    }

    exec($databaseIntro . ' -e "SET FOREIGN_KEY_CHECKS=1"');
}

include_once dirname(__FILE__) . '/../public/index.php';
