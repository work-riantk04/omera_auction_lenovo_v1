<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Titipers extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'titipers')
		{
			$this->session->set_flashdata('error', 'You must be logged in as titipers.');
			redirect('auth/login');
		}
		$this->load->model(['Item_model', 'Event_model', 'Shipping_model', 'Notification_model', 'Bid_model', 'Invoice_model']);
		$this->load->helper(['url', 'form']);
		$this->load->library(['session', 'form_validation', 'upload']);
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		$data['title'] = 'Titipers Dashboard';
		$user_id = $this->session->userdata('user_id');
		$items = $this->Item_model->get_by_titipers_id($user_id) ?: [];
		$data['total_items'] = count($items);
		$data['active_items'] = count(array_filter($items, function ($item) {
			return $item['status'] === 'approved';
		}));
		$data['total_sold'] = count(array_filter($items, function ($item) {
			return $item['status'] === 'sold';
		}));
		$revenue = 0;
		foreach ($items as $item) {
			if ($item['status'] === 'sold') {
				$bid = $this->Bid_model->get_highest_bid($item['id']);
				if ($bid) {
					$revenue += $bid['amount'];
				}
			}
		}
		$data['total_revenue'] = $revenue;
		$all_items = $this->Item_model->get_by_titipers_id($user_id) ?: [];
		$data['recent_items'] = array_slice($all_items, 0, 5);
		$this->load->view('templates/titipers/header', $data);
		$this->load->view('titipers/dashboard', $data);
		$this->load->view('templates/titipers/footer');
	}

	public function items()
	{
		$data['title'] = 'My Items';
		$user_id = $this->session->userdata('user_id');
		$data['items'] = $this->Item_model->get_by_titipers_id($user_id);
		$this->load->view('templates/titipers/header', $data);
		$this->load->view('titipers/items', $data);
		$this->load->view('templates/titipers/footer');
	}

	public function items_add()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('name', 'Item Name', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('starting_price', 'Starting Price', 'required|numeric');
			$this->form_validation->set_rules('category', 'Category', 'required|trim');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Add Item';
				$data['events'] = $this->Event_model->get_all() ?: [];
				$this->load->view('templates/titipers/header', $data);
				$this->load->view('titipers/items_add', $data);
				$this->load->view('templates/titipers/footer');
			}
			else
			{
				$config['upload_path'] = FCPATH . 'uploads/items/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 2048;
				$config['encrypt_name'] = TRUE;

				if (!is_dir($config['upload_path']))
				{
					mkdir($config['upload_path'], 0777, TRUE);
				}

				$this->upload->initialize($config);
				$image_name = '';

				if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)
				{
					if (!$this->upload->do_upload('image'))
					{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('titipers/items_add');
					}
					else
					{
						$upload_data = $this->upload->data();
						$image_name = $upload_data['file_name'];
					}
				}

				$insert = [
					'titipers_id' => $this->session->userdata('user_id'),
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'starting_price' => $this->input->post('starting_price'),
					'category' => $this->input->post('category'),
					'image' => $image_name,
					'status' => 'available',
					'created_at' => date('Y-m-d H:i:s')
				];
				$this->Item_model->create($insert);
				$this->session->set_flashdata('success', 'Item added successfully.');
				redirect('titipers/items');
			}
		}
		else
		{
			$data['title'] = 'Add Item';
			$data['events'] = $this->Event_model->get_all() ?: [];
			$this->load->view('templates/titipers/header', $data);
			$this->load->view('titipers/items_add', $data);
			$this->load->view('templates/titipers/footer');
		}
	}

	public function items_edit($id)
	{
		$user_id = $this->session->userdata('user_id');
		$data['item'] = $this->Item_model->get_by_id($id);

		if (empty($data['item']) || $data['item']['titipers_id'] != $user_id)
		{
			show_404();
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('name', 'Item Name', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('starting_price', 'Starting Price', 'required|numeric');
			$this->form_validation->set_rules('category', 'Category', 'required|trim');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Edit Item';
				$this->load->view('templates/titipers/header', $data);
				$this->load->view('titipers/items_edit', $data);
				$this->load->view('templates/titipers/footer');
			}
			else
			{
				$update = [
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'starting_price' => $this->input->post('starting_price'),
					'category' => $this->input->post('category'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				$config['upload_path'] = FCPATH . 'uploads/items/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size'] = 2048;
				$config['encrypt_name'] = TRUE;

				if (!is_dir($config['upload_path']))
				{
					mkdir($config['upload_path'], 0777, TRUE);
				}

				$this->upload->initialize($config);

				if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)
				{
					if (!$this->upload->do_upload('image'))
					{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect('titipers/items_edit/' . $id);
					}
					else
					{
						$upload_data = $this->upload->data();
						$update['image'] = $upload_data['file_name'];

						$old_image = FCPATH . 'uploads/items/' . $data['item']['image'];
						if (!empty($data['item']['image']) && file_exists($old_image))
						{
							unlink($old_image);
						}
					}
				}

				$this->Item_model->update($id, $update);
				$this->session->set_flashdata('success', 'Item updated successfully.');
				redirect('titipers/items');
			}
		}
		else
		{
			$data['title'] = 'Edit Item';
			$this->load->view('templates/titipers/header', $data);
			$this->load->view('titipers/items_edit', $data);
			$this->load->view('templates/titipers/footer');
		}
	}

	public function items_delete($id)
	{
		$user_id = $this->session->userdata('user_id');
		$item = $this->Item_model->get_by_id($id);

		if (empty($item) || $item['titipers_id'] != $user_id)
		{
			$this->session->set_flashdata('error', 'Item not found or unauthorized.');
			redirect('titipers/items');
		}

		if ($item['status'] !== 'available')
		{
			$this->session->set_flashdata('error', 'Only available items can be deleted.');
			redirect('titipers/items');
		}

		if (!empty($item['image']))
		{
			$image_path = FCPATH . 'uploads/items/' . $item['image'];
			if (file_exists($image_path))
			{
				unlink($image_path);
			}
		}

		$this->Item_model->delete($id);
		$this->session->set_flashdata('success', 'Item deleted successfully.');
		redirect('titipers/items');
	}

	public function events()
	{
		$data['title'] = 'Events';
		$data['events'] = $this->Event_model->get_all() ?: [];
		$this->load->view('templates/titipers/header', $data);
		$this->load->view('titipers/events', $data);
		$this->load->view('templates/titipers/footer');
	}

	public function events_submit($id)
	{
		$user_id = $this->session->userdata('user_id');
		$data['event'] = $this->Event_model->get_by_id($id);

		if (empty($data['event']))
		{
			show_404();
		}

		$all_items = $this->Item_model->get_by_titipers_id($user_id) ?: [];
		$data['available_items'] = array_filter($all_items, function ($item) {
			return $item['status'] === 'available';
		});

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('items[]', 'Items', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Submit Items to Event';
				$this->load->view('templates/titipers/header', $data);
				$this->load->view('titipers/events_submit', $data);
				$this->load->view('templates/titipers/footer');
			}
			else
			{
				$items = $this->input->post('items');
				foreach ($items as $item_id)
				{
					$this->Item_model->update($item_id, [
						'event_id' => $id,
						'status' => 'pending'
					]);
				}
				$this->session->set_flashdata('success', 'Items submitted to event successfully.');
				redirect('titipers/events');
			}
		}
		else
		{
			$data['title'] = 'Submit Items to Event';
			$this->load->view('templates/titipers/header', $data);
			$this->load->view('titipers/events_submit', $data);
			$this->load->view('templates/titipers/footer');
		}
	}

	public function shipping()
	{
		$data['title'] = 'Shipping';
		$user_id = $this->session->userdata('user_id');
		$data['shipping'] = $this->Shipping_model->get_by_titipers_id($user_id);
		$this->load->view('templates/titipers/header', $data);
		$this->load->view('titipers/shipping', $data);
		$this->load->view('templates/titipers/footer');
	}

	public function shipping_upload($id)
	{
		$user_id = $this->session->userdata('user_id');
		$data['shipping'] = $this->Shipping_model->get_by_id($id);

		if (empty($data['shipping']) || $data['shipping']['titipers_id'] != $user_id)
		{
			$this->session->set_flashdata('error', 'Shipping record not found or unauthorized.');
			redirect('titipers/shipping');
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$config['upload_path'] = FCPATH . 'uploads/shipping/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['max_size'] = 2048;
			$config['encrypt_name'] = TRUE;

			if (!is_dir($config['upload_path']))
			{
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('shipping_proof'))
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('titipers/shipping_upload/' . $id);
			}
			else
			{
				$upload_data = $this->upload->data();
				$this->Shipping_model->update($id, [
					'shipping_proof' => $upload_data['file_name'],
					'status' => 'shipped',
					'shipped_at' => date('Y-m-d H:i:s')
				]);

				$this->Notification_model->create(
					$data['shipping']['bidders_id'],
					'Item Shipped',
					'Your item has been shipped. Tracking info uploaded.',
					'titipers/shipping'
				);

				$this->session->set_flashdata('success', 'Shipping proof uploaded successfully.');
				redirect('titipers/shipping');
			}
		}
		else
		{
			$data['title'] = 'Upload Shipping Proof';
			$this->load->view('templates/titipers/header', $data);
			$this->load->view('titipers/shipping_upload', $data);
			$this->load->view('templates/titipers/footer');
		}
	}

	public function notifications()
	{
		$data['title'] = 'Notifications';
		$user_id = $this->session->userdata('user_id');
		$data['notifications'] = $this->Notification_model->get_by_user_id($user_id);
		$this->load->view('templates/titipers/header', $data);
		$this->load->view('titipers/notifications', $data);
		$this->load->view('templates/titipers/footer');
	}

	public function profile()
	{
		$user_id = $this->session->userdata('user_id');
		$this->load->model('User_model');

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			if ($this->input->post('change_password') === '1')
			{
				$this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

				if ($this->form_validation->run() === FALSE)
				{
					$data['title'] = 'My Profile';
					$data['user'] = $this->User_model->get_by_id($user_id);
					$this->load->view('templates/titipers/header', $data);
					$this->load->view('titipers/profile', $data);
					$this->load->view('templates/titipers/footer');
				}
				else
				{
					$this->User_model->change_password($user_id, $this->input->post('new_password'));
					$this->session->set_flashdata('success', 'Password updated successfully.');
					redirect('titipers/profile');
				}
			}
			else
			{
				$this->form_validation->set_rules('name', 'Name', 'required|trim');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
				$this->form_validation->set_rules('phone', 'Phone', 'trim');
				$this->form_validation->set_rules('address', 'Address', 'trim');

				if ($this->form_validation->run() === FALSE)
				{
					$data['title'] = 'My Profile';
					$data['user'] = $this->User_model->get_by_id($user_id);
					$this->load->view('templates/titipers/header', $data);
					$this->load->view('titipers/profile', $data);
					$this->load->view('templates/titipers/footer');
				}
				else
				{
					$update = [
						'name'    => $this->input->post('name'),
						'email'   => $this->input->post('email'),
						'phone'   => $this->input->post('phone'),
						'address' => $this->input->post('address'),
					];

					if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK)
					{
						$config['upload_path'] = FCPATH . 'uploads/avatars/';
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['max_size'] = 2048;
						$config['encrypt_name'] = TRUE;

						if (!is_dir($config['upload_path']))
						{
							mkdir($config['upload_path'], 0777, TRUE);
						}

						$this->upload->initialize($config);

						if ($this->upload->do_upload('avatar'))
						{
							$upload_data = $this->upload->data();
							$update['avatar'] = $upload_data['file_name'];

							$user = $this->User_model->get_by_id($user_id);
							if (!empty($user['avatar']))
							{
								$old_avatar = FCPATH . 'uploads/avatars/' . $user['avatar'];
								if (file_exists($old_avatar))
								{
									unlink($old_avatar);
								}
							}
						}
					}

					$this->User_model->update_profile($user_id, $update);
					$this->session->set_flashdata('success', 'Profile updated successfully.');
					redirect('titipers/profile');
				}
			}
		}
		else
		{
			$data['title'] = 'My Profile';
			$data['user'] = $this->User_model->get_by_id($user_id);
			$this->load->view('templates/titipers/header', $data);
			$this->load->view('titipers/profile', $data);
			$this->load->view('templates/titipers/footer');
		}
	}
}
