<?php

namespace Almhdy\Simy\Models;

use Almhdy\Simy\Core\Model;

class User extends Model
{
  protected $table = "users";

  public function createUser(
    string $username,
    string $email,
    string $password
  ): array|bool {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    return $this->query->insert($this->table, [
      "username" => $username,
      "email" => $email,
      "password" => $hashedPassword,
    ]);
  }

  public function getUserByUsername(string $username): ?array
  {
    //  $result = $this->query->where($this->table, ["username" => $username]);

    // return $result ? $result[0] : null;
    return null;
  }
}
