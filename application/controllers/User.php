<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('UserModel');
        // $this->load->model('CountModel');
        // $this->load->helper('form');
        // $this->load->library('session'); // Load the session library
        // $this->load->library('form_validation'); // Set rules for each field
        // $this->load->library("pagination");

    }

	public function signUp()
	{
		$userdata = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'password' => $this->input->post('password')
		);

		$user_id = $this->UserModel->create_user($userdata);

        if ($user_id) {
            echo json_encode(array('user_id' => $user_id, 'message' => 'User created successfully'));
        } else {
            echo json_encode(array('error' => 'User creation failed'));
        }
		// // echo "<pre>";
		// print_r($userdata);
	}

}
