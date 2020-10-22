<?php

defined('BASEPATH') OR return('No direct script access allowed');


class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_login');
        $this->load->model('M_surat');
		$this->load->model('M_memo');
		$this->load->model('M_disposisi');
		$this->load->model('M_disposisimemo');
		$this->load->model('M_pegawai');
		$this->load->model('M_unit');
		$this->load->model('M_ketdisposisi');
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
            redirect('login');
        }
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
                return json_encode($data_surat_masuk_by_id);
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
                return json_encode($data_surat_keluar_by_id);
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
                return json_encode($data_memo_masuk_by_id);
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
                return json_encode($data_memo_keluar_by_id);
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
                return json_encode($data_unit_by_id);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    
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
                return json_encode($data_user_by_id);
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
            return json_encode($data_pegawai_by_id_unit);
        } else {
            redirect('login');
        }
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
                return json_encode($data_ketdisposisi_by_id);
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
	
	public function disposisi($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1' || $this->session->userdata('level') == '2') {
                $data['judul'] = 'Disposisi Surat';
                $data['main_view'] = 'admin/disposisi';
                $data['data_surat'] = $this->M_surat->get_surat_masuk_by_id($id_surat);
                $data['drop_down_unit'] = $this->M_unit->get_unit();
				$data['drop_down_pegawai'] = $this->M_pegawai->get_pegawai();
				$data['drop_down_ket']     = $this->M_ketdisposisi->get_ketdisposisi();
                $data['data_disposisi'] = $this->M_disposisi->get_disposisi($id_surat);
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function disposisi_selesai($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                if ($this->M_disposisi->disposisi_selesai($id_surat) == true) {
                    $this->session->set_flashdata('notif', 'Disposisi surat ini telah selesai!');
                    redirect('home/disposisi/' . $id_surat);
                } else {
                    $this->session->set_flashdata('notif', 'Gagal update status disposisi!');
                    redirect('home/disposisi/' . $id_surat);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
	}
	
	public function disposisi_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Surat Masuk';
            $data['main_view'] = 'pegawai/disposisi_masuk';
            $data['data_disposisi_masuk'] = $this->M_disposisi->get_disposisi_masuk($this->session->userdata('id_pegawai'));
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
	
	public function disposisi_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Surat Keluar';
            $data['main_view'] = 'pegawai/disposisi_keluar';
            $data['data_disposisi_keluar'] = $this->M_disposisi->get_all_disposisi_keluar();
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
	
	public function disposisi_keluar_pegawai($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Keluar';
            $data['main_view'] = 'pegawai/disposisi_keluar';
            $data['data_surat'] = $this->M_surat->get_surat_masuk_by_id($id_surat);
            $data['data_disposisi_keluar'] = $this->M_disposisi->get_disposisi_keluar($id_surat);
            $data['drop_down_unit'] = $this->M_unit->get_unit();
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
	
	public function tambah_disposisi($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1' || $this->session->userdata('level') == '2') {
                $this->form_validation->set_rules('tujuan_unit', 'Tujuan Unit', 'trim|required');
                $this->form_validation->set_rules('tujuan_pegawai', 'Tujuan Pegawai', 'trim|required');
                $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
				$this->form_validation->set_rules('catatan', 'Catatan', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_disposisi->tambah_disposisi($id_surat) == true) {
                        $this->session->set_flashdata('notif', 'Tambah disposisi surat berhasil!');
                        redirect('home/disposisi/' . $id_surat);
                    } else {
                        $this->session->set_flashdata('notif', 'Tambah disposisi surat gagal!');
                        redirect('home/disposisi/' . $id_surat);
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/disposisi/' . $id_surat);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_disposisi_pegawai($id_surat) {
        if ($this->session->userdata('logged_in') == true) {
		 if ($this->session->userdata('level') == '2') {
            $this->form_validation->set_rules('tujuan_unit', 'Tujuan Unit', 'trim|required');
            $this->form_validation->set_rules('tujuan_pegawai', 'Tujuan Pegawai', 'trim|required');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

            if ($this->form_validation->run() == true) {
                if ($this->M_disposisi->tambah_disposisi($id_surat) == true) {
                    $this->session->set_flashdata('notif', 'Tambah disposisi surat berhasil!');
                    redirect('home/disposisi_keluar_pegawai/' . $id_surat);
                } else {
                    $this->session->set_flashdata('notif', 'Tambah disposisi surat gagal!');
                    redirect('home/disposisi_keluar_pegawai/' . $id_surat);
                }
            } else {
                $this->session->set_flashdata('notif', validation_errors());
                redirect('home/disposisi_keluar_pegawai/' . $id_surat);
            }
        } else {
            redirect('login');
			}
		}
	}
	
	public function hapus_disposisi($id_disposisi, $id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                if ($this->M_disposisi->hapus_disposisi($id_disposisi) == true) {
                    $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Berhasil!');
                    redirect('home/disposisi/' . $id_surat);
                } else {
                    $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Gagal!');
                    redirect('home/disposisi' . $id_surat);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_disposisi_pegawai($id_disposisi, $id_surat) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->M_disposisi->hapus_disposisi($id_disposisi) == true) {
                $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Berhasil!');
                redirect('home/disposisi_keluar_pegawai/' . $id_surat);
            } else {
                $this->session->set_flashdata('notif', 'Hapus Disposisi Surat Gagal!');
                redirect('home/disposisi_keluar_pegawai/' . $id_surat);
            }
        } else {
            redirect('login');
        }
    }
	
	public function cetak_disposisi($param)
	{
		if ($this->session->userdata('logged_in') == true) {			  		 
            $this->load->helper('surat');		
		   
			$header = $this->db->get_where('disposisi', ['id_disposisi' => $param])->row();
			$idunit= $header->id_unit_pengirim;
			$data  = $this->db->get_where('unit', ['id_unit' => $idunit])->row();
			if($data){
			  $unit = $data->nama_unit;	
			}
			$ket    = $header->keterangan;
			$id_surat = $header->id_surat;
			$detil = $this->db->get_where('surat_masuk', ['id_surat' => $id_surat])->row();
			 		    
			$pdf=new surat();
			$pdf->addpage("P","A4");   
			$pdf->setsize("P","A4");
			
			$pdf->image(base_url().'assets/img/logo.png',10,10,30,20); 
            $pdf->cell(10);
            $pdf->SetFont('Arial','B',10);
            $pdf->cell(0,5,'KANTOR CABANG MAGELANG',0,1,'C'); 			
			$pdf->ln(10);
			$pdf->cell(40);
			$pdf->cell(0,5,'Agenda No : ',0,1,'L'); 			
		    
            $pdf->SetWidths(array(190));
			$border = array('B');
			$size   = array('','','');
			$pdf->setfont('Arial','B',18);
			$pdf->SetAligns(array('C'));
			$align = array('C');
			$style = array('B');
			$size  = array('12');
			$max   = array(5);
			$fc     = array('0','0','0');
			$hc     = array('20','20','20');
			
			$pdf->SetWidths(array(90,10,90));
			$border = array('B','','B');
			$size   = array('','','');
			$pdf->setfont('Arial','B',18);
			$pdf->SetAligns(array('C','C','C'));
			$align = array('L','C','L');
			$style = array('','','');
			$size  = array('12','','12');
			$max   = array(5,5,20);
			
			$pdf->ln(1);
			$pdf->setfont('Arial','B',10);
			$pdf->SetAligns(array('L','L','L','L','L'));
			$pdf->SetWidths(array(25,5,90,10, 20,5,30));
			$border = array('','','B','','','','');
			$fc     = array('0','0','0','0','0','0','0');
			$pdf->SetFillColor(230,230,230);			
			$pdf->setfont('Arial','',9);
			$pdf->FancyRow(array('Diterima Dari',':',$detil->pengirim,'','Tanggal',':',date('d M Y',strtotime($detil->tgl_terima))), $fc, $border);
			$pdf->SetWidths(array(25,5,90,10,5,20,10,5,20));
			$border = array('','','B','','BTLR','','','BTLR','');
			$fc     = array('0','0','0','0','0','0','0','0','0');

			$pdf->FancyRow(array('No / Tanggal',':',$detil->nomor_surat.' / '.date('d M Y',strtotime($detil->tgl_kirim)),'','','RAHASIA','','','SEGERA'), $fc, $border);
			$pdf->FancyRow(array('Perihal',':',$detil->perihal,'','','PENTING','','','BIASA'), $fc, $border);
			$pdf->ln(10);
			$judul=array('CATATAN');
			$fc    = array('1');
			$align = array('C');
			$style = array('');
			$size  = array('10');
			$max   = array(20);
			$border = array('');
			$pdf->SetWidths(array(190));
			$pdf->FancyRow2(8,$judul, $fc,  $border, $align, $style, $size, $max);
			$pdf->ln(5);
			$pdf->setfont('Arial','B',6);
			$pdf->SetAligns(array('L','C','R'));
			$pdf->SetWidths(array(50,10,50,10,40,5,25));
			$border = array('TL','T','T','T','TL','T','TR');
			$align  = array('L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0');
			$judul = array('Diteruskan Kepada :','','','','Disposisi :','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			$size  = array('6');
			$pdf->SetWidths(array(5,45,10,5, 45,10,40,5,25));
			$border = array('TBLR','','','TBLR','','','L','','R');
			$align  = array('L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0');
			$judul = array((($unit)=='Deputy Branch Manager'?'X':''),'DEPUTY BRANCH MANAGER','',(($unit)=='Deputy Service Manager'?'X':''),'DEPUTY SERVICE MANAGER','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','TBLR','','','','TBLR','','','LBTR','','LT','RT');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='Branch Consumer Lending Unit'?'X':''),'Branch Consumer Lending Head','','',(($unit)=='Customer Service Head'?'X':''),'Customer Service Head','',($ket=='Teliti'?'X':''),'Teliti','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='CUSTOMER LOAN SALES'?'X':''),'Consumer Loan Sales','','','',(($unit)=='CUSTOMER SERVICE'?'X':''),'Customer Service','',($ket=='Edarkan'?'X':''),'Edarkan','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,45,5,5,30,5,30));
			$border = array('L','','TBLR','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='CUSTOMER LOAN SERVICE'?'X':''),'Consumer Loan Service','','',(($unit)=='Branch Operation Unit'?'X':''),'Branch Operation Unit Head','',($ket=='Ajukan Pendapat'?'X':''),'Ajukan Pendapat','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='Consumer LOAD OFFICER'?'X':''),'Customer Loan Officer','','','',(($unit)=='TELLER SERVICE SERVICE HEAD'?'X':''),'Teller Service Service Head','',($ket=='Sebagai Pedoman'?'X':''),'Sebagai Pedoman','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='Branch Consumer & SME Sales Unit'?'X':''),'Branch Commercial & SME Sales Head','','','','',(($unit)=='TELLER'?'X':''),'Teller','',($ket=='Laporkan'?'X':''),'Laporkan','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='COMMER RM'?'X':''),'Commer RM','','','','',(($unit)=='VAULT'?'X':''),'Vault','',($ket=='Diproses'?'X':''),'Diproses','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='SME SALES'?'X':''),'SME Sales','','','',(($unit)=='Transaction Processing Unit'?'X':''),'Transaction Processing Head','',($ket=='Bicarakan dengan saya'?'X':''),'Bicarakan dengan saya','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='ASSISTANT COMMERCIAL RM'?'X':''),'Assistant Commercial RM','','','','',(($unit)=='CLEARING'?'X':''),'Clearing','',($ket=='Perhatian'?'X':''),'Perhatian','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='COMMERCIAL FUNDING SALES'?'X':''),'Commercial Funding Sales','','','','',(($unit)=='TP & IT SUPPORT'?'X':''),'TP & IT Support','',($ket=='Dimonitor'?'X':''),'Dimonitor','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','TBLR','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='Branch Consumer Funding Unit'?'X':''),'Branch Customer Funding Head','','',(($unit)=='Credit Admin'?'X':''),'Credit Admin','',($ket=='Dicek/ Konfirmasi'?'X':''),'Dicek/ Konfirmasi','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='CUSTOMER FUNDING SALES'?'X':''),'Consumer Funding Sales','','','',(($unit)=='LOAD ADMINISTRATION'?'X':''),'Load Administration','',($ket=='U/ Dilaksanakan'?'X':''),'U/ Dilaksanakan','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='BANKING SERVICE & ALLIANCE SALES'?'X':''),'Banking Service & Alliance Sales','','','',(($unit)=='LOAN DOCUMENT'?'X':''),'Loan Document','',($ket=='U/ Diketahui'?'X':''),'U/ Diketahui','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='GOVERNMENT PROGRAM SALES'?'X':''),'Government Program Sales','','','',(($unit)=='OTS OFFICER'?'X':''),'OTS Officer','',($ket=='Dihadir'?'X':''),'Dihadir','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','','','','',(($unit)=='Accounting Control Unit Head'?'X':''),'Accounting Control Unit Head','',($ket=='File'?'X':''),'File','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,50,5,5,5,5,40,5,5,30,5,30));
			$border = array('TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array((($unit)=='BLR'?'X':''),'BLR','','','',(($unit)=='ACCOUNTING & REPORTING OFFICER'?'X':''),'Accounting & Reporting Officer','',($ket=='Copy'?'X':''),'Copy','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,50,5,5,5,5,40,5,5,30,5,30));
			$border = array('TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array((($unit)=='BSCO'?'X':''),'BSCO','','','',(($unit)=='INTERNAL CONTROL OFFICER'?'X':''),'Internal Control Officer','',($ket=='Sekretaris'?'X':''),'Sekretaris','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','','','','',(($unit)=='Branch Shared Service Unit'?'X':''),'Branch Shared Service Unit Head','',($ket=='Forward Ke'?'X':''),'Forward Ke','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(55,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('KANTOR CABANG PEMBANTU','','','',(($unit)=='HUMAN CAPITAL SUPPORT OFFICER'?'X':''),'Human Capital Support Officer','',($ket=='Seluruh Pegawai'?'X':''),'Seluruh Pegawai','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','TBLR','','','','','TBLR','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','','KCP Kebumen','','','',(($unit)=='LOGISTIC SUPPORT OFFICER'?'X':''),'Logistic Support Officer','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','TBLR','','','','TBLR','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='KCP MUNTILAN'?'X':''),'KCP Muntilan','','',(($unit)=='Branch Collection Coordinator'?'X':''),'Branch Collection Coordinator','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','TBLR','','','','','TBLR','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='KCP TEMANGGUNG'?'X':''),'KCP Temanggung','','','',(($unit)=='SKIP TRACER COORDINATOR'?'X':''),'Skip Tracer Coordinator','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(55,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','','','','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('KANTOR KAS','','','','','','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,50,5,5,30,5,30));
			$border = array('L','TBLR','','','TBLR','','','LB','B','LB','RB');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='KK MERTOYUDAN'?'X':''),'KK Mertoyudan','',(($unit)=='Koordinator BKP'?'X':''),'Koordinator BKP','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(190));
			$border = array('BLR');
			$align  = array('L');			
			$fc = array('0');
			$judul = array('');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$border = array('','','','');
			$align  = array('L','L','L','L');
			$fc = array('0','0','0','0');
			$no=1;
			
			$pdf->ln(5);
			$pdf->SetWidths(array(90,10,30,60));
			$border = array('','','BT','BT');
			$size   = array('','','','');
			$pdf->setfont('Arial','B',18);
			$pdf->SetAligns(array('C','C','L','R'));
			$align = array('L','C','L','R');
			$style = array('','','B','B');
			$size  = array('10','','10','12');
			$max   = array(5,5,20,20);
			
			$pdf->AliasNbPages();
			$pdf->Settitle('DISPOSISI'.$header->id_disposisi);
			$pdf->output('DISPOSISI'.$header->id_disposisi.'.PDF','I');			
		}
		else
		{
			
			redirect('login');
			
		}
	}
	
	public function disposisi_memo($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1' || $this->session->userdata('level') == '2') {
                $data['judul'] = 'Disposisi Memo';
                $data['main_view'] = 'admin/disposisi_memo';
                $data['data_surat'] = $this->M_memo->get_memo_masuk_by_id($id_memo);
                $data['drop_down_unit'] = $this->M_unit->get_unit();
				$data['drop_down_pegawai'] = $this->M_pegawai->get_pegawai();
				$data['drop_down_ket']     = $this->M_ketdisposisi->get_ketdisposisi();
                $data['data_disposisi'] = $this->M_disposisimemo->get_disposisi_memo($id_memo);
                $this->load->view('template', $data);
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function disposisi_memo_selesai($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                if ($this->M_disposisimemo->disposisi_memo_selesai($id_memo) == true) {
                    $this->session->set_flashdata('notif', 'Disposisi Memo ini telah selesai!');
                    redirect('home/disposisi_memo/' . $id_memo);
                } else {
                    $this->session->set_flashdata('notif', 'Gagal update status disposisi!');
                    redirect('home/disposisi_memo/' . $id_memo);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function disposisi_memo_masuk() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Memo Masuk';
            $data['main_view'] = 'pegawai/disposisi_memo_masuk';
            $data['data_disposisi_masuk'] = $this->M_disposisimemo->get_disposisi_memo_masuk($this->session->userdata('id_pegawai'));
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
	
	public function disposisi_memo_keluar() {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Memo Keluar';
            $data['main_view'] = 'pegawai/disposisi_memo_keluar';
            $data['data_disposisi_keluar'] = $this->M_disposisimemo->get_all_disposisi_memo_keluar();
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
	
	public function disposisi_keluar_pegawai_memo($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            $data['judul'] = 'Disposisi Memo Keluar';
            $data['main_view'] = 'pegawai/disposisi_memo_keluar';
            $data['data_surat'] = $this->M_memo->get_memo_masuk_by_id($id_memo);
            $data['data_disposisi_keluar'] = $this->M_disposisimemo->get_disposisi_memo_keluar($id_memo);
            $data['drop_down_unit'] = $this->M_unit->get_unit();
            $this->load->view('template', $data);
        } else {
            redirect('login');
        }
    }
	
	public function tambah_disposisi_memo($id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1' || $this->session->userdata('level') == '2') {
                $this->form_validation->set_rules('tujuan_unit', 'Tujuan Unit', 'trim|required');
                $this->form_validation->set_rules('tujuan_pegawai', 'Tujuan Pegawai', 'trim|required');
                $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
				$this->form_validation->set_rules('catatan', 'Catatan', 'trim|required');

                if ($this->form_validation->run() == true) {
                    if ($this->M_disposisimemo->tambah_disposisi_memo($id_memo) == true) {
                        $this->session->set_flashdata('notif', 'Tambah disposisi Memo berhasil!');
                        redirect('home/disposisi_memo/' . $id_memo);
                    } else {
                        $this->session->set_flashdata('notif', 'Tambah disposisi Memo gagal!');
                        redirect('home/disposisi_memo/' . $id_memo);
                    }
                } else {
                    $this->session->set_flashdata('notif', validation_errors());
                    redirect('home/disposisi_memo/' . $id_memo);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_disposisi_memo($id_disposisi, $id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                if ($this->M_disposisimemo->hapus_disposisi_memo($id_disposisi) == true) {
                    $this->session->set_flashdata('notif', 'Hapus Disposisi Memo Berhasil!');
                    redirect('home/disposisi_memo/' . $id_memo);
                } else {
                    $this->session->set_flashdata('notif', 'Hapus Disposisi Memo Gagal!');
                    redirect('home/disposisi_memo' . $id_memo);
                }
            } else {
                redirect('logout');
            }
        } else {
            redirect('login');
        }
    }
	
	public function hapus_disposisi_memo_pegawai($id_disposisi, $id_memo) {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->M_disposisimemo->hapus_disposisi_memo($id_disposisi) == true) {
                $this->session->set_flashdata('notif', 'Hapus Disposisi Memo Berhasil!');
                redirect('home/disposisi_keluar_pegawai_memo/' . $id_memo);
            } else {
                $this->session->set_flashdata('notif', 'Hapus Disposisi Memo Gagal!');
                redirect('home/disposisi_keluar_pegawai_memo/' . $id_memo);
            }
        } else {
            redirect('login');
        }
    }
	
	public function tambah_ketdisposisi() {
        if ($this->session->userdata('logged_in') == true) {
            if ($this->session->userdata('level') == '1') {
                $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
                
                if ($this->form_validation->run() == true) {
                    if ($this->M_ketdisposisi->tambah_ketdisposisi() == true) {
                        $this->session->set_flashdata('notif', 'Tambah Ket. Disposisi berhasil!');
                        redirect('home/ketdisposisi');
                    } else {
                        $this->session->set_flashdata('notif', 'Tambah Ket. Disposisi gagal!');
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
	
	public function cetak_disposisi_memo($param)
	{
		if ($this->session->userdata('logged_in') == true) {			  		 
            $this->load->helper('surat');		
		   
			$header = $this->db->get_where('disposisi_memo', ['id_disposisi' => $param])->row();
			$idunit= $header->id_unit_pengirim;
			$data  = $this->db->get_where('unit', ['id_unit' => $idunit])->row();
			if($data){
			  $unit = $data->nama_unit;	
			}
			$ket    = $header->keterangan;
			$id_memo = $header->id_memo;
			$detil = $this->db->get_where('memo_masuk', ['id_memo' => $id_memo])->row();
			 		    
			$pdf=new surat();
			$pdf->addpage("P","A4");   
			$pdf->setsize("P","A4");
			
			$pdf->image(base_url().'assets/img/logo.png',10,10,30,20); 
            $pdf->cell(10);
            $pdf->SetFont('Arial','B',10);
            $pdf->cell(0,5,'KANTOR CABANG MAGELANG',0,1,'C'); 			
			$pdf->ln(10);
			$pdf->cell(40);
			$pdf->cell(0,5,'Agenda No : ',0,1,'L'); 			
		    
            $pdf->SetWidths(array(190));
			$border = array('B');
			$size   = array('','','');
			$pdf->setfont('Arial','B',18);
			$pdf->SetAligns(array('C'));
			$align = array('C');
			$style = array('B');
			$size  = array('12');
			$max   = array(5);
			$fc     = array('0','0','0');
			$hc     = array('20','20','20');
			
			$pdf->SetWidths(array(90,10,90));
			$border = array('B','','B');
			$size   = array('','','');
			$pdf->setfont('Arial','B',18);
			$pdf->SetAligns(array('C','C','C'));
			$align = array('L','C','L');
			$style = array('','','');
			$size  = array('12','','12');
			$max   = array(5,5,20);
			
			$pdf->ln(1);
			$pdf->setfont('Arial','B',10);
			$pdf->SetAligns(array('L','L','L','L','L'));
			$pdf->SetWidths(array(25,5,90,10, 20,5,30));
			$border = array('','','B','','','','');
			$fc     = array('0','0','0','0','0','0','0');
			$pdf->SetFillColor(230,230,230);			
			$pdf->setfont('Arial','',9);
			$pdf->FancyRow(array('Diterima Dari',':',$detil->pengirim,'','Tanggal',':',date('d M Y',strtotime($detil->tgl_terima))), $fc, $border);
			$pdf->SetWidths(array(25,5,90,10,5,20,10,5,20));
			$border = array('','','B','','BTLR','','','BTLR','');
			$fc     = array('0','0','0','0','0','0','0','0','0');

			$pdf->FancyRow(array('No / Tanggal',':',$detil->nomor_memo.' / '.date('d M Y',strtotime($detil->tgl_kirim)),'','','RAHASIA','','','SEGERA'), $fc, $border);
			$pdf->FancyRow(array('Perihal',':',$detil->perihal,'','','PENTING','','','BIASA'), $fc, $border);
			$pdf->ln(10);
			$judul=array('CATATAN');
			$fc    = array('1');
			$align = array('C');
			$style = array('');
			$size  = array('10');
			$max   = array(20);
			$border = array('');
			$pdf->SetWidths(array(190));
			$pdf->FancyRow2(8,$judul, $fc,  $border, $align, $style, $size, $max);
			$pdf->ln(5);
			$pdf->setfont('Arial','B',6);
			$pdf->SetAligns(array('L','C','R'));
			$pdf->SetWidths(array(50,10,50,10,40,5,25));
			$border = array('TL','T','T','T','TL','T','TR');
			$align  = array('L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0');
			$judul = array('Diteruskan Kepada :','','','','Disposisi :','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			$size  = array('6');
			$pdf->SetWidths(array(5,45,10,5, 45,10,40,5,25));
			$border = array('TBLR','','','TBLR','','','L','','R');
			$align  = array('L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0');
			$judul = array((($unit)=='Deputy Branch Manager'?'X':''),'DEPUTY BRANCH MANAGER','',(($unit)=='Deputy Service Manager'?'X':''),'DEPUTY SERVICE MANAGER','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','TBLR','','','','TBLR','','','LBTR','','LT','RT');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='Branch Consumer Lending Unit'?'X':''),'Branch Consumer Lending Head','','',(($unit)=='Customer Service Head'?'X':''),'Customer Service Head','',($ket=='Teliti'?'X':''),'Teliti','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='CUSTOMER LOAN SALES'?'X':''),'Consumer Loan Sales','','','',(($unit)=='CUSTOMER SERVICE'?'X':''),'Customer Service','',($ket=='Edarkan'?'X':''),'Edarkan','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,45,5,5,30,5,30));
			$border = array('L','','TBLR','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='CUSTOMER LOAN SERVICE'?'X':''),'Consumer Loan Service','','',(($unit)=='Branch Operation Unit'?'X':''),'Branch Operation Unit Head','',($ket=='Ajukan Pendapat'?'X':''),'Ajukan Pendapat','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='Consumer LOAD OFFICER'?'X':''),'Customer Loan Officer','','','',(($unit)=='TELLER SERVICE SERVICE HEAD'?'X':''),'Teller Service Service Head','',($ket=='Sebagai Pedoman'?'X':''),'Sebagai Pedoman','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='Branch Consumer & SME Sales Unit'?'X':''),'Branch Commercial & SME Sales Head','','','','',(($unit)=='TELLER'?'X':''),'Teller','',($ket=='Laporkan'?'X':''),'Laporkan','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='COMMER RM'?'X':''),'Commer RM','','','','',(($unit)=='VAULT'?'X':''),'Vault','',($ket=='Diproses'?'X':''),'Diproses','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='SME SALES'?'X':''),'SME Sales','','','',(($unit)=='Transaction Processing Unit'?'X':''),'Transaction Processing Head','',($ket=='Bicarakan dengan saya'?'X':''),'Bicarakan dengan saya','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='ASSISTANT COMMERCIAL RM'?'X':''),'Assistant Commercial RM','','','','',(($unit)=='CLEARING'?'X':''),'Clearing','',($ket=='Perhatian'?'X':''),'Perhatian','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,5,35,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='COMMERCIAL FUNDING SALES'?'X':''),'Commercial Funding Sales','','','','',(($unit)=='TP & IT SUPPORT'?'X':''),'TP & IT Support','',($ket=='Dimonitor'?'X':''),'Dimonitor','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','TBLR','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='Branch Consumer Funding Unit'?'X':''),'Branch Customer Funding Head','','',(($unit)=='Credit Admin'?'X':''),'Credit Admin','',($ket=='Dicek/ Konfirmasi'?'X':''),'Dicek/ Konfirmasi','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='CUSTOMER FUNDING SALES'?'X':''),'Consumer Funding Sales','','','',(($unit)=='LOAD ADMINISTRATION'?'X':''),'Load Administration','',($ket=='U/ Dilaksanakan'?'X':''),'U/ Dilaksanakan','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='BANKING SERVICE & ALLIANCE SALES'?'X':''),'Banking Service & Alliance Sales','','','',(($unit)=='LOAN DOCUMENT'?'X':''),'Loan Document','',($ket=='U/ Diketahui'?'X':''),'U/ Diketahui','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,5,40,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','',(($unit)=='GOVERNMENT PROGRAM SALES'?'X':''),'Government Program Sales','','','',(($unit)=='OTS OFFICER'?'X':''),'OTS Officer','',($ket=='Dihadir'?'X':''),'Dihadir','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','','','','',(($unit)=='Accounting Control Unit Head'?'X':''),'Accounting Control Unit Head','',($ket=='File'?'X':''),'File','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,50,5,5,5,5,40,5,5,30,5,30));
			$border = array('TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array((($unit)=='BLR'?'X':''),'BLR','','','',(($unit)=='ACCOUNTING & REPORTING OFFICER'?'X':''),'Accounting & Reporting Officer','',($ket=='Copy'?'X':''),'Copy','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,50,5,5,5,5,40,5,5,30,5,30));
			$border = array('TBLR','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array((($unit)=='BSCO'?'X':''),'BSCO','','','',(($unit)=='INTERNAL CONTROL OFFICER'?'X':''),'Internal Control Officer','',($ket=='Sekretaris'?'X':''),'Sekretaris','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','','','','',(($unit)=='Branch Shared Service Unit'?'X':''),'Branch Shared Service Unit Head','',($ket=='Forward Ke'?'X':''),'Forward Ke','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(55,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','','','TBLR','','','LBTR','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('KANTOR CABANG PEMBANTU','','','',(($unit)=='HUMAN CAPITAL SUPPORT OFFICER'?'X':''),'Human Capital Support Officer','',($ket=='Seluruh Pegawai'?'X':''),'Seluruh Pegawai','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','TBLR','','','','','TBLR','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('','','KCP Kebumen','','','',(($unit)=='LOGISTIC SUPPORT OFFICER'?'X':''),'Logistic Support Officer','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,45,5,5,30,5,30));
			$border = array('L','TBLR','','','','TBLR','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='KCP MUNTILAN'?'X':''),'KCP Muntilan','','',(($unit)=='Branch Collection Coordinator'?'X':''),'Branch Collection Coordinator','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','TBLR','','','','','TBLR','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='KCP TEMANGGUNG'?'X':''),'KCP Temanggung','','','',(($unit)=='SKIP TRACER COORDINATOR'?'X':''),'Skip Tracer Coordinator','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(55,5,5,5,5,40,5,5,30,5,30));
			$border = array('L','','','','','','','L','','L','R');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('KANTOR KAS','','','','','','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(5,5,45,5,5,50,5,5,30,5,30));
			$border = array('L','TBLR','','','TBLR','','','LB','B','LB','RB');
			$align  = array('L','L','L','L','L','L','L','L','L','L');			
			$fc = array('0','0','0','0','0','0','0','0','0','0','0');
			$judul = array('',(($unit)=='KK MERTOYUDAN'?'X':''),'KK Mertoyudan','',(($unit)=='Koordinator BKP'?'X':''),'Koordinator BKP','','','','','');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$pdf->SetWidths(array(190));
			$border = array('BLR');
			$align  = array('L');			
			$fc = array('0');
			$judul = array('');
			$pdf->FancyRow2(5,$judul, $fc,  $border, $align, $style, $size, $max);
			
			$border = array('','','','');
			$align  = array('L','L','L','L');
			$fc = array('0','0','0','0');
			$no=1;
			
			$pdf->ln(5);
			$pdf->SetWidths(array(90,10,30,60));
			$border = array('','','BT','BT');
			$size   = array('','','','');
			$pdf->setfont('Arial','B',18);
			$pdf->SetAligns(array('C','C','L','R'));
			$align = array('L','C','L','R');
			$style = array('','','B','B');
			$size  = array('10','','10','12');
			$max   = array(5,5,20,20);
			
			$pdf->AliasNbPages();
			$pdf->Settitle('DISPOSISI'.$header->id_disposisi);
			$pdf->output('DISPOSISI'.$header->id_disposisi.'.PDF','I');			
		}
		else
		{
			
			redirect('login');
			
		}
	}

}
