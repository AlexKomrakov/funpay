// Функция вызова модального окна
function openModal(url) {
    $('#myModal').modal('show');
    $.ajax({
        url: url,
        type: 'get',
        cache: false,
        success: function (data) {
            $('#myModal').find(".modal-body").html(data);
        },
        error: function (error) {
            error = JSON.stringify(error);
            $('#myModal').find(".modal-body").html(error);
        }
    });
}