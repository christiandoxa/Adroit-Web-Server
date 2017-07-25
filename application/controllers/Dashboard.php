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
    }

    public function index() {
        $data['judul'] = "Selamat datang Admin!"; //. $this->session->userdata('username') . "!";
        $data['main_view'] = 'utama';

        $this->load->view('template', $data);
    }

    public function tambah_pengguna() {
        $idAcak = hash("sha256", (string)random_int(100000000, 999999999));
        $data['judul'] = 'Tambah Pengguna';
        $data['main_view'] = 'tambah_pengguna';
        $data['idAnggota'] = $idAcak;
        $this->load->view('template', $data);
    }
}