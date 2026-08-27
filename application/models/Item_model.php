<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {

    private $table = 'items';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_by_id($id)
    {
        $this->db->select('items.*, users.name as titipers_name, events.name as event_name');
        $this->db->join('users', 'users.id = items.titipers_id', 'left');
        $this->db->join('events', 'events.id = items.event_id', 'left');
        $this->db->where('items.id', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_all()
    {
        $this->db->select('items.*, users.name as titipers_name, events.name as event_name, events.auction_end');
        $this->db->join('users', 'users.id = items.titipers_id', 'left');
        $this->db->join('events', 'events.id = items.event_id', 'left');
        $this->db->order_by('items.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_titipers_id($titipers_id)
    {
        $this->db->select('items.*, events.name as event_name, events.auction_end');
        $this->db->join('events', 'events.id = items.event_id', 'left');
        $this->db->where('items.titipers_id', $titipers_id);
        $this->db->order_by('items.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_event_id($event_id)
    {
        $this->db->select('items.*, users.name as titipers_name, events.auction_end');
        $this->db->join('users', 'users.id = items.titipers_id', 'left');
        $this->db->join('events', 'events.id = items.event_id', 'left');
        $this->db->where('items.event_id', $event_id);
        $this->db->order_by('items.id', 'ASC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_approved_by_event($event_id)
    {
        $this->db->select('items.*, users.name as titipers_name, events.auction_end');
        $this->db->join('users', 'users.id = items.titipers_id', 'left');
        $this->db->join('events', 'events.id = items.event_id', 'left');
        $this->db->where('items.event_id', $event_id);
        $this->db->where('items.status', 'approved');
        $this->db->order_by('items.id', 'ASC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function submit_to_event($data)
    {
        $data['status']     = 'submitted';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function approve($id, $admin_note = '')
    {
        $data = array(
            'status'      => 'approved',
            'admin_note'  => $admin_note,
            'updated_at'  => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function reject($id, $admin_note = '')
    {
        $data = array(
            'status'      => 'rejected',
            'admin_note'  => $admin_note,
            'updated_at'  => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function update_status($id, $status)
    {
        $data = array(
            'status'      => $status,
            'updated_at'  => date('Y-m-d H:i:s')
        );
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

    public function get_pending_items()
    {
        $this->db->select('items.*, users.name as titipers_name, events.name as event_name');
        $this->db->join('users', 'users.id = items.titipers_id', 'left');
        $this->db->join('events', 'events.id = items.event_id', 'left');
        $this->db->where('items.status', 'pending');
        $this->db->order_by('items.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }
}
