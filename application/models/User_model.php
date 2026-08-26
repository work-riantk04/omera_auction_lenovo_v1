<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['is_active'] = 1;

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function login($email, $password)
    {
        $query = $this->db->where('email', $email)->get($this->table);
        if ($query->num_rows() === 1) {
            $user = $query->row_array();
            if (password_verify($password, $user['password'])) {
                if ($user['is_active'] == 0) {
                    return FALSE;
                }
                unset($user['password']);
                return $user;
            }
        }
        return FALSE;
    }

    public function get_by_id($id)
    {
        $query = $this->db->where('id', $id)->get($this->table);
        if ($query->num_rows() === 1) {
            $user = $query->row_array();
            unset($user['password']);
            return $user;
        }
        return FALSE;
    }

    public function get_all()
    {
        $this->db->select('id, name, email, phone, address, role, avatar, is_active, created_at, updated_at');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_by_role($role)
    {
        $this->db->select('id, name, email, phone, address, role, avatar, is_active, created_at, updated_at');
        $query = $this->db->where('role', $role)->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function update_profile($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function update_avatar($id, $avatar)
    {
        $data = array(
            'avatar'      => $avatar,
            'updated_at'  => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function generate_reset_token($email)
    {
        $query = $this->db->where('email', $email)->get($this->table);
        if ($query->num_rows() === 1) {
            $token = bin2hex(random_bytes(32));
            $data = array(
                'reset_token'   => $token,
                'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                'updated_at'    => date('Y-m-d H:i:s')
            );
            $this->db->where('email', $email);
            $this->db->update($this->table, $data);
            return $token;
        }
        return FALSE;
    }

    public function check_reset_token($token)
    {
        $query = $this->db
            ->where('reset_token', $token)
            ->where('reset_expires >', date('Y-m-d H:i:s'))
            ->get($this->table);
        if ($query->num_rows() === 1) {
            return $query->row_array();
        }
        return FALSE;
    }

    public function reset_password($token, $new_password)
    {
        $user = $this->check_reset_token($token);
        if ($user) {
            $data = array(
                'password'       => password_hash($new_password, PASSWORD_DEFAULT),
                'reset_token'    => NULL,
                'reset_expires'  => NULL,
                'updated_at'     => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $user['id']);
            if ($this->db->update($this->table, $data)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function change_password($id, $new_password)
    {
        $data = array(
            'password'    => password_hash($new_password, PASSWORD_DEFAULT),
            'updated_at'  => date('Y-m-d H:i:s')
        );
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function get_notification_count($user_id)
    {
        return $this->db->where('user_id', $user_id)->where('is_read', 0)->count_all_results('notifications');
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return TRUE;
        }
        return FALSE;
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function count_by_role($role)
    {
        return $this->db->where('role', $role)->count_all_results($this->table);
    }

    public function is_email_exists($email, $exclude_id = 0)
    {
        $this->db->where('email', $email);
        if ($exclude_id > 0) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results($this->table) > 0;
    }
}
