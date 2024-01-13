<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pincode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
    }

    private function jsonResponse($status, $response, $result)
    {
        $data = [
            'status' => $status,
            'response' => $response,
            'result' => $result,
        ];
        echo json_encode($data);
    }

    private function loadDatabase()
    {
        $this->load->database();
    }

    public function searchbyPinCode()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pincode', 'Pin Code', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->jsonResponse(0, 'failed', 'Invalid Pin Code');
            return;
        }

        $pinCode = $this->input->post('pincode');
        $this->loadDatabase();

        $query = $this->db->get_where('pincode_details1', ['PinCode' => $pinCode])->result_array();

        if (!empty($query)) {
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(1, 'success', 'No Results Found for ' . $pinCode);
        }
    }

    public function getPostOffice()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->jsonResponse(0, 'failed', 'Enter all the fields');
            return;
        }

        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $this->loadDatabase();

        $query = $this->db->get_where('pincode_details1', ['State' => $state, 'District' => $city])->result_array();

        if (!empty($query)) {
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(1, 'success', 'No Results Found');
        }
    }

    public function searchbyPostOffice()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_office', 'Post Office', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->jsonResponse(0, 'failed', 'Enter Post Office');
            return;
        }

        $office = $this->input->post('post_office');
        $this->loadDatabase();

        $query = $this->db->like('PostOffice', $office)->get('pincode_details1')->result_array();

        if (!empty($query)) {
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(1, 'success', 'No Results Found for ' . $office);
        }
    }

    public function searchbyTaluk()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('taluk', 'Taluk', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->jsonResponse(0, 'failed', 'Enter Taluk');
            return;
        }

        $taluk = $this->input->post('taluk');
        $this->loadDatabase();

        $query = $this->db->like('Taluk', $taluk)->get('pincode_details1')->result_array();

        if (!empty($query)) {
            $this->jsonResponse(1, 'success', $query);
        } else {
            $this->jsonResponse(1, 'success', 'No Results Found for ' . $taluk);
        }
    }

    public function healthCheck()
    {
        $this->jsonResponse(1, 'success', 'Health check successful');
    }
}
