<div class="modal fade create" role="dialog" tabindex="-1" id="modal_dialog" aria-hidden="true">
    <div class=" modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form_data_book form-data" enctype="multipart/form-data" method="POST">
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
                        <div class="col-md-12 row-book">
                            <div class="form-group">
                                <input class="form-control form-control-custom p-0" type="text" name="id" id="id"
                                    placeholder="Book id">
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-custom p-0" type="text" name="title" id="title"
                                    placeholder="Book Title">
                            </div>
                            <div class="form-group">
                                <label for="synopsis">Synopsis</label>
                                <textarea id="synopsis" class="form-control" rows="3" name="synopsis"></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-custom p-0" type="text" name="author"
                                    id="author" placeholder="Book author">
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-custom p-0" type="text" name="publisher"
                                    id="publisher" placeholder="Book publisher">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" style="width: 100%" id="category" name="category[]"
                                    multiple>
                                </select>
                            </div>
                            <div class="custom-file gambar">
                                <input type="file" class="custom-file-input" id="cover" name="cover"
                                    data-allowed-file-extensions="png jpg jpeg" data-max-file-size-preview="2M"
                                    data-errors-position="outside"/>
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
                    <input type="submit" value="Simpan" class="btn btn-success btn-submit btn-book-save">
                </div>
            </form>
        </div>
    </div>
</div>
