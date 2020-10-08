<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class DashboardController extends CI_Controller {

    public function __construct() {
        parent::__construct();
		 $this->load->model('M_login');
        $this->load->model('M_surat');
		$this->load->model('M_memo');
		$this->load->model('M_disposisi');
		$this->load->model('M_disposisimemo');
    }

    public function index() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Selamat Datang, ' . $this->session->userdata('nama_pegawai') . '!';
                $data['jumlah_surat'] = $this->M_surat->get_jumlah_surat();
                $data['main_view'] = 'admin/dashboard';
                $data['jumlah_memo'] = $this->M_memo->get_jumlah_memo();
                $data['main_view'] = 'admin/dashboard';
                $this->load->view('template', $data);
            } else {
                $data['judul'] = 'Selamat Datang, ' . $this->session->userdata('nama_pegawai') . '!';
                $data['jumlah_disposisi'] = $this->M_disposisi->get_jumlah_disposisi();
				$data['jumlah_disposisi_memo'] = $this->M_disposisimemo->get_jumlah_disposisi_memo();
                $data['main_view'] = 'pegawai/dashboard';
                $this->load->view('template', $data);
            }
        } else {
            redirect('LoginController');
        }
    }
}