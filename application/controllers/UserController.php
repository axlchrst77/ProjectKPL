<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('M_pegawai');
		$this->load->model('M_unit');
    }
	
	public function user() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Daftar User';
                $data['main_view'] = 'admin/user';
				$data['drop_down_unit'] = $this->M_unit->get_unit();
                $data['data_user'] = $this->M_pegawai->get_pegawai();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_user() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
				$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
                $this->form_validation->set_rules('nik', 'NIK', 'trim|required');
                $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
                $this->form_validation->set_rules('unit', 'unit', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_pegawai->tambah_user() == true) {
                        $this->session->set_flashdata('notif', 'Tambah User berhasil!');
                        redirect('home/user');
                    } else {
                        $this->session->set_flashdata('notif', 'Tambah User gagal!');
                        redirect('home/user');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/user');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_user() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
				$this->form_validation->set_rules('ubah_nip', 'NIP', 'trim|required');
                $this->form_validation->set_rules('ubah_nik', 'NIK', 'trim|required');
                $this->form_validation->set_rules('ubah_nama', 'Nama', 'trim|required');
                $this->form_validation->set_rules('ubah_unit', 'unit', 'trim|required');
                
                if ($this->form_validation->run() == true) {
                    if ($this->M_pegawai->ubah_user() == true) {
                        $this->session->set_flashdata('notif', 'Ubah User Berhasil!');
                        redirect('home/user');
                    } else {
                        $this->session->set_flashdata('notif', 'Ubah User Gagal!');
                        redirect('home/user');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/user');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_user($id_user) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                if ($this->M_pegawai->hapus_user($id_user) == true) {
                    $this->session->set_flashdata('notif', 'Hapus User Berhasil!');
                    redirect('home/user');
                } else {
                    $this->session->set_flashdata('notif', 'Hapus User Gagal!');
                    redirect('home/user');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function get_user_by_id($id_user) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data_user_by_id = $this->M_pegawai->get_pegawai_by_id($id_user);
                echo json_encode($data_user_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	    public function get_pegawai_by_unit($id_unit) {
        if ($this->session->userdata('logged_in') == true) {
            $data_pegawai_by_id_unit = $this->M_pegawai->get_pegawai_by_unit($id_unit);
            echo json_encode($data_pegawai_by_id_unit);
        } else {
            redirect('login');
        }
    }
	
}