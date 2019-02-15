<?php

namespace Wakup;

use SebastianBergmann\Timer\Timer;

class Greetings {
    public static function sayHelloWorld() {
        Timer::start();
        $time = Timer::stop();
        var_dump(new PaginatedResults());
        return "Hello World\n" . Timer::secondsToTimeString($time) . "\n";
    }
}