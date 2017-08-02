<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('Email');
    }

    public function index() {
        $this->load->view('/landing/index');
    }

    public function pre_order() {
        $email = $this->input->get('email');
        $data = array(
            'pre_order' => 'sudah'
        );

        if ($this->UserModel->cekPreOrder($email) == true) {
            if ($this->UserModel->update('subscriber', 'email', $email, $data) == true) {
                $view['message'] = 'Pre Order berhasil dilakukan, kami akan menghubungi anda.';
                $this->load->view('landing/index', $view);
            } else {
                $view['messagef'] = 'Pre Order gagal dilakukan, silahkan coba lagi.';
                $this->load->view('landing/index', $view);
            }
        } else {
            redirect('errorpage');
        }
    }

    public function subscribe() {
        if ($this->input->post('submit')) {
            $email = $this->input->post('email');
            $nama = $this->input->post('name');
            $telepon = $this->input->post('telepon');

            $data = array(
                'email' => $email,
                'nama_pelanggan' => $nama,
                'nomor_telepon' => $telepon
            );

            if ($this->UserModel->cekSubscriber() == true) {
                if ($this->UserModel->insert('subscriber', $data) == true) {
                    if ($this->Email->new_subscriber($nama, $email, $telepon) == true) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            redirect(base_url('ErrorPage'));
        }
    }

    public function subscribe_email() {
        if ($this->input->post('submit')) {
            $email = $this->input->post('email');
            $data = array(
                'email' => $email,
            );

            if ($this->UserModel->cekSubscriber() == true) {
                if ($this->UserModel->insert('subscriber', $data) == true) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            redirect(base_url('ErrorPage'));
        }
    }

    public function message() {
        if ($this->input->post('submit')) {
            $sender_email = 'customeradroit@gmail.com';
            $user_password = '@Adroitisthebest1#!';
            $receiver_email = array(
                'zhergiuz@gmail.com',
                'dhenarra18@gmail.com',
                'yobelchris@gmail.com',
                'dhirabastaam@gmail.com',
                'iqbalalbana16@gmail.com'
            );
            $email_customer = $this->input->post('email');
            $nama_customer = $this->input->post('name');
            $pesan_customer = $this->input->post('message');
            $subject = 'Message From Customer Adroit';
            $message = 'Nama : ' . $nama_customer . '<br>Email : <a href="mailto: ' . $email_customer . '">' . $email_customer . '</a><br>Pesan : ' . $pesan_customer;

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

            $data = array(
                'email' => $email_customer,
                'nama_pengirim' => $nama_customer,
                'pesan' => $pesan_customer,
            );

            if ($this->UserModel->insert('pesan', $data)) {
                if ($this->email->send()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } else {
            redirect(base_url('errorpage'));
        }
    }
}