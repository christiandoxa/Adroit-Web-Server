<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('GenerateToken');
        $this->load->model('UserModel');
    }

    public function index() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = "Selamat datang " . $this->session->userdata('username') . "!";
            $data['main_view'] = 'utama';
            $data['pengguna'] = $this->UserModel->count('akun');
            $data['perangkat'] = $this->UserModel->count('device');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function tambah_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Tambah Pengguna';
            $data['main_view'] = 'tambah_pengguna';
            $data['pengguna'] = $this->UserModel->getAll('akun');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function tambah_perangkat() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Tambah Perangkat';
            $data['main_view'] = 'tambah_perangkat';
            $data['pengguna'] = $this->UserModel->getAll('akun');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function detail_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            $email = $this->input->get('email');
            $data['judul'] = 'Detail Pengguna';
            $data['main_view'] = 'detail_pengguna';
            $data['detail'] = $this->UserModel->getWhere('akun', 'email', $email);
            $data['perangkat'] = $this->UserModel->query(
                'SELECT * FROM device WHERE email = "' . $email . '";'
            );
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function detail_perangkat() {
        if ($this->session->userdata('logged_in') == true) {
            $device_id = $this->input->get('deviceid');
            $data['judul'] = "Detail Perangkat";
            $data['main_view'] = 'detail_perangkat';
            $data['detail'] = $this->UserModel->getWhere('device', 'device_id', $device_id);
            $data['pengguna'] = $this->UserModel->getAll('akun');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function daftar_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Daftar Pengguna';
            $data['main_view'] = 'daftar_pengguna';
            $data['pengguna'] = $this->UserModel->getAll('akun');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function daftar_perangkat() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Daftar Perangkat';
            $data['main_view'] = 'daftar_perangkat';
            $data['perangkat'] = $this->UserModel
                ->query('SELECT nama, email, device_id FROM akun NATURAL JOIN device;');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function add_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->input->post('submit')) {
                $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
                $this->form_validation->set_rules('katasandi', 'Kata Sandi', 'trim|required');
                $this->form_validation->set_rules('konfirkatasandi', 'Konfirmasi Kata Sandi', 'trim|required');
                $password = $this->input->post('katasandi');
                $kpassword = $this->input->post('konfirkatasandi');
                $email = $this->input->post('email');
                if ($this->form_validation->run() == true) {
                    if ($password == $kpassword) {
                        $data_pengguna = array(
                            'nama' => $this->input->post('nama'),
                            'token' => $this->GenerateToken->getHash($email, $password),
                            'email' => $email,
                            'kata_sandi' => sha1($password)
                        );
                        if ($this->UserModel->insert('akun', $data_pengguna) == true) {
                            $data['judul'] = 'Tambah Pengguna';
                            $data['notifs'] = 'Penambahan Berhasil';
                            $data['main_view'] = 'tambah_pengguna';
                            $data['pengguna'] = $this->UserModel->getAll('akun');
                            $this->load->view('template', $data);
                        } else {
                            $data['judul'] = 'Tambah Pengguna';
                            $data['notif'] = 'Penambahan Gagal';
                            $data['main_view'] = 'tambah_pengguna';
                            $data['pengguna'] = $this->UserModel->getAll('akun');
                            $this->load->view('template', $data);
                        }
                    } else {
                        $data['judul'] = 'Tambah Pengguna';
                        $data['notif'] = 'Konfirmasi kata sandi tidak sama dengan kata sandi.';
                        $data['main_view'] = 'tambah_pengguna';
                        $data['pengguna'] = $this->UserModel->getAll('akun');
                        $this->load->view('template', $data);
                    }
                } else {
                    $data['judul'] = 'Tambah Pengguna';
                    $data['notif'] = validation_errors();
                    $data['main_view'] = 'tambah_pengguna';
                    $data['pengguna'] = $this->UserModel->getAll('akun');
                    $this->load->view('template', $data);
                }
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function add_perangkat() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->input->post('submit')) {
                $this->form_validation->set_rules('deviceid', 'Device ID', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                if ($this->form_validation->run() == true) {
                    $data = array(
                        'device_id' => $this->input->post('deviceid'),
                        'email' => $this->input->post('email')
                    );
                    if ($this->UserModel->insert('device', $data) == true) {
                        $data['judul'] = 'Tambah Perangkat';
                        $data['main_view'] = 'tambah_perangkat';
                        $data['notifs'] = 'Penambahan perangkat berhasil';
                        $data['pengguna'] = $this->UserModel->getAll('akun');
                        $this->load->view('template', $data);
                    }
                }
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function update_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->input->post('submit')) {
                $token = $this->input->get('token');
                $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
                $this->form_validation->set_rules('katasandi', 'Kata Sandi', 'trim|required');
                $email_temp = $this->UserModel->getWhere('akun', 'token', $token)->email;
                $password_temp = $this->UserModel->getWhere('akun', 'token', $token)->kata_sandi;
                $password = $this->input->post('katasandi');
                $email = $this->input->post('email');
                if ($this->form_validation->run() == true) {
                    if ($email == $email_temp && $password == $password_temp) {
                        $data_pengguna = array(
                            'nama' => $this->input->post('nama'),
                            'token' => $token,
                            'email' => $email,
                            'kata_sandi' => $password
                        );
                        if ($this->UserModel->update('akun', 'token', $token, $data_pengguna) == true) {
                            $data['judul'] = 'Detail Pengguna';
                            $data['notifs'] = 'Update Berhasil';
                            $data['main_view'] = 'detail_pengguna';
                            $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token);
                            $data['perangkat'] = $this->UserModel->query(
                                'SELECT * FROM device WHERE email = "' . $email . '";'
                            );
                            $this->load->view('template', $data);
                        } else {
                            $data['judul'] = 'Detail Pengguna';
                            $data['notif'] = 'Update Gagal';
                            $data['main_view'] = 'detail_pengguna';
                            $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token);
                            $data['perangkat'] = $this->UserModel->query(
                                'SELECT * FROM device WHERE email = "' . $email . '";'
                            );
                            $this->load->view('template', $data);
                        }
                    } else {
                        $token_baru = $this->GenerateToken->getHash($email, $password);
                        $kata_sandi_beda = $password;
                        if ($password != $password_temp) {
                            $kata_sandi_beda = sha1($password);
                        }
                        $data_pengguna = array(
                            'nama' => $this->input->post('nama'),
                            'token' => $token_baru,
                            'email' => $email,
                            'kata_sandi' => $kata_sandi_beda
                        );
                        if ($this->UserModel->update('akun', 'token', $token, $data_pengguna) == true) {
                            $data['judul'] = 'Detail Pengguna';
                            $data['notifs'] = 'Update Berhasil';
                            $data['main_view'] = 'detail_pengguna';
                            $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token_baru);
                            $data['perangkat'] = $this->UserModel->query(
                                'SELECT * FROM device WHERE email = "' . $email . '";'
                            );
                            $this->load->view('template', $data);
                        } else {
                            $data['judul'] = 'Detail Pengguna';
                            $data['notif'] = 'Update Gagal';
                            $data['main_view'] = 'detail_pengguna';
                            $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token_baru);
                            $data['perangkat'] = $this->UserModel->query(
                                'SELECT * FROM device WHERE email = "' . $email . '";'
                            );
                            $this->load->view('template', $data);
                        }
                    }
                } else {
                    $data['judul'] = 'Detail Pengguna';
                    $data['notif'] = validation_errors();
                    $data['main_view'] = 'detail_pengguna';
                    $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token);
                    $data['perangkat'] = $this->UserModel->query(
                        'SELECT * FROM device WHERE email = "' . $email . '";'
                    );
                    $this->load->view('template', $data);
                }
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function update_perangkat() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->input->post('submit')) {
                $device_id = $this->input->get('deviceid');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('deviceid', 'Device ID', 'trim|required');
                $email = $this->input->post('email');
                $device_id_now = $this->input->post('deviceid');
                if ($this->form_validation->run() == true) {
                    $data_perangkat = array(
                        'email' => $email,
                        'device_id' => $device_id_now
                    );
                    if ($this->UserModel->update('device', 'device_id', $device_id, $data_perangkat) == true) {
                        $data['judul'] = 'Detail Pengguna';
                        $data['notifs'] = 'Update data perangkat berhasil.';
                        $data['main_view'] = 'detail_perangkat';
                        $data['detail'] = $this->UserModel->getWhere('device', 'device_id', $device_id_now);
                        $data['pengguna'] = $this->UserModel->getAll('akun');
                        $this->load->view('template', $data);
                    } else {
                        $data['judul'] = 'Detail Pengguna';
                        $data['notif'] = 'Update data perangkat gagal.';
                        $data['main_view'] = 'detail_perangkat';
                        $data['detail'] = $this->UserModel->getWhere('device', 'device_id', $device_id);
                        $data['pengguna'] = $this->UserModel->getAll('akun');
                        $this->load->view('template', $data);
                    }
                } else {
                    $data['judul'] = 'Detail Pengguna';
                    $data['notif'] = validation_errors();
                    $data['main_view'] = 'detail_perangkat';
                    $data['detail'] = $this->UserModel->getWhere('device', 'device_id', $device_id);
                    $data['pengguna'] = $this->UserModel->getAll('akun');
                    $this->load->view('template', $data);
                }
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function hapus_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            $email = $this->input->get('email');
            if ($this->UserModel->delete('akun', 'email', $email) == true) {
                $data['judul'] = 'Daftar Pengguna';
                $data['notifs'] = 'Hapus Berhasil';
                $data['main_view'] = 'daftar_pengguna';
                $data['pengguna'] = $this->UserModel->getAll('akun');
                $this->load->view('template', $data);
            } else {
                $data['judul'] = 'Daftar Pengguna';
                $data['notif'] = 'Hapus Gagal';
                $data['main_view'] = 'daftar_pengguna';
                $data['pengguna'] = $this->UserModel->getAll('akun');
                $this->load->view('template', $data);
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function hapus_perangkat() {
        if ($this->session->userdata('logged_in') == true) {
            $device_id = $this->input->get('deviceid');
            if ($this->UserModel->delete('device', 'device_id', $device_id) == true) {
                $data['judul'] = 'Daftar Perangkat';
                $data['notifs'] = 'Hapus Berhasil';
                $data['main_view'] = 'daftar_perangkat';
                $data['perangkat'] = $this->UserModel
                    ->query('SELECT nama, email, device_id FROM akun NATURAL JOIN device;');
                $this->load->view('template', $data);
            } else {
                $data['judul'] = 'Daftar Perangkat';
                $data['notif'] = 'Hapus Gagal';
                $data['main_view'] = 'daftar_perangkat';
                $data['perangkat'] = $this->UserModel
                    ->query('SELECT nama, email, device_id FROM akun NATURAL JOIN device;');
                $this->load->view('template', $data);
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function login() {
        if ($this->input->post('submit')) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                if ($this->UserModel->login() == TRUE)
                    if ($_SERVER['HTTP_REFERER'] == base_url()) {
                        redirect(base_url('dashboard'));
                    } else {
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                else {
                    $data['notif'] = 'Login gagal';
                    $this->load->view('login', $data);
                }
            } else {
                $data['notif'] = 'Login gagal';
                $this->load->view('login', $data);
            }
        }
    }

    public function logout() {
        if ($this->session->userdata('logged_in') == true) {
            $data = array(
                'logged_in' => ''
            );
            $this->session->sess_destroy();
            redirect(base_url());
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }
}