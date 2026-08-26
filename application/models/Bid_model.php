<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bid_model extends CI_Model {

    private $table = 'bids';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function place_bid($event_id, $item_id, $bidder_id, $amount)
    {
        $amount = (float) $amount;

        $this->db->where('event_id', $event_id);
        $this->db->where('item_id', $item_id);
        $this->db->where('status', 'approved');
        $item = $this->db->get('items')->row_array();
        if (!$item) {
            return FALSE;
        }

        $highest = $this->get_highest_bid($item_id);
        $min_bid = $item['starting_price'];
        if ($highest) {
            $min_bid = $highest['amount'] + 1;
        }

        if ($amount < $min_bid) {
            return FALSE;
        }

        $bid_data = array(
            'event_id'   => $event_id,
            'item_id'    => $item_id,
            'bidder_id'  => $bidder_id,
            'amount'     => $amount,
            'created_at' => date('Y-m-d H:i:s')
        );

        return $this->create($bid_data);
    }

    public function get_highest_bid($item_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->order_by('amount', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_by_bidder_id($bidder_id)
    {
        $this->db->select('bids.*, items.name as item_name, items.image as item_image, events.name as event_name');
        $this->db->join('items', 'items.id = bids.item_id', 'left');
        $this->db->join('events', 'events.id = bids.event_id', 'left');
        $this->db->where('bids.bidder_id', $bidder_id);
        $this->db->order_by('bids.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_bids_by_item($item_id)
    {
        $this->db->select('bids.*, users.name as bidder_name');
        $this->db->join('users', 'users.id = bids.bidder_id', 'left');
        $this->db->where('bids.item_id', $item_id);
        $this->db->order_by('bids.amount', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_bids_by_event($event_id)
    {
        $this->db->select('bids.*, items.name as item_name, users.name as bidder_name');
        $this->db->join('items', 'items.id = bids.item_id', 'left');
        $this->db->join('users', 'users.id = bids.bidder_id', 'left');
        $this->db->where('bids.event_id', $event_id);
        $this->db->order_by('bids.amount', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_winning_bids($event_id)
    {
        $this->db->select('bids.*, items.name as item_name, items.image as item_image, users.name as bidder_name, users.email as bidder_email');
        $this->db->join('items', 'items.id = bids.item_id', 'left');
        $this->db->join('users', 'users.id = bids.bidder_id', 'left');
        $this->db->where('bids.event_id', $event_id);

        $subquery = "(SELECT MAX(b2.amount) FROM bids b2 WHERE b2.item_id = bids.item_id) = bids.amount";
        $this->db->where($subquery);
        $this->db->order_by('bids.item_id', 'ASC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_winning_bid_for_item($item_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->order_by('amount', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_all()
    {
        $this->db->select('bids.*, items.name as item_name, users.name as bidder_name, events.name as event_name');
        $this->db->join('items', 'items.id = bids.item_id', 'left');
        $this->db->join('users', 'users.id = bids.bidder_id', 'left');
        $this->db->join('events', 'events.id = bids.event_id', 'left');
        $this->db->order_by('bids.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function count_bids_by_event($event_id)
    {
        return $this->db->where('event_id', $event_id)->count_all_results($this->table);
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
