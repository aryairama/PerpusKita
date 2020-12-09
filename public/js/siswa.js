var table = $("#dashboard_siswa").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    order : [[ 5, "desc" ]],
    ajax: "/home",
    columns: [{
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            searchable: false,
            orderable: false
        },
        {
            data: "users.name",
            name: "users.name"
        },
        {
            data: "books.id",
            name: "books.id"
        },
        {
            data: "books.title",
            name: "books.title"
        },
        {
            data: "status_return",
            name: "status_return",
        },
        {
            data: "borrows.borrow_date",
            name: "borrows.borrow_date",
        },
        {
            data: "return_date",
            name: "return_date",
        }
    ]
});
