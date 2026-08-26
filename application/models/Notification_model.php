<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

    private $table = 'notifications';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($user_id, $title, $message, $link = '')
    {
        $data = array(
            'user_id'    => $user_id,
            'title'      => $title,
            'message'    => $message,
            'link'       => $link,
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_by_user_id($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_unread($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 0);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_unread_count($user_id)
    {
        return $this->db->where('user_id', $user_id)->where('is_read', 0)->count_all_results($this->table);
    }

    public function mark_as_read($id)
    {
        $this->db->where('id', $id);
        if ($this->db->update($this->table, array('is_read' => 1))) {
            return TRUE;
        }
        return FALSE;
    }

    public function mark_all_as_read($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 0);
        if ($this->db->update($this->table, array('is_read' => 1))) {
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

    public function delete_by_user_id($user_id)
    {
        $this->db->where('user_id', $user_id);
        if ($this->db->delete($this->table)) {
            return TRUE;
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
}
