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
}