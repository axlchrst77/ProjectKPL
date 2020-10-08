<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <?php echo 'Daftar ' . $judul ?>
                <?php
                if ($this->M_surat->cek_status_surat_masuk($this->uri->segment(3)) == true) {
                    echo '
                    &nbsp;&nbsp;
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambah_surat_masuk">
                        <i class="fa fa-envelope"></i> Tambah ' . $judul . '
                    </button>&nbsp;&nbsp;
                    <a href="' . base_url('home/disposisi_selesai/' . $this->uri->segment(3)) . '" class="btn btn-info">
                        <i class="fa fa-check"></i> ' . $judul . ' Selesai
                    </a>
                    ';
                } else {
                    echo '<b style="color: green">(DISPOSISI SELESAI)</b>';
                }
                ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pengirim</th>
                        <th>Tujuan Pegawai</th>
                        <th>Tanggal Disposisi</th>
                        <th>Keterangan</th>
						<th>Catatan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($data_disposisi)) {
                        $no = 0;
                        foreach ($data_disposisi as $disposisi) {
							 $data_pegawai = $this->db->join('unit', 'unit.id_unit = pegawai.id_unit')
									->where('id_pegawai', $disposisi->id_pegawai_pengirim)									
									->get('pegawai')->row();
							 if($data_pegawai){
								 $nama_pegawai = $data_pegawai->nama_pegawai;
							 } else {
								 $nama_unit = '';
							 }	
                            echo '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . ++$no . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $nama_pegawai . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi->nama_pegawai . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . date('d-m-Y H:i:s',strtotime($disposisi->tgl_disposisi)) . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi->keterangan . '</td>
								<td class="text-center" style="vertical-align: middle;">' . $disposisi->catatan . '</td>
                                <td class="text-center" style="vertical-align: middle;">
								
                                    <a href="' . base_url('/uploads/' . $disposisi->file_surat) . '" class="btn btn-sm btn-success" target="_blank" style="width: 100%">Lihat Surat</a><br>
									
                                    <a href="' . base_url('home/hapus_disposisi/' . $disposisi->id_disposisi . '/' . $disposisi->id_surat) . '" class="btn btn-sm btn-info" style="width: 100%; margin-top: 5%">Hapus</a><br>
									</br>
									<a href="' . base_url('home/cetak_disposisi/' . $disposisi->id_disposisi) . '" class="btn btn-sm btn-danger" target="_blank" style="width: 100%">Lihat Disposisi</a>
                                </td>
                            </tr>
                            ';
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="modal fade" id="tambah_surat_masuk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" action="<?php echo base_url('home/tambah_disposisi/' . $this->uri->segment(3)) ?>"
                  method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah <?php echo $judul ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tujuan Unit</label>
                        <select class="form-control" name="tujuan_unit"
                                onchange="get_pegawai_id_by_unit(this.value)">
                            <option value="">-- Pilih Unit --</option>
							<option value=""></option>
                            <?php
                            if (isset($drop_down_unit)) {
                                foreach ($drop_down_unit as $unit) {
                                    if ($unit->id_unit != $this->session->userdata('id_unit')) {
                                        echo '<option value="' . $unit->id_unit . '">' . $unit->nama_unit . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tujuan Pegawai</label>
                        <select class="form-control" name="tujuan_pegawai" id="tujuan_pegawai">
                            <option value="">-- Pilih Nama Pegawai --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
						<select class="form-control" name="keterangan" id="keterangan">
                            <option value="">-- Pilih Keterangan --</option>
							<?php
                            if (isset($drop_down_ket)) {
                                foreach ($drop_down_ket as $ket) {
                                    echo '<option value="' . $ket->nama . '">' . $ket->nama . '</option>';
                                    
                                }
                            }
                            ?>
                        </select>
                        
                    </div>
					<div class="form-group">
                        <label>Catatan</label>
                        <textarea class="form-control" rows="1" name="catatan" required></textarea>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Tambah <?php echo $judul ?>" name="submit" class="btn btn-success">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    function get_pegawai_id_by_unit(id_unit) {
        $('#tujuan_pegawai').empty();
        $.getJSON('<?php echo base_url('home/get_pegawai_by_unit/')?>' + id_unit, function (data) {
            $('#tujuan_pegawai').append('<option value="">-- Pilih Nama Pegawai --</option>');
            $.each(data, function (index, value) {
                $('#tujuan_pegawai').append('<option value="' + value.id_pegawai + '">' + value.nama_pegawai + '</option>');
            })
        })
    }
</script>