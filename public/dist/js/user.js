// When the document is ready
$(document).ready(() => {
    
    //User activation/Deactivation/reset Password actions
    $(document).on("click", ".action", function() {
        var initialUrl = "status/actions";
        var action;
        switch ($(this).attr('btn-action')) {
            case "activate":
                action = { "id": $(this).attr('data-id'), "action": "Activated" }
                break;
            case "deactivate":
                action ={ "id": $(this).attr('data-id'), "action": "Deactivated" }
                break;
            case "reset":
                initialUrl = "reset";
                action ={ "id": $(this).attr('data-id') }
                break;
        
            default:
                break;
        }
        
        $.when(postActions(initialUrl, action).done(response => {
            location.reload();
        }).fail(error => {
            $(".alert-danger").removeClass("d-none");
            console.log(error)
        }))
    })

    $('#pdf-year').datepicker({
        minViewMode: 'years',
        autoclose: true,
            format: 'yyyy'
    });
    $('#profile-form').submit(function(e) {
        e.preventDefault();
        var actionUrl = "edit/profile";
        $('#profile-btn').html('Submiting...');
        $("#profile-btn").prop('disabled', true);
        $.ajax({
            url: actionUrl,
            type: "post",
            data: new FormData(this),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            cache: false,
            processData: false,
        })
        .done(response => {
            $('#profile-btn').html('Update Profile');
            $("#profile-btn").prop('disabled', false);
            location.reload();
        })
        .fail(error => {
            console.log(error);
        });
    });
});
