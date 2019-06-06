$(".devicesToggleButton").click(function() {
    var deviceId = $(this).data("id");

    //set bool to see if radiobutton is checked or not.
    if($(this).is(':checked'))
    {
        var checked = 1;
    }
    else
    {
        var checked = 0;
    }

    $.ajax({
        url: "/ajax/device/setActiveOrInactive",
        method: 'get',
        data: { id : deviceId, setactive: checked },
        success: function( $result) {

        }
    });
});