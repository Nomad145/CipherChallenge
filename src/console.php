<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$console = new Application('Crypto Challenge', 'n/a');
$console->setDispatcher($app['dispatcher']);
$console
    ->register('decipher')
    ->setDefinition(array(
        new InputArgument('file-path', null, InputArgument::REQUIRED, 'The file path to the cipher text.'),
    ))
    ->setDescription('Attempts to decipher text from a file.')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $file = $input->getArgument('file-path');

        if (!file_exists($file)) {
            throw new \InvalidArgumentException('Invalid path the the cipher text.');
        }

        $text = file_get_contents($file);
        $cipher = $app['crypto.cipher_cracker']->crack(file_get_contents($file));

        $output->write($cipher->decipher($text));
    })
;

return $console;
