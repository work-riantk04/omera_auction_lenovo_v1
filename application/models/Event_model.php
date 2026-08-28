<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

    private $table = 'events';

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
        $query = $this->db->where('id', $id)->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_all($limit = 0, $offset = 0)
    {
        $this->db->select('events.*, 
            (SELECT COUNT(*) FROM items WHERE items.event_id = events.id) as item_count,
            (SELECT COUNT(*) FROM bids WHERE bids.event_id = events.id) as bid_count');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function count_all()
    {
        return (int) $this->db->count_all($this->table);
    }

    public function get_active_events()
    {
        $this->db->select('events.*, 
            (SELECT COUNT(*) FROM items WHERE items.event_id = events.id AND items.status = "approved") as item_count,
            (SELECT COUNT(*) FROM bids WHERE bids.event_id = events.id) as bid_count');
        $this->db->where('events.status', 'active');
        $this->db->where('events.auction_end >', date('Y-m-d H:i:s'));
        $this->db->order_by('auction_start', 'ASC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_upcoming_events()
    {
        $this->db->select('events.*, 
            (SELECT COUNT(*) FROM items WHERE items.event_id = events.id AND items.status = "approved") as item_count');
        $this->db->where('events.status', 'active');
        $this->db->where('events.auction_start >', date('Y-m-d H:i:s'));
        $this->db->order_by('auction_start', 'ASC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
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

    public function get_event_detail($id)
    {
        $event = $this->get_by_id($id);
        if (!$event) {
            return FALSE;
        }

        $this->db->select('items.*, users.name as titipers_name');
        $this->db->join('users', 'users.id = items.titipers_id', 'left');
        $this->db->where('items.event_id', $id);
        $this->db->order_by('items.id', 'ASC');
        $items = $this->db->get('items')->result_array();

        foreach ($items as &$item) {
            $this->db->select('bids.*, users.name as bidder_name');
            $this->db->join('users', 'users.id = bids.bidder_id', 'left');
            $this->db->where('bids.item_id', $item['id']);
            $this->db->order_by('bids.amount', 'DESC');
            $item['bids'] = $this->db->get('bids')->result_array();
            $item['highest_bid'] = !empty($item['bids']) ? $item['bids'][0]['amount'] : $item['starting_price'];
        }

        $event['items'] = $items;

        $this->db->select('COUNT(*) as total_bids');
        $this->db->where('event_id', $id);
        $bid_count = $this->db->get('bids')->row_array();
        $event['total_bids'] = $bid_count['total_bids'];

        return $event;
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
