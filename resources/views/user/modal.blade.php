<div class="modal fade create" role="dialog" tabindex="-1" id="modal_dialog" aria-hidden="true">
    <div class=" modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form_data_user form-data" enctype="multipart/form-data" method="POST">
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
                                    placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-custom p-0" type="email" name="email" id="email"
                                    placeholder="Email@mail.com">
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-custom p-0" type="password" name="password"
                                    id="password" placeholder="password">
                            </div>
                            <div class="form-check check-roles">
                                <label class="roles">Roles</label><br>
                                <label class="form-radio-label">
                                    <input class="form-radio-input roles1" type="radio" name="roles" value="petugas"
                                        id="roles">
                                    <span class="form-radio-sign">Petugas</span>
                                </label>
                                <label class="form-radio-label ml-3 roles2">
                                    <input class="form-radio-input" type="radio" name="roles" value="siswa" id="roles2">
                                    <span class="form-radio-sign">Siswa</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" class="form-control" rows="3" name="address"></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-custom p-0" type="number" name="phone"
                                    id="phone" placeholder="Phone Number">
                            </div>
                            <div class="form-check check-gender">
                                <label class="gender">Gender</label><br>
                                <label class="form-radio-label">
                                    <input class="form-radio-input gender1" type="radio" name="gender" value="L"
                                        id="gender">
                                    <span class="form-radio-sign">Male</span>
                                </label>
                                <label class="form-radio-label ml-3 gender2">
                                    <input class="form-radio-input" type="radio" name="gender" value="P" id="gender2">
                                    <span class="form-radio-sign">Female</span>
                                </label>
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
                    <input type="submit" value="Simpan" class="btn btn-success btn-submit btn-user-save">
                </div>
            </form>
        </div>
    </div>
</div>
