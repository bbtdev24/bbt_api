<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basic_auth
{
	private $valid_username = "admin";
	private $valid_password = "Dev24";

	public function authenticate()
	{
		$CI = &get_instance();

		// Jika sudah login (sudah ada session), lewati autentikasi
		if ($CI->session->userdata('logged_in') === TRUE) {
			return; // Sudah login, lanjutkan eksekusi
		}

		$controller = $CI->router->fetch_class();
		$method = $CI->router->fetch_method();

		// Periksa header Authorization
		$authHeader = $CI->input->get_request_header('Authorization');

		if ($authHeader && strpos($authHeader, 'Basic ') === 0) {
			$encoded_credentials = substr($authHeader, 6);
			$decoded_credentials = base64_decode($encoded_credentials);

			list($username, $password) = explode(':', $decoded_credentials);

			// Validasi username dan password
			if ($username === $this->valid_username && $password === $this->valid_password) {
				// Set session sebagai sudah login
				$CI->session->set_userdata('logged_in', TRUE);
				return; // Autentikasi berhasil, lanjutkan eksekusi
			}
		}

		// Jika otentikasi gagal, kirimkan header untuk memunculkan pop-up
		header('WWW-Authenticate: Basic realm="My Secure Area"');
		header('HTTP/1.0 401 Unauthorized');
		echo 'Authentication is required to access this resource.';
		exit;
	}

	// Fungsi untuk logout (hapus session)
	public function logout()
	{
		$CI = &get_instance();
		$CI->session->unset_userdata('logged_in');
		// Redirect atau beri pesan logout
	}
}
