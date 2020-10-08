<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MemoController extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('M_memo');
    }
	
	public function memo_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Memo Masuk';
                $data['main_view'] = 'admin/memo_masuk';
                $data['data_memo_masuk'] = $this->M_memo->get_memo_masuk();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	 public function memo_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Memo Keluar';
                $data['main_view'] = 'admin/memo_keluar';
                $data['data_memo_keluar'] = $this->M_memo->get_memo_keluar();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_memo_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('nomor_memo', 'Nomor memo', 'trim|required');
                $this->form_validation->set_rules('tgl_kirim', 'Tanggal Kirim', 'trim|date|required');
                $this->form_validation->set_rules('tgl_terima', 'Tanggal Terima', 'trim|date|required');
                $this->form_validation->set_rules('pengirim', 'Pengirim', 'trim|required');
                $this->form_validation->set_rules('penerima', 'Penerima', 'trim|required');
                $this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 2000000;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file_memo')) {
                        if ($this->M_memo->tambah_memo_masuk($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Tambah memo Berhasil!');
                            redirect('home/memo_masuk');
                        } else {
                            $this->session->set_flashdata('notif', 'Tambah memo Berhasil!');
                            redirect('home/memo_masuk');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/memo_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/memo_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_memo_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('nomor_memo', 'Nomor memo', 'trim|required');
                $this->form_validation->set_rules('tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('tujuan', 'Tujuan', 'trim|required');
                $this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 2000000;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file_memo')) {
                        if ($this->M_memo->tambah_memo_keluar($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Tambah memo Keluar Berhasil!');
                            redirect('home/memo_keluar');
                        } else {
                            $this->session->set_flashdata('notif', 'Tambah memo Gagal!');
                            redirect('home/memo_keluar');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/memo_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/memo_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_memo_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('ubah_nomor_memo', 'Nomor memo', 'trim|required');
                $this->form_validation->set_rules('ubah_tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('ubah_tgl_terima', "Tanggal Terima", 'trim|required');
                $this->form_validation->set_rules('ubah_pengirim', 'Pengirim', 'trim|required');
                $this->form_validation->set_rules('ubah_penerima', 'Penerima', 'trim|required');
                $this->form_validation->set_rules('ubah_perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_memo->ubah_memo_masuk() == true) {
                        $this->session->set_flashdata('notif', 'Update memo Masuk Berhasil!');
                        redirect('home/memo_masuk');
                    } else {
                        $this->session->set_flashdata('notif', 'Update memo Masuk Gagal!');
                        redirect('home/memo_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/memo_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_memo_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('ubah_nomor_memo', 'Nomor memo', 'trim|required');
                $this->form_validation->set_rules('ubah_tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('ubah_tujuan', 'Tujuan', 'trim|required');
                $this->form_validation->set_rules('ubah_perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_memo->ubah_memo_keluar() == true) {
                        $this->session->set_flashdata('notif', 'Ubah memo Keluar Berhasil!');
                        redirect('home/memo_keluar');
                    } else {
                        $this->session->set_flashdata('notif', 'Ubah memo Keluar Gagal!');
                        redirect('home/memo_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/memo_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_file_memo_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2000000;
                $this->load->library('upload', $config);
                $path = './uploads/' . $this->M_memo->get_nama_file_memo_masuk($this->input->post('ubah_file_memo'));

                if (unlink($path)) {
                    if ($this->upload->do_upload('ubah_file_memo')) {
                        if ($this->M_memo->ubah_file_memo_masuk($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Ubah file memo masuk berhasil!');
                            redirect('home/memo_masuk');
                        } else {
                            $this->session->set_flashdata('notif', 'Ubah file memo masuk gagal!');
                            redirect('home/memo_masuk');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/memo_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/memo_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_file_memo_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2000000;
                $this->load->library('upload', $config);
                $path = './uploads/' . $this->M_memo->get_nama_file_memo_keluar($this->input->post('ubah_file_memo'));
                if (unlink($path)) {
                    if ($this->upload->do_upload('ubah_file_memo')) {
                        if ($this->M_memo->ubah_file_memo_keluar($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Ubah file memo keluar berhasil!');
                            redirect('home/memo_keluar');
                        } else {
                            $this->session->set_flashdata('notif', 'Ubah file memo keluar gagal!');
                            redirect('home/memo_keluar');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/memo_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/memo_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function get_memo_masuk_by_id($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data_memo_masuk_by_id = $this->M_memo->get_memo_masuk_by_id($id_memo);
                echo json_encode($data_memo_masuk_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function get_memo_keluar_by_id($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data_memo_keluar_by_id = $this->M_memo->get_memo_keluar_by_id($id_memo);
                echo json_encode($data_memo_keluar_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_memo_masuk($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $path = './uploads/' . $this->M_memo->get_nama_file_memo_masuk($id_memo);
                if (unlink($path)) {
                    if ($this->M_memo->hapus_memo_masuk($id_memo) == true) {
                        $this->session->set_flashdata('notif', 'Hapus memo Berhasil!');
                        redirect('home/memo_masuk');
                    } else {
                        $this->session->set_flashdata('notif', 'Tidak dapat menghapus memo!');
                        redirect('home/memo_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Tidak dapat menghapus berkas dokumen!');
                    redirect('home/memo_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_memo_keluar($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $path = './uploads/' . $this->M_memo->get_nama_file_memo_keluar($id_memo);

                if (unlink($path)) {
                    if ($this->M_memo->hapus_memo_keluar($id_memo) == true) {
                        $this->session->set_flashdata('notif', 'Hapus memo keluar berhasil!');
                        redirect('home/memo_keluar');
                    } else {
                        $this->session->set_flashdata('notif', 'Hapus memo keluar gagal');
                        redirect('home/memo_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/memo_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
}