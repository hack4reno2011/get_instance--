<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}

	public function result_set()
	{
		@$zip = $this->input->post("zip_code");
		@$station = $this->input->post("station_number");
		if ($zip) {
			$q = $this->db->from("stations")->where("station_zip", $zip)->get();
		} elseif ($station) {
			$q = $this->db->from("stations")->where("station_num", $station)->get();
		} else {
			$this->session->set_flashdata("error", "I am not able to search without search criteria");
			redirect("");
			exit();
		}
		
		$this->load->view('result_set');
	}
}