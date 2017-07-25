<?php
/**
 * Created by PhpStorm.
 * User: doxa
 * Date: 24/07/17
 * Time: 16:39
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('GenerateToken');
        $this->load->model('UserModel');
    }

    public function index() {
        $data['judul'] = "Selamat datang Admin!"; //. $this->session->userdata('username') . "!";
        $data['main_view'] = 'utama';

        $this->load->view('template', $data);
    }

    public function tambah_pengguna() {
        $data['judul'] = 'Tambah Pengguna';
        $data['main_view'] = 'tambah_pengguna';
        $this->load->view('template', $data);
    }

    public function detail_pengguna() {
        $token = $this->input->get('token');
        $data['judul'] = 'Detail Pengguna';
        $data['main_view'] = 'detail_pengguna';
        $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token);
        $this->load->view('template', $data);
    }

    public function daftar_pengguna() {
        $data['judul'] = 'Daftar Pengguna';
        $data['main_view'] = 'daftar_pengguna';
        $data['pengguna'] = $this->UserModel->getAll('akun');
        $this->load->view('template', $data);
    }

    public function add_pengguna() {
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
                        $this->load->view('template', $data);
                    } else {
                        $data['judul'] = 'Tambah Pengguna';
                        $data['notif'] = 'Penambahan Gagal';
                        $data['main_view'] = 'tambah_pengguna';
                        $this->load->view('template', $data);
                    }
                } else {
                    $data['judul'] = 'Tambah Pengguna';
                    $data['notif'] = 'Konfirmasi kata sandi tidak sama dengan kata sandi.';
                    $data['main_view'] = 'tambah_pengguna';
                    $this->load->view('template', $data);
                }
            } else {
                $data['judul'] = 'Tambah Pengguna';
                $data['notif'] = validation_errors();
                $data['main_view'] = 'tambah_pengguna';
                $this->load->view('template', $data);
            }
        }
    }

    public function update_pengguna() {
        if ($this->input->post('submit')) {
            $token = $this->input->get('token');
            $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
            $this->form_validation->set_rules('katasandi', 'Kata Sandi', 'trim|required');
            $this->form_validation->set_rules('konfirkatasandi', 'Konfirmasi Kata Sandi', 'trim|required');
            $email_temp = $this->UserModel->getWhere('akun', 'token', $token)->email;
            $password_temp = $this->UserModel->getWhere('akun', 'token', $token)->kata_sandi;
            $tokimai = $this->UserModel->getWhere('akun', 'token', $token)->token;
            $password = $this->input->post('katasandi');
            $kpassword = $this->input->post('konfirkatasandi');
            $email = $this->input->post('email');

            if ($this->form_validation->run() == true) {
                if ($password == $kpassword) {
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
                            $this->load->view('template', $data);
                        } else {
                            $data['judul'] = 'Detail Pengguna';
                            $data['notif'] = 'Update Gagal';
                            $data['main_view'] = 'detail_pengguna';
                            $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token);
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
                            $this->load->view('template', $data);
                        } else {
                            $data['judul'] = 'Detail Pengguna';
                            $data['notif'] = 'Update Gagal';
                            $data['main_view'] = 'detail_pengguna';
                            $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token_baru);
                            $this->load->view('template', $data);
                        }
                    }
                } else {
                    $data['judul'] = 'Detail Pengguna';
                    $data['notif'] = 'Konfirmasi kata sandi tidak sama dengan kata sandi.';
                    $data['main_view'] = 'detail_pengguna';
                    $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token);
                    $this->load->view('template', $data);
                }
            } else {
                $data['judul'] = 'Detail Pengguna';
                $data['notif'] = validation_errors();
                $data['main_view'] = 'detail_pengguna';
                $data['detail'] = $this->UserModel->getWhere('akun', 'token', $token);
                $this->load->view('template', $data);
            }
        }
    }

    public function hapus_pengguna() {
        $token = $this->input->get('token');
        if ($this->UserModel->delete('akun', 'token', $token) == true) {
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
    }
}