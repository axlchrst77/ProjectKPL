<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class DisposisiMemoController extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('M_memo');
		$this->load->model('M_disposisimemo');
		$this->load->model('M_pegawai');
		$this->load->model('M_unit');
		$this->load->model('M_ketdisposisi');
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