<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disbursement_model extends CI_Model {

    private $table = 'disbursements';

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
        $this->db->select('disbursements.*, users.name as titipers_name, users.email as titipers_email, shipping.shipping_proof, items.name as item_name');
        $this->db->join('users', 'users.id = disbursements.titipers_id', 'left');
        $this->db->join('shipping', 'shipping.id = disbursements.shipping_id', 'left');
        $this->db->join('invoices', 'invoices.id = shipping.invoice_id', 'left');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->where('disbursements.id', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function get_all()
    {
        $this->db->select('disbursements.*, users.name as titipers_name, shipping.status as shipping_status');
        $this->db->join('users', 'users.id = disbursements.titipers_id', 'left');
        $this->db->join('shipping', 'shipping.id = disbursements.shipping_id', 'left');
        $this->db->order_by('disbursements.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_titipers_id($titipers_id)
    {
        $this->db->select('disbursements.*, items.name as item_name, shipping.status as shipping_status');
        $this->db->join('shipping', 'shipping.id = disbursements.shipping_id', 'left');
        $this->db->join('invoices', 'invoices.id = shipping.invoice_id', 'left');
        $this->db->join('items', 'items.id = invoices.item_id', 'left');
        $this->db->where('disbursements.titipers_id', $titipers_id);
        $this->db->order_by('disbursements.created_at', 'DESC');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function process($id)
    {
        $data = array(
            'status'        => 'processed',
            'processed_at'  => date('Y-m-d H:i:s')
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
