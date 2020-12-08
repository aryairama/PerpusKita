<div class="modal fade create" role="dialog" tabindex="-1" id="modal_dialog" aria-hidden="true">
    <div class=" modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form_data_return_verif form-data" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="_method">
                <div class="modal-header">
                    <h5 class="modal-title text-white h4"></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 row-roles">
                            <div class="form-group">
                                <label for="status_return">Status retun book</label>
                                <select class="form-control" id="status_return" name="status_return">
                                    <option value="">Status</option>
                                    <option value="kembali">Kembali</option>
                                    <option value="hilang">Hilang</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row content-table">
                        </div>
                    </div>
                    {{-- isi --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Tutup</button>
                    <input type="submit" value="Simpan" class="btn btn-success btn-submit btn-user-status">
                </div>
            </form>
        </div>
    </div>
</div>