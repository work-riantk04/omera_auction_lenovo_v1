<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

    private $table = 'contact_messages';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data)
    {
        $data['is_read']    = 0;
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_by_id($id)
    {
        $query = $this->db->where('id', $id)->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_all()
    {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_unread()
    {
        $this->db->where('is_read', 0);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function mark_as_read($id)
    {
        $this->db->where('id', $id);
        if ($this->db->update($this->table, array('is_read' => 1))) {
            return TRUE;
        }
        return FALSE;
    }

    public function mark_all_as_read()
    {
        $this->db->where('is_read', 0);
        if ($this->db->update($this->table, array('is_read' => 1))) {
            return TRUE;
        }
        return FALSE;
    }

    public function get_unread_count()
    {
        return $this->db->where('is_read', 0)->count_all_results($this->table);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return TRUE;
        }
        return FALSE;
    }
}
