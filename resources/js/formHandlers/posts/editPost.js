$(document).ready(function () {
    $('#editPostForm').on('submit', function (e) {
        e.preventDefault();
        console.log(this.action);
        $.ajax({
            type: 'POST',
            url: this.action,
            data: $('#editPostForm').serialize(),
            success: function (result) {
                console.log(result);
            }
        });
    });
});
