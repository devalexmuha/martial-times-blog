<?php

namespace App\Support;

class Container{

  private array $recipes = [];
  private array $instances = [];

  public function bind(string $name, \Closure $recipe): void {
    $this->recipes[$name] = $recipe;
  }

  public function get(string $name): object {
    if (empty($this->instances[$name])) {
      if (empty($this->recipes[$name])) {
        echo 'There is no recipe for object with name: ' . $name;
        die();
      }
      $this->instances[$name] = $this->recipes[$name]($this);
    }
    return $this->instances[$name];
  }

}