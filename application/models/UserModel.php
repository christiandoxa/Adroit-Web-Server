<?php

class UserModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function getAll($table) {
        return $this->db->get($table)->result();
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete($table, $column, $item) {
        $this->db->where($column, $item)->delete($table);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return true;
        }
    }

    public function update($table, $column, $item, $data) {
        $this->db->where($column, $item)->update($table, $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return true;
        }
    }

    public function getWhere($table, $column, $item) {
        return $this->db->where($column, $item)->get($table)->row();
    }

    public function cekSubscriber() {
        $email = $this->input->post('email');
        $query = $this->db->where('email', $email)
            ->get('subscriber');
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $query = $this->db->where('username', $username)
            ->where('password', sha1($password))
            ->get('admin');

        if ($query->num_rows() > 0) {
            $data = array(
                'logged_in' => true,
                'username' => $username
            );
            $this->session->set_userdata($data);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function count($table) {
        return $this->db->count_all($table);
    }

    public function query($sql) {
        return $query = $this->db->query($sql)->result();
    }
}