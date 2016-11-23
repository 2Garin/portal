var
    PORTAL = PORTAL || {};

$(document).ready(function () {
    $('.users input:checkbox').change(function () {
        var
            $this = $(this),
            $block = $this.closest('.users'),
            $fullCalendar = $('.fullcalendar'),
            usersId = $block.find('input:checkbox:checked').map(function () {
                return $(this).val();
            }).get();

        if (!usersId.length) {
            $this.prop('checked', true);
            bootbox.alert("Запрещено исключать всех.");
            return false;
        }

        $fullCalendar.fullCalendar('removeEventSources');
        $fullCalendar.fullCalendar('refetchEvents');
        $fullCalendar.fullCalendar('addEventSource', PORTAL.activityUrl + '?' + $.param({users: usersId}));
        $fullCalendar.fullCalendar('refetchEvents');
    });
});