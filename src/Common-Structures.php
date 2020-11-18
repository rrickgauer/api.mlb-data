<?php


class Filter {
  private $column;
  private $conditional;
  private $qualifier;

  public function __construct($column, $conditional, $qualifier) {
    $this->column = $column;
    $this->conditional = $conditional;
    $this->qualifier = $qualifier;
  }

  public function getColumn() {
    return $this->column;
  }

  public function getConditional() {
    return $this->conditional;
  }

  public function getQualifier() {
    return $this->qualifier;
  }
}


class Sort {
  private $column;
  private $type;

  public function __construct($column, $type) {
    $this->column = $column;
    $this->type = $type;
  }

  public function getColumn() {
    return $this->column;
  }

  public function getType() {
    return $this->type;
  }
}








?>