function borrow_book(id) {
    Swal.fire({
        title: 'Want to borrow this book?',
        text: "books must be returned!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, borrow!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            let data = new FormData();
            data.append('book_id', id)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: `/borrows`,
                method: `POST`,
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(`.${id}`).attr('disabled', true)
                },
                success: function (ress) {
                    if (ress.method === "save") {
                        $(`.${id}`).parentsUntil('.row').remove()
                        notifAlert1('Sukses', 'Data has been saved successfully', 'success')
                    } else if (ress == 404) {
                        notifAlert1('Error', 'Data Not Found', 'error')
                    }
                },
                error: function (err) {
                    if (err.status == 404) {
                        notifAlert1('Error', 'Data Not Found', 'error')
                    } else if (err.status == 403) {
                        notifAlert1('Info', err.responseText, 'info')
                        $(`.${id}`).parentsUntil('.row').remove()
                    }
                }
            })
        }
    })
}

function notifAlert1(header, pesan, type) {
    Swal.fire(`${header}`, `${pesan}`, `${type}`).then(result => {
        if (result.isConfirmed) {
            location.reload()
        }
    });
}
