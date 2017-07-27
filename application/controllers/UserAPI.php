<?php
require APPPATH . './libraries/REST_Controller.php';

class UserAPI extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('GenerateToken');
    }

    public function index_get()
    {
        $key = $this->uri->segment(4);
        $table = $this->uri->segment(2);
        $id = $this->uri->segment(3);
        if ($id == '' || $key == '') {
            $data = $this->db->get($table)->result();
        } else {
            $this->db->where($key, $id);
            $data = $this->db->get($table)->result();
        }
        $this->response(array('status' => 'success', 'data' => $data), 200);
    }

    public function login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        $query = $this->db->where('email', $email)->where('kata_sandi', $password)->get('akun');
        if ($query->num_rows() > 0) {
            $token = $this->GenerateToken->getHash($email, $password);
            $data = array(
                'token' => $token
            );
            $query_update = $this->db->where('email', $email)->where('kata_sandi', $password)->update('akun', $data);
            if ($query_update) {
                $this->response(array('status' => 'success', 'token' => $token), 200);
            } else {
                $this->response(array('status' => 'fail'), 500);
            }
        } else {
            $this->response(array('status' => 'fail'), 500);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $job = $this->put('job');
        switch ($job) {
            case "angkat":
                $data = array(
                    'servo' => 'Angkat'
                );
                $stat = 1;
                break;
            case "jemur":
                $data = array(
                    'servo' => 'Angkat'
                );
                $stat = 0;
                break;
            case "On":
                $data = array(
                    'status' => 'On'
                );
                $stat = 1;
                break;
            default:
                $data = array(
                    'status' => 'Off'
                );
                $stat = 0;
                break;
        }
        $url = 'http://api.arkademy.com:3000/v0/arkana/device/IO/' . $id . '/gpio/control';
        $data_post = array(
            "control" => array(
                "13" => $stat
            )
        );
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_post);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer NDk0NjY4NzE2NC4zNzYwMjQ6'));
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            $this->response(array('status' => $info), 500);
        }
        curl_close($curl_response);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            $this->response(array('status' => 'fail'), 500);
        } else {
            $update = $this->db->where('device_id', $id)->update('device', $data);
            if ($update) {
                $this->response(array('status' => 'Success'), 200);
            } else {
                $this->response(array('status' => 'fail'), 502);
            }
        }
    }


    public function index_delete()
    {
        $id = $this->uri->segment(3);
        $table = $this->uri->segment(4);
        $key = $this->uri->segment(5);
        $this->db->where($key, $id);
        $delete = $this->db->delete($table);
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail'), 502);
        }
    }
}