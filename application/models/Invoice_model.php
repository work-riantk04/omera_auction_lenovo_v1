<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    private $table = 'invoices';

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
        $this->db->select('invoices.*, items.name as item_name, items.image as item_image, users.name as bidder_name, users.email as bidder_email, events.name as event_name');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->join('users', 'users.id = invoices.bidder_id', 'left');
        $this->db->join('events', 'events.id = invoices.event_id', 'left');
        $this->db->where('invoices.id', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_all()
    {
        $this->db->select('invoices.*, items.name as item_name, users.name as bidder_name, events.name as event_name');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->join('users', 'users.id = invoices.bidder_id', 'left');
        $this->db->join('events', 'events.id = invoices.event_id', 'left');
        $this->db->order_by('invoices.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_bidder_id($bidder_id)
    {
        $this->db->select('invoices.*, items.name as item_name, items.image as item_image, events.name as event_name');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->join('events', 'events.id = invoices.event_id', 'left');
        $this->db->where('invoices.bidder_id', $bidder_id);
        $this->db->order_by('invoices.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_event_id($event_id)
    {
        $this->db->select('invoices.*, items.name as item_name, users.name as bidder_name');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->join('users', 'users.id = invoices.bidder_id', 'left');
        $this->db->where('invoices.event_id', $event_id);
        $this->db->order_by('invoices.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function generate_for_winners($event_id)
    {
        $this->load->model('bid_model');
        $winners = $this->bid_model->get_winning_bids($event_id);
        if (!$winners) {
            return FALSE;
        }

        $created = array();
        foreach ($winners as $winner) {
            $exists = $this->db->where('event_id', $event_id)->where('item_id', $winner['item_id'])->count_all_results($this->table);
            if ($exists > 0) {
                continue;
            }

            $invoice_data = array(
                'event_id'      => $event_id,
                'item_id'       => $winner['item_id'],
                'bidder_id'     => $winner['bidder_id'],
                'win_amount'    => $winner['amount'],
                'payment_status'=> 'pending',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            );
            $id = $this->create($invoice_data);
            if ($id) {
                $created[] = $id;
            }
        }

        return !empty($created) ? $created : FALSE;
    }

    public function update_payment_proof($id, $proof)
    {
        $data = array(
            'payment_proof' => $proof,
            'updated_at'    => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function verify_payment($id)
    {
        $data = array(
            'payment_status' => 'paid',
            'paid_at'        => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function reject_payment($id)
    {
        $data = array(
            'payment_status' => 'rejected',
            'payment_proof'  => NULL,
            'updated_at'     => date('Y-m-d H:i:s')
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

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return TRUE;
        }
        return FALSE;
    }
}
