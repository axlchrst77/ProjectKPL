<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class SuratController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_surat');
    }
	
	 public function surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Surat Masuk';
                $data['main_view'] = 'admin/surat_masuk';
                $data['data_surat_masuk'] = $this->M_surat->get_surat_masuk();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data['judul'] = 'Surat Keluar';
                $data['main_view'] = 'admin/surat_keluar';
                $data['data_surat_keluar'] = $this->M_surat->get_surat_keluar();
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim|required');
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

                    if ($this->upload->do_upload('file_surat')) {
                        if ($this->M_surat->tambah_surat_masuk($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Tambah Surat Berhasil!');
                            redirect('home/surat_masuk');
                        } else {
                            $this->session->set_flashdata('notif', 'Tambah Surat Berhasil!');
                            redirect('home/surat_masuk');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('nomor_surat', 'Nomor Surat', 'trim|required');
                $this->form_validation->set_rules('tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('tujuan', 'Tujuan', 'trim|required');
                $this->form_validation->set_rules('perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 2000000;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file_surat')) {
                        if ($this->M_surat->tambah_surat_keluar($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Tambah Surat Keluar Berhasil!');
                            redirect('home/surat_keluar');
                        } else {
                            $this->session->set_flashdata('notif', 'Tambah Surat Gagal!');
                            redirect('home/surat_keluar');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('ubah_nomor_surat', 'Nomor Surat', 'trim|required');
                $this->form_validation->set_rules('ubah_tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('ubah_tgl_terima', "Tanggal Terima", 'trim|required');
                $this->form_validation->set_rules('ubah_pengirim', 'Pengirim', 'trim|required');
                $this->form_validation->set_rules('ubah_penerima', 'Penerima', 'trim|required');
                $this->form_validation->set_rules('ubah_perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_surat->ubah_surat_masuk() == true) {
                        $this->session->set_flashdata('notif', 'Update Surat Masuk Berhasil!');
                        redirect('home/surat_masuk');
                    } else {
                        $this->session->set_flashdata('notif', 'Update Surat Masuk Gagal!');
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('ubah_nomor_surat', 'Nomor Surat', 'trim|required');
                $this->form_validation->set_rules('ubah_tgl_kirim', 'Tanggal Kirim', 'trim|required|date');
                $this->form_validation->set_rules('ubah_tujuan', 'Tujuan', 'trim|required');
                $this->form_validation->set_rules('ubah_perihal', 'Perihal', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_surat->ubah_surat_keluar() == true) {
                        $this->session->set_flashdata('notif', 'Ubah Surat Keluar Berhasil!');
                        redirect('home/surat_keluar');
                    } else {
                        $this->session->set_flashdata('notif', 'Ubah Surat Keluar Gagal!');
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	 public function ubah_file_surat_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2000000;
                $this->load->library('upload', $config);
                $path = './uploads/' . $this->M_surat->get_nama_file_surat_masuk($this->input->post('ubah_file_surat'));

                if (unlink($path)) {
                    if ($this->upload->do_upload('ubah_file_surat')) {
                        if ($this->M_surat->ubah_file_surat_masuk($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Ubah file surat masuk berhasil!');
                            redirect('home/surat_masuk');
                        } else {
                            $this->session->set_flashdata('notif', 'Ubah file surat masuk gagal!');
                            redirect('home/surat_masuk');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function ubah_file_surat_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 2000000;
                $this->load->library('upload', $config);
                $path = './uploads/' . $this->M_surat->get_nama_file_surat_keluar($this->input->post('ubah_file_surat'));
                if (unlink($path)) {
                    if ($this->upload->do_upload('ubah_file_surat')) {
                        if ($this->M_surat->ubah_file_surat_keluar($this->upload->data()) == true) {
                            $this->session->set_flashdata('notif', 'Ubah file surat keluar berhasil!');
                            redirect('home/surat_keluar');
                        } else {
                            $this->session->set_flashdata('notif', 'Ubah file surat keluar gagal!');
                            redirect('home/surat_keluar');
                        }
                    } else {
                        $this->session->set_flashdata('notif', $this->upload->display_errors());
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function get_surat_masuk_by_id($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data_surat_masuk_by_id = $this->M_surat->get_surat_masuk_by_id($id_surat);
                echo json_encode($data_surat_masuk_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function get_surat_keluar_by_id($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $data_surat_keluar_by_id = $this->M_surat->get_surat_keluar_by_id($id_surat);
                echo json_encode($data_surat_keluar_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_surat_masuk($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $path = './uploads/' . $this->M_surat->get_nama_file_surat_masuk($id_surat);
                if (unlink($path)) {
                    if ($this->M_surat->hapus_surat_masuk($id_surat) == true) {
                        $this->session->set_flashdata('notif', 'Hapus Surat Berhasil!');
                        redirect('home/surat_masuk');
                    } else {
                        $this->session->set_flashdata('notif', 'Tidak dapat menghapus surat!');
                        redirect('home/surat_masuk');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Tidak dapat menghapus berkas dokumen!');
                    redirect('home/surat_masuk');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_surat_keluar($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $path = './uploads/' . $this->M_surat->get_nama_file_surat_keluar($id_surat);

                if (unlink($path)) {
                    if ($this->M_surat->hapus_surat_keluar($id_surat) == true) {
                        $this->session->set_flashdata('notif', 'Hapus surat keluar berhasil!');
                        redirect('home/surat_keluar');
                    } else {
                        $this->session->set_flashdata('notif', 'Hapus surat keluar gagal');
                        redirect('home/surat_keluar');
                    }
                } else {
                    $this->session->set_flashdata('notif', 'Gagal menghapus file sebelumnya!');
                    redirect('home/surat_keluar');
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
}