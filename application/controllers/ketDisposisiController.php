<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class ketDisposisiController extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('M_ketdisposisi');
    }
	
	public function ketdisposisi() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Keterangan Disposisi';
                $data['main_view'] = 'admin/ketdisposisi';
				$data['data_disposisi'] = $this->M_ketdisposisi->get_ketdisposisi();
				$this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function get_ketdisposisi_by_id($id) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data_ketdisposisi_by_id = $this->M_ketdisposisi->get_ketdisposisi_by_id($id);
                echo json_encode($data_ketdisposisi_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_ketdisposisi() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('ubah_nama', 'Nama', 'trim|required');
                
                if ($this->form_validation->run() == true) {
                    if ($this->M_ketdisposisi->ubah_ketdisposisi() == true) {
                        $this->session->set_flashdata('notif', 'Ubah Ket. Disposisi Berhasil!');
                        redirect('home/ketdisposisi');
                    } else {
                        $this->session->set_flashdata('notif', 'Ubah Ket. Disposisi Gagal!');
                        redirect('home/ketdisposisi');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/ketdisposisi');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_ketdisposisi($id) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                if ($this->M_ketdisposisi->hapus_ketdisposisi($id) == true) {
                    $this->session->set_flashdata('notif', 'Hapus Ket. Disposisi Berhasil!');
                    redirect('home/ketdisposisi');
                } else {
                    $this->session->set_flashdata('notif', 'Hapus Ket. Disposisi Gagal!');
                    redirect('home/ketdisposisi');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
}