<?php

// define('DB_HOST', 'joaolagoas.com.br');
// define('DB_NAME', 'joaola59_igorgustmat');
// define('DB_USER', 'joaola59_igorgustmat_usu');
// define('DB_PASS', 'S[XQy23c)L8B');
// define('DB_CHARSET', 'utf8mb4');

define('DB_HOST', 'localhost');
define('DB_NAME', 'banco');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

function getConexao(): PDO {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $opcoes = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    return new PDO($dsn, DB_USER, DB_PASS, $opcoes);
}
