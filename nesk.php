<?php
require 'vendor/autoload.php'; // Load Composer's autoloader
use Nesk\Puphpeteer\Puppeteer;

function generateimg()
{
    $puppeteer = new Puppeteer();
    $browser = $puppeteer->launch();
    $page = $browser->newPage();
    $page->goto('ticket.php');

    $container = $page->querySelector('.ticket-wrapper');

    if ($container) {
        $container->screenshot(['path' => 'images/screenshot.png']);
    }
}
?>