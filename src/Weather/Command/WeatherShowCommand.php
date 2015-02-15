<?php

namespace Weather\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Weather\Api\OpenWeatherMapApi;

class WeatherShowCommand extends Command
{

    private $defaultLocation;

    public function __construct($defaultLocation)
    {
        $this->defaultLocation = $defaultLocation;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('show')
            ->setDescription('Show weather for location');
        if ($this->defaultLocation)
            $this->addArgument('location', InputArgument::OPTIONAL, "Location to show weather for", $this->defaultLocation);
        else
            $this->addArgument('location', InputArgument::REQUIRED, "Location to show weather for");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $location = $input->getArgument('location');

        $api = new OpenWeatherMapApi(new Client());
        $info = $api->get($location);
        if (!$info) {
            $output->writeln("No results found");
            return 1;
        }
        $output->writeln(sprintf("Location: <comment>%s,%s</comment>", $info['name'], $info['sys']['country']));
        $output->writeln("");
        $output->writeln(sprintf("Temperature: <comment>%dC</comment> (min <comment>%dC</comment>)", round($info['main']['temp'] - 273.15), round($info['main']['temp_min'] - 273.15)));
        $output->writeln(sprintf("Pressure: <comment>%s</comment> hPa", $info['main']['pressure']));
        $output->writeln(sprintf("Humidity: <comment>%s</comment> %%", $info['main']['humidity']));
        $output->writeln("");
        $output->writeln(sprintf("Wind: <comment>%d</comment>kt <comment>%d</comment>deg", $info['wind']['speed'], $info['wind']['deg']));
        return 0;
    }

} 