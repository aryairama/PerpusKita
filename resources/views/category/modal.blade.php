<div class="modal fade create" role="dialog" tabindex="-1" id="modal_dialog" aria-hidden="true">
    <div class=" modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form_data_category form-data" enctype="multipart/form-data" method="POST">
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
                                <input class="form-control form-control-custom p-0" type="text" name="name" id="name"
                                    placeholder="Category Name">
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
                    <input type="submit" value="Simpan" class="btn btn-success btn-submit btn-category-save">
                </div>
            </form>
        </div>
    </div>
</div>
