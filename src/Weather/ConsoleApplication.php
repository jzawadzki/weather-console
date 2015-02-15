<?php

namespace Weather;


use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

class ConsoleApplication extends Application {
    public function __construct() {
        parent::__construct("Weather","1.0");
        $this->add(new \Weather\Command\WeatherShowCommand($this->getDefaultLocation()));
        $this->add(new \Weather\Command\WeatherDefaultSetCommand());
    }
    public function getDefaultLocation() {
        $finder = new Finder();
        $files = $finder->files()->in('.')->name('defaultlocation.tmp');
        foreach($files as $file) {
            return $file->getContents();
        }
        return false;
    }
} 