<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BankData extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');

    }

    public function getBanks()
    {
        $query = $this->db->query('SELECT DISTINCT bank FROM banks')->result_array();
        $data['status'] = "1";
        $data['response'] = "success";
        $data['result'] = $query;
        echo json_encode($data);
    }

    public function getStates()
    {
        $query = $this->db->query('SELECT DISTINCT state FROM banks')->result_array();
        $data['status'] = "1";
        $data['response'] = "success";
        $data['result'] = $query;
        echo json_encode($data);
    }

    public function getCity()
    {
        $state = $this->input->post('state');
        if (!empty($state)) {
            $query = $this->db->query("SELECT DISTINCT city1 As city FROM banks WHERE state = '{$state}'")->result_array();
            $data['status'] = "1";
            $data['response'] = "success";
            $data['result'] = $query;
        } else {
            $data['status'] = "0";
            $data['response'] = "State is Empty";
        }
        echo json_encode($data);
    }

    public function getIfsc()
    {
        $bank = $this->input->post('bank');
        if (!empty($bank)) {
			$query = $this->db->query("SELECT DISTINCT ifsc FROM banks WHERE bank LIKE '%{$bank}%'")->result_array();
            $data['status'] = "1";
            $data['response'] = "success";
            $data['result'] = $query;
        } else {
            $data['status'] = "0";
            $data['response'] = "bank is Empty";
        }

        echo json_encode($data);
    }

    public function getBankfromIfsc()
    {
        $ifsc = $this->input->post('ifsc');

        if (!empty($ifsc)) {
            $query = $this->db->query("SELECT * FROM banks WHERE ifsc = '{$ifsc}'")->result_array();
            $data['status'] = "1";
            $data['response'] = "success";
            $data['result'] = $query;
        } else {
            $data['status'] = "0";
            $data['response'] = "ifsc code is Empty";
        }

        echo json_encode($data);
    }

    public function getBankfromCity()
    {
        $city = $this->input->post('city');

        if (!empty($city)) {
            $query = $this->db->query("SELECT * FROM banks WHERE city1 = '{$city}'")->result_array();
            $data['status'] = "1";
            $data['response'] = "success";
            $data['result'] = $query;
        } else {
            $data['status'] = "0";
            $data['response'] = "city is Empty";
        }

        echo json_encode($data);
    }

    public function getBankfromState()
    {
        $state = $this->input->post('state');

        if (!empty($state)) {
            $query = $this->db->query("SELECT * FROM banks WHERE state = '{$state}'")->result_array();
            $data['status'] = "1";
            $data['response'] = "success";
            $data['result'] = $query;
        } else {
            $data['status'] = "0";
            $data['response'] = "city is Empty";
        }

        echo json_encode($data);
    }

    public function search()
    {
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $bankName = $this->input->post('bank');

        if (empty($state) && empty($city) && empty($bankName)) {
            $data['status'] = "0";
            $data['response'] = "city is Empty";
        } else {
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
            $query = $this->db->query($sql)->result_array();
			$data['status'] = "1";
            $data['response'] = "success";
            $data['result'] = $query;
        }

        // Build the SQL query based on the provided parameters

        echo json_encode($data);
    }

}
