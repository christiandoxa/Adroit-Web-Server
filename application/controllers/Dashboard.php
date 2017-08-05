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
            $data['pesan'] = $this->UserModel->count('pesan');
            $data['pelanggan'] = $this->UserModel->count('subscriber');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function broadcast_email_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Broadcast Email Pengguna';
            $data['main_view'] = 'broadcast_email';
            $data['link'] = 'broadcast_pengguna';
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function broadcast_email_pelanggan() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Broadcast Email Pelanggan';
            $data['main_view'] = 'broadcast_email';
            $data['link'] = 'broadcast_pelanggan';
            $this->load->view('template', $data);
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function broadcast_pengguna() {
        if ($this->session->userdata('logged_in') == true) {
            $email = $this->input->post('email');
            $sender_email = 'customeradroit@gmail.com';
            $user_password = '@Adroitisthebest1#!';
            $daftar_pengguna = $this->UserModel->getColumnArray('akun', 'email');
            $string_pengguna = array();
            foreach ($daftar_pengguna as $item => $value) {
                $string_pengguna[] = $value['email'];
            }
            $receiver_email = $string_pengguna;
            $subject = 'News From Adroit';
            $message = $email;

            // Configure email library
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.googlemail.com';
            $config['smtp_port'] = 465;
            $config['smtp_user'] = $sender_email;
            $config['smtp_pass'] = $user_password;
            $config['mailtype'] = 'html';

            // Load email library and passing configured values to email library
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            // Sender email address
            $this->email->from('customeradroit@gmail.com', "Adroit Apps Service");
            // Receiver email address
            $this->email->to('customeradroit@gmail.com');
            $this->email->bcc($receiver_email);
            // Subject of email
            $this->email->subject($subject);
            // Message in email
            $this->email->message($message);

            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }


        } else {
            $data['notif'] = 'Silahkan login terlebih dahulu.';
            $this->load->view('login', $data);
        }
    }

    public function broadcast_pelanggan() {
        if ($this->session->userdata('logged_in') == true) {
            $email = $this->input->post('email');
            $sender_email = 'customeradroit@gmail.com';
            $user_password = '@Adroitisthebest1#!';
            $daftar_pengguna = $this->UserModel->getColumnArray('subscriber', 'email');
            $string_pengguna = array();
            foreach ($daftar_pengguna as $item => $value) {
                $string_pengguna[] = $value['email'];
            }
            $receiver_email = $string_pengguna;
            $subject = 'News From Adroit';
            $message = $email;

            // Configure email library
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.googlemail.com';
            $config['smtp_port'] = 465;
            $config['smtp_user'] = $sender_email;
            $config['smtp_pass'] = $user_password;
            $config['mailtype'] = 'html';

            // Load email library and passing configured values to email library
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            // Sender email address
            $this->email->from('customeradroit@gmail.com', "Adroit Apps Service");
            // Receiver email address
            $this->email->to('customeradroit@gmail.com');
            $this->email->bcc($receiver_email);
            // Subject of email
            $this->email->subject($subject);
            // Message in email
            $this->email->message($message);

            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }


        } else {
            $data['notif'] = 'Silahkan login terlebih dahulu.';
            $this->load->view('login', $data);
        }
    }


    public function kirim_pesan() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->input->post('submit')) {
                $id_pesan = $this->input->get('id');
                $balasan = $this->input->post('balas');
                $status = 'dibalas';
                $email_pengirim = $this->input->post('email');
                $data = array(
                    'balasan' => $balasan,
                    'status' => $status
                );

                if ($this->UserModel->update('pesan', 'id_pesan', $id_pesan, $data)) {
                    $sender_email = 'customeradroit@gmail.com';
                    $user_password = '@Adroitisthebest1#!';
                    $receiver_email = $email_pengirim;
                    $subject = 'Reply From Adroit';
                    $message = $balasan;

                    // Configure email library
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                    $config['smtp_port'] = 465;
                    $config['smtp_user'] = $sender_email;
                    $config['smtp_pass'] = $user_password;
                    $config['mailtype'] = 'html';

                    // Load email library and passing configured values to email library
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");

                    // Sender email address
                    $this->email->from('customeradroit@gmail.com', "Customer Adroit Apps Service");
                    // Receiver email address
                    $this->email->to($receiver_email);
                    // Subject of email
                    $this->email->subject($subject);
                    // Message in email
                    $this->email->message($message);

                    if ($this->email->send()) {
                        $data['judul'] = 'Detail Pesan';
                        $data['notifs'] = 'Email sukses terkirim';
                        $data['main_view'] = 'detail_pesan';
                        $data['detail'] = $this->UserModel->getWhere('pesan', 'id_pesan', $id_pesan);
                        $this->load->view('template', $data);
                    } else {
                        $data['judul'] = 'Detail Pesan';
                        $data['notif'] = 'Email gagal terkirim';
                        $data['main_view'] = 'detail_pesan';
                        $data['detail'] = $this->UserModel->getWhere('pesan', 'id_pesan', $id_pesan);
                        $this->load->view('template', $data);
                    }
                } else {
                    $data['judul'] = 'Detail Pesan';
                    $data['notif'] = 'Gagal insert ke database';
                    $data['main_view'] = 'detail_pesan';
                    $data['detail'] = $this->UserModel->getWhere('pesan', 'id_pesan', $id_pesan);
                    $this->load->view('template', $data);
                }
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function kirim_pesan_subscriber() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->input->post('submit')) {
                $email = $this->input->get('email');
                $balasan = $this->input->post('balas');
                $email_pelanggan_baru = $this->input->post('email');
                $data = array(
                    'balasan' => $balasan,
                );

                if ($this->UserModel->update('subscriber', 'email', $email, $data)) {
                    $sender_email = 'customeradroit@gmail.com';
                    $user_password = '@Adroitisthebest1#!';
                    $receiver_email = $email_pelanggan_baru;
                    $subject = 'Adroit Devs Team';
                    $message = $balasan;

                    // Configure email library
                    $config['protocol'] = 'smtp';
                    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
                    $config['smtp_port'] = 465;
                    $config['smtp_user'] = $sender_email;
                    $config['smtp_pass'] = $user_password;
                    $config['mailtype'] = 'html';

                    // Load email library and passing configured values to email library
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");

                    // Sender email address
                    $this->email->from('customeradroit@gmail.com', "Staff Adroit Devs Team");
                    // Receiver email address
                    $this->email->to($receiver_email);
                    // Subject of email
                    $this->email->subject($subject);
                    // Message in email
                    $this->email->message($message);

                    if ($this->email->send()) {
                        $data['judul'] = 'Detail Pelanggan Baru';
                        $data['notifs'] = 'Email sukses terkirim';
                        $data['main_view'] = 'detail_pelanggan_baru';
                        $data['detail'] = $this->UserModel->getWhere('subscriber', 'email', $email);
                        $this->load->view('template', $data);
                    } else {
                        $data['judul'] = 'Detail Pelanggan Baru';
                        $data['notif'] = 'Email gagal terkirim';
                        $data['main_view'] = 'detail_pelanggan_baru';
                        $data['detail'] = $this->UserModel->getWhere('subscriber', 'email', $email);
                        $this->load->view('template', $data);
                    }
                } else {
                    $data['judul'] = 'Detail Pelanggan Baru';
                    $data['notif'] = 'Gagal insert ke database';
                    $data['main_view'] = 'detail_pelanggan_baru';
                    $data['detail'] = $this->UserModel->getWhere('subscriber', 'email', $email);
                    $this->load->view('template', $data);
                }
            }
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

    public function detail_pesan() {
        if ($this->session->userdata('logged_in') == true) {
            $id_pesan = $this->input->get('id');
            $data['judul'] = 'Detail Pesan';
            $data['main_view'] = 'detail_pesan';
            $data['detail'] = $this->UserModel->getWhere('pesan', 'id_pesan', $id_pesan);
            $this->load->view('template', $data);
        } else {
            $data['notif'] = 'Silahkan login terlebih dahulu.';
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

    public function detail_pelanggan() {
        if ($this->session->userdata('logged_in') == true) {
            $email = $this->input->get('email');
            $data['judul'] = 'Detail Pelanggan';
            $data['main_view'] = 'detail_pelanggan';
            $data['detail'] = $this->UserModel->getWhere('subscriber', 'email', $email);
            $this->load->view('template', $data);

        } else {
            $data['notif'] = 'Silahkan login terlebih dahulu.';
            $this->load->view('login', $data);
        }
    }

    public function daftar_pelanggan() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Daftar Pelanggan';
            $data['main_view'] = 'daftar_pelanggan';
            $data['pelanggan'] = $this->UserModel->getAll('subscriber');
            $this->load->view('template', $data);
        } else {
            $data['notif'] = 'Silahkan login terlebih dahulu';
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

    public function daftar_pesan() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = "Daftar Pesan";
            $data['main_view'] = 'daftar_pesan';
            $data['pesan'] = $this->UserModel->getAll('pesan');
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

    public function hapus_pesan() {
        if ($this->session->userdata('logged_in') == true) {
            $id_pesan = $this->input->get('id');
            if ($this->UserModel->delete('pesan', 'id_pesan', $id_pesan) == true) {
                $data['judul'] = 'Daftar Pesan';
                $data['notifs'] = 'Hapus Berhasil';
                $data['main_view'] = 'daftar_pesan';
                $data['pesan'] = $this->UserModel->getAll('pesan');
                $this->load->view('template', $data);
            } else {
                $data['judul'] = 'Daftar Pesan';
                $data['notif'] = 'Hapus Gagal';
                $data['main_view'] = 'daftar_pesan';
                $data['pesan'] = $this->UserModel->getAll('pesan');
                $this->load->view('template', $data);
            }
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }

    public function hapus_pelanggan() {
        if ($this->session->userdata('logged_in') == true) {
            $email = $this->input->get('email');
            if ($this->UserModel->delete('subscriber', 'email', $email) == true) {
                $data['judul'] = 'Daftar Pelanggan';
                $data['notifs'] = 'Hapus Berhasil';
                $data['main_view'] = 'daftar_pelanggan';
                $data['pelanggan'] = $this->UserModel->getAll('subscriber');
                $this->load->view('template', $data);
            } else {
                $data['judul'] = 'Daftar Pelanggan';
                $data['notif'] = 'Hapus Gagal';
                $data['main_view'] = 'daftar_pelanggan';
                $data['pelanggan'] = $this->UserModel->getAll('subscriber');
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
                    if ($_SERVER['HTTP_REFERER'] == base_url('login')) {
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
            redirect(base_url('login'));
        } else {
            $data['notif'] = "Silahkan login terlebih dahulu.";
            $this->load->view('login', $data);
        }
    }
}