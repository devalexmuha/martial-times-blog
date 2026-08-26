<?php

namespace App\Model;

class UserModel{
  public function __construct(
    public int $id,
    public string $email,
    public string $hash,
    public string $userType,
  ){}
}