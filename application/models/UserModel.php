<?php

class UserModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll($table)
    {
        return $this->db->get($table)->result();
    }

    public function insert($data, $table)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}