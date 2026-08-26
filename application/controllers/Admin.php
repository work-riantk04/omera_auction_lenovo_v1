<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin')
		{
			$this->session->set_flashdata('error', 'You must be logged in as admin.');
			redirect('auth/login');
		}
		$this->load->model(['Event_model', 'Item_model', 'Invoice_model', 'Shipping_model', 'User_model', 'Notification_model', 'Disbursement_model']);
		$this->load->helper(['url', 'form']);
		$this->load->library(['session', 'form_validation', 'upload']);
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		$data['title'] = 'Admin Dashboard';
		$events = $this->Event_model->get_all();
		$items = $this->Item_model->get_all();
		$invoices = $this->Invoice_model->get_all();
		$data['total_events'] = count($events);
		$data['total_items'] = count($items);
		$data['total_users'] = $this->User_model->count_all();
		$data['total_revenue'] = array_sum(array_column($invoices, 'total_amount'));
		$data['recent_events'] = array_slice($events, 0, 5);
		$data['pending_invoices'] = count(array_filter($invoices, function ($inv) {
			return $inv['payment_status'] === 'pending';
		}));
		$this->load->view('admin/header', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/footer');
	}

	public function events()
	{
		$data['title'] = 'Manage Events';
		$data['events'] = $this->Event_model->get_all();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/events', $data);
		$this->load->view('admin/footer');
	}

	public function events_create()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('name', 'Event Name', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('end_date', 'End Date', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Create Event';
				$this->load->view('admin/header', $data);
				$this->load->view('admin/events_create', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$insert = [
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'start_date' => $this->input->post('start_date'),
					'end_date' => $this->input->post('end_date'),
					'status' => $this->input->post('status'),
					'created_at' => date('Y-m-d H:i:s')
				];
				$this->Event_model->create($insert);
				$this->session->set_flashdata('success', 'Event created successfully.');
				redirect('admin/events');
			}
		}
		else
		{
			$data['title'] = 'Create Event';
			$this->load->view('admin/header', $data);
			$this->load->view('admin/events_create', $data);
			$this->load->view('admin/footer');
		}
	}

	public function events_edit($id)
	{
		$data['event'] = $this->Event_model->get_by_id($id);
		if (empty($data['event']))
		{
			show_404();
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('name', 'Event Name', 'required|trim');
			$this->form_validation->set_rules('description', 'Description', 'required|trim');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('end_date', 'End Date', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Edit Event';
				$this->load->view('admin/header', $data);
				$this->load->view('admin/events_edit', $data);
				$this->load->view('admin/footer');
			}
			else
			{
				$update = [
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
					'start_date' => $this->input->post('start_date'),
					'end_date' => $this->input->post('end_date'),
					'status' => $this->input->post('status'),
					'updated_at' => date('Y-m-d H:i:s')
				];
				$this->Event_model->update($id, $update);
				$this->session->set_flashdata('success', 'Event updated successfully.');
				redirect('admin/events');
			}
		}
		else
		{
			$data['title'] = 'Edit Event';
			$this->load->view('admin/header', $data);
			$this->load->view('admin/events_edit', $data);
			$this->load->view('admin/footer');
		}
	}

	public function events_status($id)
	{
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[collecting,verifying,active,completed,cancelled]');
		if ($this->form_validation->run() !== FALSE)
		{
			$status = $this->input->post('status');
			$this->Event_model->update_status($id, $status);

			if ($status === 'active')
			{
				$this->Invoice_model->generate_for_winners($id);
			}

			$this->session->set_flashdata('success', 'Event status updated.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid status.');
		}
		redirect('admin/events');
	}

	public function items()
	{
		$data['title'] = 'Manage Items';
		$data['items'] = $this->Item_model->get_all();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/items', $data);
		$this->load->view('admin/footer');
	}

	public function items_verify($id)
	{
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[approved,rejected]');
		$this->form_validation->set_rules('admin_note', 'Admin Note', 'trim');

		if ($this->form_validation->run() !== FALSE)
		{
			$status = $this->input->post('status');
			$admin_note = $this->input->post('admin_note');

			if ($status === 'approved')
			{
				$this->Item_model->approve($id, $admin_note);
			}
			else
			{
				$this->Item_model->reject($id, $admin_note);
			}

			$item = $this->Item_model->get_by_id($id);
			$this->Notification_model->create(
				$item['titipers_id'],
				'Item ' . ucfirst($status),
				'Your item "' . $item['name'] . '" has been ' . $status . '.',
				'admin/items'
			);

			$this->session->set_flashdata('success', 'Item verification updated.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid verification data.');
		}
		redirect('admin/items');
	}

	public function invoices()
	{
		$data['title'] = 'Manage Invoices';
		$data['invoices'] = $this->Invoice_model->get_all();
		$data['events'] = $this->Event_model->get_all();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/invoices', $data);
		$this->load->view('admin/footer');
	}

	public function invoices_generate($event_id)
	{
		$result = $this->Invoice_model->generate_for_winners($event_id);
		if ($result)
		{
			$this->session->set_flashdata('success', 'Invoices generated successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Failed to generate invoices or no winning bids found.');
		}
		redirect('admin/invoices');
	}

	public function invoices_verify_payment($id)
	{
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[verified,rejected]');

		if ($this->form_validation->run() !== FALSE)
		{
			$status = $this->input->post('status');

			if ($status === 'verified')
			{
				$this->Invoice_model->verify_payment($id);
			}
			else
			{
				$this->Invoice_model->reject_payment($id);
			}

			$invoice = $this->Invoice_model->get_by_id($id);
			$this->Notification_model->create(
				$invoice['bidders_id'],
				'Payment ' . ucfirst($status),
				'Your payment for invoice #' . $id . ' has been ' . $status . '.',
				'admin/invoices'
			);

			$this->session->set_flashdata('success', 'Payment status updated.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid status.');
		}
		redirect('admin/invoices');
	}

	public function shipping()
	{
		$data['title'] = 'Manage Shipping';
		$data['shipping'] = $this->Shipping_model->get_all();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/shipping', $data);
		$this->load->view('admin/footer');
	}

	public function shipping_verify($id)
	{
		$this->form_validation->set_rules('status', 'Status', 'required|in_list[in_transit,delivered]');

		if ($this->form_validation->run() !== FALSE)
		{
			$status = $this->input->post('status');

			if ($status === 'delivered')
			{
				$this->Shipping_model->verify_delivery($id);
			}
			else
			{
				$this->Shipping_model->update($id, ['status' => $status]);
			}

			$shipping = $this->Shipping_model->get_by_id($id);
			$this->Notification_model->create(
				$shipping['bidders_id'],
				'Shipping ' . ucfirst(str_replace('_', ' ', $status)),
				'Your shipment has been updated to: ' . $status . '.',
				'admin/shipping'
			);

			$this->session->set_flashdata('success', 'Shipping status updated.');
		}
		else
		{
			$this->session->set_flashdata('error', 'Invalid status.');
		}
		redirect('admin/shipping');
	}

	public function disbursements()
	{
		$data['title'] = 'Manage Disbursements';
		$data['disbursements'] = $this->Disbursement_model->get_all();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/disbursements', $data);
		$this->load->view('admin/footer');
	}

	public function disbursements_process($id)
	{
		$this->Disbursement_model->process($id);

		$disbursement = $this->Disbursement_model->get_by_id($id);
		$this->Notification_model->create(
			$disbursement['titipers_id'],
			'Disbursement Processed',
			'Your disbursement has been processed.',
			'admin/disbursements'
		);

		$this->session->set_flashdata('success', 'Disbursement processed.');
		redirect('admin/disbursements');
	}

	public function users()
	{
		$data['title'] = 'Manage Users';
		$data['users'] = $this->User_model->get_all();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('admin/footer');
	}

	public function users_toggle($id)
	{
		$user = $this->User_model->get_by_id($id);
		if ($user)
		{
			$is_active = $this->input->post('is_active');
			$this->User_model->update_profile($id, ['is_active' => $is_active]);
			$status = $is_active ? 'activated' : 'deactivated';
			$this->session->set_flashdata('success', 'User ' . $status . ' successfully.');
		}
		else
		{
			$this->session->set_flashdata('error', 'User not found.');
		}
		redirect('admin/users');
	}

	public function notifications()
	{
		$data['title'] = 'Notifications';
		$user_id = $this->session->userdata('user_id');
		$data['notifications'] = $this->Notification_model->get_by_user_id($user_id);
		$this->load->view('admin/header', $data);
		$this->load->view('admin/notifications', $data);
		$this->load->view('admin/footer');
	}

	public function notifications_read($id)
	{
		$this->Notification_model->mark_as_read($id);
		redirect('admin/notifications');
	}

	public function notifications_mark_all()
	{
		$user_id = $this->session->userdata('user_id');
		$this->Notification_model->mark_all_as_read($user_id);
		$this->session->set_flashdata('success', 'All notifications marked as read.');
		redirect('admin/notifications');
	}
}
