<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping_model extends CI_Model {

    private $table = 'shipping';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data)
    {
        $data['status']     = 'pending';
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_by_id($id)
    {
        $this->db->select('shipping.*, invoices.win_amount, invoices.payment_status, items.name as item_name, items.image as item_image, users.name as titipers_name');
        $this->db->join('invoices', 'invoices.id = shipping.invoice_id', 'left');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->join('users', 'users.id = shipping.titipers_id', 'left');
        $this->db->where('shipping.id', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_all()
    {
        $this->db->select('shipping.*, invoices.win_amount, items.name as item_name, users.name as titipers_name');
        $this->db->join('invoices', 'invoices.id = shipping.invoice_id', 'left');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->join('users', 'users.id = shipping.titipers_id', 'left');
        $this->db->order_by('shipping.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_titipers_id($titipers_id)
    {
        $this->db->select('shipping.*, invoices.win_amount, invoices.payment_status, items.name as item_name, items.image as item_image');
        $this->db->join('invoices', 'invoices.id = shipping.invoice_id', 'left');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->where('shipping.titipers_id', $titipers_id);
        $this->db->order_by('shipping.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_invoice_id($invoice_id)
    {
        $this->db->select('shipping.*, users.name as titipers_name');
        $this->db->join('users', 'users.id = shipping.titipers_id', 'left');
        $this->db->where('shipping.invoice_id', $invoice_id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function update_shipping_proof($id, $proof)
    {
        $data = array(
            'shipping_proof' => $proof,
            'status'         => 'shipped',
            'shipped_at'     => date('Y-m-d H:i:s'),
            'created_at'     => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function verify_delivery($id)
    {
        $data = array(
            'status'       => 'delivered',
            'delivered_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
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
