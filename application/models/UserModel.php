<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function create_user($userdata)
    {
        $this->db->insert('user', $userdata);
        return $this->db->insert_id();
    }

    
}