<?php
require APPPATH . './libraries/REST_Controller.php';

class LoginAwal extends CI_Controller
{
    const SUCCESS = 'success';
    const FAIL = 'fail';

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('GenerateToken');
    }

    public function index()
    {
        $email = $this->input->post('email');
        $password = base64_decode($this->input->post('password'));

        $query = $this->db->where('email', $email)->where('kata_sandi', sha1($password))->get('akun');
        if ($query->num_rows() > 0) {
            $token = $this->GenerateToken->getHash($email, $password);
            $data = array(
                'token' => $token
            );
            $query_update = $this->db->where('email', $email)->where('kata_sandi', sha1($password))->update('akun', $data);
            if ($query_update) {
                echo json_encode(array('status' => self::SUCCESS, 'token' => $token));
            } else {
                echo json_encode(array('status' => self::FAIL));
            }
        } else {
            echo json_encode(array('status' => self::FAIL));
        }
    }

    public function withGmail()
    {
        $email = base64_decode($this->input->post('email'));
        $name = base64_decode($this->input->post('name'));
        $password = $this->GenerateToken->getPass();
        $token = $this->GenerateToken->getHash($email, $password);

        $query = $this->db->where('email', $email)->get('akun');
        if ($query->num_rows() > 0) {
            $data = array(
                'token' => $token
            );
            $query_update = $this->db->where('email', $email)->update('akun', $data);
            if ($query_update) {
                echo json_encode(array('status' => self::SUCCESS, 'token' => $token));
            } else {
                echo json_encode(array('status' => self::FAIL));
            }
        } else {
            $data = array(
                'token' => $token,
                'email' => $email,
                'nama' => $name,
                'kata_sandi' => $password
            );
            $this->db->insert('akun', $data);
            if ($this->db->affected_rows() > 0) {
                echo json_encode(array('status' => self::SUCCESS, 'token' => $token));
            } else {
                echo json_encode(array('status' => self::FAIL));
            }
        }
    }

    public function SignUp()
    {
        $email = base64_decode($this->input->post('email'));
        $nama = base64_decode($this->input->post('name'));
        $password = base64_decode($this->input->post('password'));

        $data = array(
            'email' => $email,
            'kata_sandi' => $password,
            'nama' => $nama
        );

        $query = $this->db->where('email', $email)->get('akun');
        if ($query->num_rows() > 0) {
            echo json_encode(array('status' => 'Already Exist'));
        } else {
            $this->db->insert('akun', $data);
            if ($this->db->affected_rows() > 0) {
                echo json_encode(array('status' => self::SUCCESS));
            } else {
                echo json_encode(array('status' => self::FAIL));
            }
        }
    }
}