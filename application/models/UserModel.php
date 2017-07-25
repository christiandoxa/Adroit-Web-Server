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
}