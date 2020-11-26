<?php

require("HTMLEndpoint.php");

class HomeEndpoint extends HTMLEndpoint
{
    public function render() {
        // For testing purposes
        echo "Hello World!";
    }
}