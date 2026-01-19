<?php

define('ENVIRONMENT', 'development');

$system_path = 'system';
$application_folder = 'application';
$view_folder = '';

if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== false) {
    $system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
    $system_path = strtr(
        rtrim($system_path, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
    ) . DIRECTORY_SEPARATOR;
}

if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Sistema do CodeIgniter não encontrado. ' .
        'Baixe o CodeIgniter 3 e copie a pasta "system" para a raiz do projeto ' .
        '(ex.: C:\\xampp\\htdocs\\SISTEMA-RECEITA\\system). ' .
        'Você também pode executar o script scripts\\install-codeigniter.ps1.';
    exit(3);
}

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_path);
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('SYSDIR', basename(BASEPATH));

define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);
define('VIEWPATH', FCPATH . $application_folder . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

require_once BASEPATH . 'core/CodeIgniter.php';
