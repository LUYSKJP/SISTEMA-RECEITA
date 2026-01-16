<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->db->get_where('users', ['username' => $username])->row_array();
        if (!$user) {
            return null;
        }
        if (!password_verify($password, $user['password_hash'])) {
            return null;
        }
        return $user;
    }
}
