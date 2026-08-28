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
            $item = $query->row_array();
            $item['images'] = $this->get_images($id);
            return $item;
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
            $items = $query->result_array();
            return $this->attach_bid_data($items);
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
            $items = $query->result_array();
            return $this->attach_bid_data($items);
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
            $items = $query->result_array();
            return $this->attach_bid_data($items);
        }
        return FALSE;
    }

    private function attach_bid_data(&$items)
    {
        $item_ids = array_column($items, 'id');
        $images = array();
        if (!empty($item_ids)) {
            $this->db->where_in('item_id', $item_ids);
            $this->db->order_by('is_primary', 'DESC');
            $this->db->order_by('sort_order', 'ASC');
            $this->db->order_by('id', 'ASC');
            $rows = $this->db->get('item_images')->result_array();
            foreach ($rows as $r) {
                $images[$r['item_id']][] = $r;
            }
        }

        foreach ($items as &$item) {
            $item['images'] = isset($images[$item['id']]) ? $images[$item['id']] : array();
            $this->db->select('bids.*, users.name as bidder_name');
            $this->db->join('users', 'users.id = bids.bidder_id', 'left');
            $this->db->where('bids.item_id', $item['id']);
            $this->db->order_by('bids.amount', 'DESC', FALSE);
            $bids = $this->db->get('bids')->result_array();
            $item['bids'] = $bids;
            $item['highest_bid'] = !empty($bids) ? (float) $bids[0]['amount'] : (float) $item['starting_price'];
        }
        return $items;
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

    public function get_images($item_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->order_by('is_primary', 'DESC');
        $this->db->order_by('sort_order', 'ASC');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('item_images');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_images_count($item_id)
    {
        return $this->db->where('item_id', $item_id)->count_all_results('item_images');
    }

    public function add_image($item_id, $image, $is_primary = 0, $sort_order = 0)
    {
        return $this->db->insert('item_images', array(
            'item_id'    => $item_id,
            'image'      => $image,
            'is_primary' => $is_primary,
            'sort_order' => $sort_order
        ));
    }

    public function set_primary_image($item_id, $image_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->update('item_images', array('is_primary' => 0));

        $this->db->where('id', $image_id);
        $this->db->where('item_id', $item_id);
        $ok = $this->db->update('item_images', array('is_primary' => 1));

        $img = $this->db->where('id', $image_id)->where('item_id', $item_id)->get('item_images')->row_array();
        if ($img) {
            $this->db->where('id', $item_id);
            $this->db->update($this->table, array('image' => $img['image']));
        }

        return $ok;
    }

    public function delete_image($image_id, $item_id)
    {
        $this->db->where('id', $image_id);
        $this->db->where('item_id', $item_id);
        $query = $this->db->get('item_images');
        $image = $query->row_array();
        if (!$image) {
            return FALSE;
        }

        $was_primary = (int) $image['is_primary'] === 1;

        $this->db->where('id', $image_id);
        $this->db->where('item_id', $item_id);
        $this->db->delete('item_images');

        $image_path = FCPATH . 'uploads/items/' . $image['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        if ($was_primary) {
            $this->reassign_primary($item_id);
        }

        return TRUE;
    }

    private function reassign_primary($item_id)
    {
        $images = $this->get_images($item_id);
        if (!empty($images)) {
            $first = $images[0];
            $this->db->where('id', $first['id']);
            $this->db->update('item_images', array('is_primary' => 1));

            $this->db->where('id', $item_id);
            $this->db->update($this->table, array('image' => $first['image']));
        } else {
            $this->db->where('id', $item_id);
            $this->db->update($this->table, array('image' => NULL));
        }
    }
}
