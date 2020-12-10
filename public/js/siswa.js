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
            data: "name",
            name: "users.name"
        },
        {
            data: "book_id",
            name: "books.id"
        },
        {
            data: "title",
            name: "books.title"
        },
        {
            data: "status_return",
            name: "status_return",
        },
        {
            data: "borrow_date",
            name: "borrowed_books.borrow_date",
        },
        {
            data: "return_date",
            name: "return_date",
        }
    ]
});
