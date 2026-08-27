<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidders extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'bidders')
		{
			$this->session->set_flashdata('error', 'You must be logged in as bidder.');
			redirect('auth/login');
		}
		$this->load->model(['Bid_model', 'Event_model', 'Item_model', 'Invoice_model', 'Notification_model']);
		$this->load->helper(['url', 'form']);
		$this->load->library(['session', 'form_validation', 'upload']);
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		$data['title'] = 'Bidder Dashboard';
		$user_id = $this->session->userdata('user_id');
		$my_bids = $this->Bid_model->get_by_bidder_id($user_id) ?: [];
		$my_invoices = $this->Invoice_model->get_by_bidder_id($user_id) ?: [];
		$data['total_bids'] = count($my_bids);
		$data['won_auctions'] = count($my_invoices);
		$data['total_spent'] = array_sum(array_column($my_invoices, 'total_amount'));
		$data['pending_payments'] = count(array_filter($my_invoices, function ($inv) {
			return $inv['payment_status'] === 'pending';
		}));
		$data['active_events'] = array_slice($this->Event_model->get_active_events() ?: [], 0, 5);
		$this->load->view('templates/bidders/header', $data);
		$this->load->view('bidders/dashboard', $data);
		$this->load->view('templates/bidders/footer');
	}

	public function events()
	{
		$data['title'] = 'Auction Events';
		$data['events'] = $this->Event_model->get_active_events();
		$this->load->view('templates/bidders/header', $data);
		$this->load->view('bidders/events', $data);
		$this->load->view('templates/bidders/footer');
	}

	public function event_bid($event_id)
	{
		$data['title'] = 'Bid Now';
		$data['event'] = $this->Event_model->get_by_id($event_id);

		if (empty($data['event']) || $data['event']['status'] !== 'active')
		{
			$this->session->set_flashdata('error', 'This event is not active for bidding.');
			redirect('bidders/events');
		}

		$user_id = $this->session->userdata('user_id');
		$data['items'] = $this->Item_model->get_by_event_id($event_id);
		$all_user_bids = $this->Bid_model->get_by_bidder_id($user_id);
		$item_ids = array_column($data['items'], 'id');
		$data['user_bids'] = array_filter($all_user_bids, function ($bid) use ($item_ids) {
			return in_array($bid['item_id'], $item_ids);
		});
		$this->load->view('templates/bidders/header', $data);
		$this->load->view('bidders/event_bid', $data);
		$this->load->view('templates/bidders/footer');
	}

	public function bid()
	{
		$this->form_validation->set_rules('item_id', 'Item', 'required|integer');
		$this->form_validation->set_rules('amount', 'Bid Amount', 'required|numeric');

		if ($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('error', 'Invalid bid data.');
			redirect($this->input->server('HTTP_REFERER'));
		}
		else
		{
			$item_id = $this->input->post('item_id');
			$amount = $this->input->post('amount');
			$user_id = $this->session->userdata('user_id');

			$item = $this->Item_model->get_by_id($item_id);
			if (empty($item) || $item['status'] !== 'approved')
			{
				$this->session->set_flashdata('error', 'Item is not available for bidding.');
				redirect($this->input->server('HTTP_REFERER'));
			}

			$highest_bid = $this->Bid_model->get_highest_bid($item_id);
			$min_bid = $highest_bid ? $highest_bid['amount'] + 1 : $item['starting_price'];

			if ($amount < $min_bid)
			{
				$this->session->set_flashdata('error', 'Bid must be at least Rp ' . number_format($min_bid, 0, ',', '.'));
				redirect($this->input->server('HTTP_REFERER'));
			}

			$this->Bid_model->place_bid($item['event_id'], $item_id, $user_id, $amount);

			$this->session->set_flashdata('success', 'Bid placed successfully.');
			redirect($this->input->server('HTTP_REFERER'));
		}
	}

	public function invoices()
	{
		$data['title'] = 'My Invoices';
		$user_id = $this->session->userdata('user_id');
		$data['invoices'] = $this->Invoice_model->get_by_bidder_id($user_id);
		$this->load->view('templates/bidders/header', $data);
		$this->load->view('bidders/invoices', $data);
		$this->load->view('templates/bidders/footer');
	}

	public function invoices_detail($id)
	{
		$user_id = $this->session->userdata('user_id');
		$data['invoice'] = $this->Invoice_model->get_by_id($id);

		if (empty($data['invoice']) || $data['invoice']['bidders_id'] != $user_id)
		{
			$this->session->set_flashdata('error', 'Invoice not found or unauthorized.');
			redirect('bidders/invoices');
		}

		$data['title'] = 'Invoice #' . $id;
		$data['items'] = $this->Item_model->get_by_event_id($data['invoice']['event_id']);
		$this->load->view('templates/bidders/header', $data);
		$this->load->view('bidders/invoices_detail', $data);
		$this->load->view('templates/bidders/footer');
	}

	public function invoices_upload_payment($id)
	{
		$user_id = $this->session->userdata('user_id');
		$invoice = $this->Invoice_model->get_by_id($id);

		if (empty($invoice) || $invoice['bidders_id'] != $user_id)
		{
			$this->session->set_flashdata('error', 'Invoice not found or unauthorized.');
			redirect('bidders/invoices');
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$config['upload_path'] = FCPATH . 'uploads/payments/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
			$config['max_size'] = 2048;
			$config['encrypt_name'] = TRUE;

			if (!is_dir($config['upload_path']))
			{
				mkdir($config['upload_path'], 0777, TRUE);
			}

			$this->upload->initialize($config);

			if (!$this->upload->do_upload('payment_proof'))
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('bidders/invoices_upload_payment/' . $id);
			}
			else
			{
				$upload_data = $this->upload->data();
				$this->Invoice_model->update($id, [
					'payment_proof' => $upload_data['file_name'],
					'payment_status' => 'pending',
					'uploaded_at' => date('Y-m-d H:i:s')
				]);

				$this->Notification_model->create(
					1,
					'Payment Uploaded',
					'Payment proof uploaded for invoice #' . $id . '.',
					'admin/invoices'
				);

				$this->session->set_flashdata('success', 'Payment proof uploaded. Waiting for admin verification.');
				redirect('bidders/invoices_detail/' . $id);
			}
		}
		else
		{
			$data['title'] = 'Upload Payment Proof';
			$data['invoice'] = $invoice;
			$this->load->view('templates/bidders/header', $data);
			$this->load->view('bidders/invoices_upload_payment', $data);
			$this->load->view('templates/bidders/footer');
		}
	}

	public function notifications()
	{
		$data['title'] = 'Notifications';
		$user_id = $this->session->userdata('user_id');
		$data['notifications'] = $this->Notification_model->get_by_user_id($user_id);
		$this->load->view('templates/bidders/header', $data);
		$this->load->view('bidders/notifications', $data);
		$this->load->view('templates/bidders/footer');
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
					$this->load->view('templates/bidders/header', $data);
					$this->load->view('bidders/profile', $data);
					$this->load->view('templates/bidders/footer');
				}
				else
				{
					$this->User_model->change_password($user_id, $this->input->post('new_password'));
					$this->session->set_flashdata('success', 'Password updated successfully.');
					redirect('bidders/profile');
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
					$this->load->view('templates/bidders/header', $data);
					$this->load->view('bidders/profile', $data);
					$this->load->view('templates/bidders/footer');
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
					redirect('bidders/profile');
				}
			}
		}
		else
		{
			$data['title'] = 'My Profile';
			$data['user'] = $this->User_model->get_by_id($user_id);
			$this->load->view('templates/bidders/header', $data);
			$this->load->view('bidders/profile', $data);
			$this->load->view('templates/bidders/footer');
		}
	}
}
