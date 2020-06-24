$(document).ready(function () {
    $('#reportForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/admin/reports/total-report',
            data: $('#reportForm').serialize(),
            success: function (result) {
                console.log(result);
                let messageAboutReportStatus = document.getElementsByClassName('messageAboutReportStatus');
                let divForMessage = document.createElement('div');
                let message = document.createElement('p');
                message.innerText = result.message;
                divForMessage.className = "alert";
                divForMessage.className = result.style;
                divForMessage.append(message);
                messageAboutReportStatus[0].append(divForMessage);
            }
        });
    });
});
