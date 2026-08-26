<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->helper(['url', 'form']);
		$this->load->library(['session', 'form_validation']);
	}

	public function index()
	{
		$this->login();
	}

	public function login()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Login';
				$this->load->view('templates/header', $data);
				$this->load->view('auth/login', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$user = $this->User_model->login($email, $password);

				if ($user)
				{
					$session_data = [
						'user_id' => $user['id'],
						'name' => $user['name'],
						'email' => $user['email'],
						'role' => $user['role'],
						'logged_in' => TRUE
					];
					$this->session->set_userdata($session_data);

					if ($user['role'] === 'admin')
					{
						redirect('admin');
					}
					elseif ($user['role'] === 'titipers')
					{
						redirect('titipers');
					}
					else
					{
						redirect('bidders');
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'Invalid email or password.');
					redirect('auth/login');
				}
			}
		}
		else
		{
			$data['title'] = 'Login';
			$this->load->view('templates/header', $data);
			$this->load->view('auth/login', $data);
			$this->load->view('templates/footer');
		}
	}

	public function register()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('name', 'Name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
			$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
			$this->form_validation->set_rules('role', 'Role', 'required|in_list[titipers,bidders]');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Register';
				$this->load->view('templates/header', $data);
				$this->load->view('auth/register', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$insert = [
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'password' => $this->input->post('password'),
					'phone' => $this->input->post('phone'),
					'role' => $this->input->post('role'),
				];
				$this->User_model->register($insert);
				$this->session->set_flashdata('success', 'Registration successful. Please login.');
				redirect('auth/login');
			}
		}
		else
		{
			$data['title'] = 'Register';
			$this->load->view('templates/header', $data);
			$this->load->view('auth/register', $data);
			$this->load->view('templates/footer');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('/'));
	}

	public function reset_password()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Reset Password';
				$this->load->view('templates/header', $data);
				$this->load->view('auth/reset_password', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$email = $this->input->post('email');
				$token = $this->User_model->generate_reset_token($email);

				if ($token)
				{
					$reset_link = site_url('auth/reset_password_process/' . $token);
				}

				$this->session->set_flashdata('success', 'If your email is registered, you will receive a reset link.');
				redirect('auth/reset_password');
			}
		}
		else
		{
			$data['title'] = 'Reset Password';
			$this->load->view('templates/header', $data);
			$this->load->view('auth/reset_password', $data);
			$this->load->view('templates/footer');
		}
	}

	public function reset_password_process($token)
	{
		$user = $this->User_model->check_reset_token($token);

		if (!$user)
		{
			$this->session->set_flashdata('error', 'Invalid or expired reset token.');
			redirect('auth/reset_password');
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

			if ($this->form_validation->run() === FALSE)
			{
				$data['title'] = 'Reset Password';
				$data['token'] = $token;
				$this->load->view('templates/header', $data);
				$this->load->view('auth/reset_password_form', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$new_password = $this->input->post('password');
				$this->User_model->reset_password($token, $new_password);
				$this->session->set_flashdata('success', 'Password has been reset. Please login.');
				redirect('auth/login');
			}
		}
		else
		{
			$data['title'] = 'Reset Password';
			$data['token'] = $token;
			$this->load->view('templates/header', $data);
			$this->load->view('auth/reset_password_form', $data);
			$this->load->view('templates/footer');
		}
	}

	public function is_logged_in()
	{
		return $this->session->userdata('logged_in') === TRUE;
	}

	public function is_admin()
	{
		return $this->is_logged_in() && $this->session->userdata('role') === 'admin';
	}

	public function is_titipers()
	{
		return $this->is_logged_in() && $this->session->userdata('role') === 'titipers';
	}

	public function is_bidders()
	{
		return $this->is_logged_in() && $this->session->userdata('role') === 'bidders';
	}
}
