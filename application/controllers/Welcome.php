<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Event_model', 'Item_model', 'Contact_model']);
		$this->load->helper(['url', 'form']);
		$this->load->library(['session', 'form_validation']);
	}

	public function index()
	{
		$data['title'] = 'Home';
		$data['carousel_events'] = $this->Event_model->get_active_events() ?: [];
		$all_items = $this->Item_model->get_all();
		if (empty($all_items)) {
			$data['active_items'] = [];
		} else {
			$data['active_items'] = array_slice($all_items, 0, 12);
		}
		$data['active_events'] = $this->Event_model->get_active_events() ?: [];
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();
		$this->load->view('welcome_header', $data);
		$this->load->view('home', $data);
		$this->load->view('welcome_footer');
	}

	public function about()
	{
		$data['title'] = 'About';
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();
		$this->load->view('about', $data);
	}

	public function contact()
	{
		$data['title'] = 'Contact Us';
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();
		$this->load->view('contact', $data);
	}

	public function contact_submit()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('subject', 'Subject', 'required|trim');
		$this->form_validation->set_rules('message', 'Message', 'required|trim');

		if ($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('contact');
		}
		else
		{
			$insert = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'subject' => $this->input->post('subject'),
				'message' => $this->input->post('message'),
				'created_at' => date('Y-m-d H:i:s')
			];
			$this->Contact_model->create($insert);
			$this->session->set_flashdata('success', 'Your message has been sent successfully.');
			redirect('contact');
		}
	}

	public function events()
	{
		$data['title'] = 'Events';
		$data['events'] = $this->Event_model->get_all();
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();
		$this->load->view('welcome_header', $data);
		$this->load->view('event_list', $data);
		$this->load->view('welcome_footer');
	}

	public function event_detail($id)
	{
		$data['title'] = 'Event Detail';
		$data['event'] = $this->Event_model->get_event_detail($id);
		if (empty($data['event']))
		{
			show_404();
		}
		$data['items'] = $this->Item_model->get_by_event_id($id) ?: [];
		$data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$data['csrf_hash'] = $this->security->get_csrf_hash();
		$this->load->view('welcome_header', $data);
		$this->load->view('event_detail', $data);
		$this->load->view('welcome_footer');
	}
}
