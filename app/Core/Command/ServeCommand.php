<?php

namespace Almhdy\Simy\Core\Command;

class ServeCommand
{
  // ANSI color codes
  private $colors = [
    "reset" => "\033[0m",
    "red" => "\033[31m",
    "green" => "\033[32m",
    "yellow" => "\033[33m",
    "blue" => "\033[34m",
    "magenta" => "\033[35m",
    "cyan" => "\033[36m",
    "white" => "\033[37m",
  ];

  public function execute()
  {
    $host = "localhost";
    $port = 8000;
    $docroot = "public";

    // Show colorful and animated startup message
    $this->printAnimatedMessage(
      "Starting PHP Built-in Server at {$this->colors["green"]}http://{$host}:{$port}/{$this->colors["reset"]}\n"
    );

    // Start PHP built-in server
    $command = "php -S {$host}:{$port} -t {$docroot}";

    // Execute the command
    system($command);
  }

  private function printAnimatedMessage($message)
  {
    $animationChars = ["|", "/", "-", "\\"];
    for ($i = 0; $i < 1; $i++) {
      // Adjust the loop count for longer animations
      foreach ($animationChars as $char) {
        echo $this->colors["cyan"] .
          "\r" .
          $message .
          $char .
          $this->colors["reset"];

        // Sleep for a bit to create animation effect
        usleep(2000); // 20 milliseconds
      }
    }
    echo "\r" .
      $this->colors["green"] .
      "Server is running...\n" .
      $this->colors["reset"];
  }
}
