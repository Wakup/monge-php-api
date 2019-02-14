<?php

namespace HelloWorld;

use SebastianBergmann\Timer\Timer;

class Greetings {
    public static function sayHelloWorld() {
        Timer::start();
        $time = Timer::stop();
        return "Hello World\n" . Timer::secondsToTimeString($time) . "\n";
    }
}