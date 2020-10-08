<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class UnitController extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('M_unit');
    }
	
	public function unit() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Daftar Unit';
                $data['main_view'] = 'admin/unit';
				$data['data_unit'] = $this->M_unit->get_unit();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_unit() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
                $this->form_validation->set_rules('level', 'Level', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_unit->tambah_unit() == true) {
                        $this->session->set_flashdata('notif', 'Tambah unit berhasil!');
                        redirect('home/unit');
                    } else {
                        $this->session->set_flashdata('notif', 'Tambah unit gagal!');
                        redirect('home/unit');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/unit');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_unit() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('ubah_nama', 'Nama', 'trim|required');
                $this->form_validation->set_rules('ubah_level', 'Level', 'trim|required');
                
                if ($this->form_validation->run() == true) {
                    if ($this->M_unit->ubah_unit() == true) {
                        $this->session->set_flashdata('notif', 'Ubah unit Berhasil!');
                        redirect('home/unit');
                    } else {
                        $this->session->set_flashdata('notif', 'Ubah unit Gagal!');
                        redirect('home/unit');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/unit');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_unit($id_unit) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                if ($this->M_unit->hapus_unit($id_unit) == true) {
                    $this->session->set_flashdata('notif', 'Hapus unit Berhasil!');
                    redirect('home/unit');
                } else {
                    $this->session->set_flashdata('notif', 'Hapus unit Gagal!');
                    redirect('home/unit');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function get_unit_by_id($id_unit) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data_unit_by_id = $this->M_unit->get_unit_by_id($id_unit);
                echo json_encode($data_unit_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    
	}
}