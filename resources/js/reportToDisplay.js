window.Echo
    .private('reportText')
    .listen('TotalReportTextEvent', (event) => {
        window.alert(event.textToReport);
    });
