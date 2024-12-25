<?php

namespace Almhdy\Simy\Core;

class CommandHandler
{
  protected array $commands = [];

  public function registerCommand(string $name, callable $handler): void
  {
    $this->commands[$name] = $handler;
  }

  public function run(array $argv): void
  {
    $commandName = $argv[1] ?? null;

    if ($commandName && isset($this->commands[$commandName])) {
      call_user_func($this->commands[$commandName], array_slice($argv, 2));
    } else {
      $this->displayHelp();
    }
  }

  protected function displayHelp(): void
  {
    echo "Available commands:\n";
    foreach (array_keys($this->commands) as $command) {
      echo "  - $command\n";
    }
  }
}
