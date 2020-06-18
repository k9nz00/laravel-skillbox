window.Echo
    .private('admin')
    .listen('UpdatePost', (event) => {
        $.notify({
            icon: 'glyphicon glyphicon-warning-sign',
            title: 'Статья ' + event.post.title + ' была изменена.',
            message: event.message,
            url: event.linkToPost
        }, {
            type: "success",
        });
    });
