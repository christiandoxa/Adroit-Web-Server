<?php
require APPPATH . './libraries/REST_Controller.php';

class UserAPI extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('GenerateToken');
    }

    const SUCCESS = 'success';
    const FAIL = 'fail';

    public function index_get()
    {
        $key = 'device_id';
        $table = 'device';
        $id = $this->uri->segment(2, 0);
        if ($id == '0') {
            $this->response(array('status' => self::FAIL), 400);
        } else {
            $data = $this->db->where($key, $id)->get($table);
            if ($data->num_rows() > 0) {
                $this->response(array('status' => self::SUCCESS, 'data' => $data->row()), 200);
            } else {
                $this->response(array('status' => 'not found'), 400);
            }
        }
    }

    public function profile_get()
    {
        $headers = apache_request_headers();
        $token = $headers['KEY'];
        $data = $this->db->where('token', $token)->get('akun');
        if ($data->num_rows() > 0) {
            $profile = $data->row();
            $email = $profile->email;
            $device = $this->db->where('email', $email)->get('device');
            if ($device->num_rows() > 0) {
                $device_list = $device->result();
                $this->response(array('profile' => $profile, 'device' => $device_list), 200);
            } else {
                $this->response(array('profile' => $profile, 'device' => 'not found'), 200);
            }
        } else {
            $this->response(array('status' => 'not found'), 400);
        }
    }

    public function login_post()
    {
        $email = $this->post('email');
        $password = base64_decode($this->post('password'));

        $query = $this->db->where('email', $email)->where('kata_sandi', sha1($password))->get('akun');
        if ($query->num_rows() > 0) {
            $token = $this->GenerateToken->getHash($email, $password);
            $data = array(
                'token' => $token
            );
            $query_update = $this->db->where('email', $email)->where('kata_sandi', sha1($password))->update('akun', $data);
            if ($query_update) {
                $this->response(array('status' => self::SUCCESS, 'token' => $token), 200);
            } else {
                $this->response(array('status' => self::FAIL), 502);
            }
        } else {
            $this->response(array('status' => self::FAIL), 500);
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
                    'servo' => 'Jemur'
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
            $this->response(array('status' => self::FAIL), 500);
        } else {
            $update = $this->db->where('device_id', $id)->update('device', $data);
            if ($update) {
                $this->response(array('status' => self::SUCCESS), 200);
            } else {
                $this->response(array('status' => self::FAIL), 502);
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
            $this->response(array('status' => self::SUCCESS), 201);
        } else {
            $this->response(array('status' => self::FAIL), 502);
        }
    }
}