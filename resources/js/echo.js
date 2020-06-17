window.Echo
    .private('admin')
    .listen('UpdatePost', (event) => {
        window.alert(event.message);
        window.alert(event.linkToPost);
    });
