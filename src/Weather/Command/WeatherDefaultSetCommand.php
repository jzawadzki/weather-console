<?php

namespace Weather\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Weather\Api\OpenWeatherMapApi;

class WeatherDefaultSetCommand extends Command{
    protected function configure()
    {
     $this->setName('default:set')
         ->setDescription('Set default location')
         ->addArgument('location',InputArgument::REQUIRED,"Location to show weather for");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $location = $input->getArgument('location');

        file_put_contents("defaultlocation.tmp",$location);
        $output->writeln(sprintf("Default location set to <info>%s</info>",$location));
        return 0;
    }

} 