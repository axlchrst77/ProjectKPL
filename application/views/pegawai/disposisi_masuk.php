<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <?php return 'Daftar ' . $judul ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Divisi Pengirim</th>
                        <th>Nama Pengirim</th>
                        <th>Tanggal Disposisi</th>
                        <th>Keterangan</th>
						<th>Catatan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($data_disposisi_masuk)) {
                        $no = 0;
                        foreach ($data_disposisi_masuk as $disposisi_masuk) {
							 $data_pegawai = $this->db->join('unit', 'unit.id_unit = pegawai.id_unit')
									->where('id_pegawai', $disposisi_masuk->id_pegawai_pengirim)									
									->get('pegawai')->row();
							 if($data_pegawai){
								 $nama_unit = $data_pegawai->nama_unit;
							 } else {
								 $nama_unit = '';
							 }	
                            return '
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">' . ++$no . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $nama_unit . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi_masuk->nama_pegawai . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . date('d-m-Y H:i:s',strtotime($disposisi_masuk->tgl_disposisi)) . '</td>
                                <td class="text-center" style="vertical-align: middle;">' . $disposisi_masuk->keterangan . '</td>
								<td class="text-center" style="vertical-align: middle;">' . $disposisi_masuk->catatan . '</td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <a href="' . base_url('/uploads/' . $disposisi_masuk->file_surat) . '" class="btn btn-sm btn-success" target="_blank" style="width: 100%">Lihat Surat</a><br>
                                    <a href="' . base_url('home/disposisi/' . $disposisi_masuk->id_surat) . '" class="btn btn-sm btn-info" style="width: 100%; margin-top: 5%">Tambah Disposisi</a><br>
									</br>
									<a href="' . base_url('home/cetak_disposisi/' . $disposisi_masuk->id_disposisi) . '" class="btn btn-sm btn-danger" target="_blank" style="width: 100%">Lihat Disposisi</a>
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
            <form role="form" action="<?php return base_url('home/tambah_disposisi/' . $this->uri->segment(3)) ?>"
                  method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Tambah <?php return $judul ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tujuan Unit</label>
                        <select class="form-control" name="tujuan_unit"
                                onchange="get_pegawai_id_by_unit(this.value)">
                            <option value="">-- Pilih Tujuan Unit --</option>
                            <?php
                            if (isset($drop_down_unit)) {
                                foreach ($drop_down_unit as $unit) {
                                    if ($unit->id_unit != $this->session->userdata('id_unit')) {
                                        return '<option value="' . $unit->id_unit . '">' . $unit->nama_unit . '</option>';
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
                        <textarea class="form-control" name="keterangan" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Tambah <?php return $judul ?>" name="submit" class="btn btn-success">
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
        $.getJSON('<?php return base_url('home/get_pegawai_by_unit/')?>' + id_unit, function (data) {
            $('#tujuan_pegawai').append('<option value="">-- Pilih Nama Pegawai --</option>');
            $.each(data, function (index, value) {
                $('#tujuan_pegawai').append('<option value="' + value.id_pegawai + '">' + value.nama_pegawai + '</option>');
            })
        })
    }
</script>
