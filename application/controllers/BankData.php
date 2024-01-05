<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BankData extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');

    }

	public function getBanks(){
		$query = $this->db->query('SELECT DISTINCT bank FROM banks')->result_array();
		echo json_encode($query);
	}

	public function getStates(){
		$query = $this->db->query('SELECT DISTINCT state FROM banks')->result_array();
		echo json_encode($query);
	}

	public function getCity(){
		$state = $this->input->post('state');
		$query = $this->db->query("SELECT DISTINCT city1 As city FROM banks WHERE state = '{$state}'")->result_array();
		echo json_encode($query);
	}

	public function getIfsc(){
		$bank = $this->input->post('bank');
		$query = $this->db->query("SELECT DISTINCT ifsc FROM banks WHERE bank = '{$bank}'")->result_array();
		echo json_encode($query);
	}

	public function getBankfromIfsc(){
		$ifsc = $this->input->post('ifsc');
		$query = $this->db->query("SELECT * FROM banks WHERE ifsc = '{$ifsc}'")->result_array();
		echo json_encode($query);
	}

	public function getBankfromCity(){
		$city = $this->input->post('city');
		$query = $this->db->query("SELECT * FROM banks WHERE city1 = '{$city}'")->result_array();
		echo json_encode($query);
	}

	public function getBankfromState(){
		$state = $this->input->post('state');
		$query = $this->db->query("SELECT * FROM banks WHERE state = '{$state}'")->result_array();
		echo json_encode($query);
	}

	public function search() {
		$state = $this->input->post('state');
		$city = $this->input->post('city');
		$bankName = $this->input->post('bank');
	
		// Build the SQL query based on the provided parameters
		$sql = "SELECT * FROM banks WHERE 1";

		if (!empty($state)) {
			$sql .= " AND state LIKE '%{$state}%'";
		}

		if (!empty($city)) {
			$sql .= " AND city1 LIKE '%{$city}%'";
		}

		if (!empty($bankName)) {
			$sql .= " AND bank LIKE '%{$bankName}%'";
		}
		// Execute the query and fetch results
		$query = $this->db->query($sql)->result_array();
		echo json_encode($query);
	}
	

}
