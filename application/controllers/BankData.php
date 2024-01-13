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

    private function jsonResponse($status, $response, $result = [])
    {
        $data = [
            'status' => $status,
            'response' => $response,
            'result' => $result,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    private function loadDatabase()
    {
        $this->load->database();
    }

    public function getBanks()
    {
        $this->loadDatabase();
        $query = $this->db->distinct()->select('bank')->get('banks')->result_array();
        $this->jsonResponse(1, 'success', $query);
    }

    public function getStates()
    {
        $this->loadDatabase();
        $query = $this->db->distinct()->select('state')->get('banks')->result_array();
        $this->jsonResponse(1, 'success', $query);
    }

    public function getCity()
    {
        $state = $this->input->post('state');
        if (!empty($state)) {
            $this->loadDatabase();
            $query = $this->db->distinct()->select('city1 as city')->get_where('banks', ['state' => $state])->result_array();
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(0, 'failed', 'State is Empty');
        }
    }

    public function getIfsc()
    {
        $bank = $this->input->post('bank');
        if (!empty($bank)) {
            $this->loadDatabase();
            $query = $this->db->distinct()->select('ifsc')->like('bank', $bank)->get('banks')->result_array();
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(0, 'failed', 'Bank is Empty');
        }
    }

    public function getBankfromIfsc()
    {
        $ifsc = $this->input->post('ifsc');

        if (!empty($ifsc)) {
            $this->loadDatabase();
            $query = $this->db->get_where('banks', ['ifsc' => $ifsc])->result_array();
            $this->jsonResponse(1, 'success', $query ? $query[0] : []);
        } else {
            $this->jsonResponse(0, 'failed', 'IFSC code is Empty');
        }
    }

    public function getBankfromCity()
    {
        $city = $this->input->post('city');

        if (!empty($city)) {
            $this->loadDatabase();
            $query = $this->db->get_where('banks', ['city1' => $city])->result_array();
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(0, 'failed', 'City is Empty');
        }
    }

    public function getBankfromState()
    {
        $state = $this->input->post('state');

        if (!empty($state)) {
            $this->loadDatabase();
            $query = $this->db->get_where('banks', ['state' => $state])->result_array();
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(0, 'failed', 'State is Empty');
        }
    }

    public function search()
    {
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $bankName = $this->input->post('bank');

        if (empty($state) && empty($city) && empty($bankName)) {
            $this->jsonResponse(0, 'failed', 'All parameters are Empty');
            return;
        }

        $this->loadDatabase();
        $this->db->select('*')->from('banks');

        if (!empty($state)) {
            $this->db->like('state', $state);
        }
        if (!empty($city)) {
            $this->db->like('city1', $city);
        }
        if (!empty($bankName)) {
            $this->db->like('bank', $bankName);
        }

        $query = $this->db->get()->result_array();

        $this->jsonResponse(1, 'success', $query);
    }

    public function healthCheck()
    {
        $this->jsonResponse(1, 'success', ['status' => 'healthy']);
    }
}
