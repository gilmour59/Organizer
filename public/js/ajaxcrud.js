    $(document).on('click', 'a.page-link', function (event) {
        event.preventDefault();
        ajaxLoad($(this).attr('href'));
    });

    $(document).on('submit', '#addFileForm', function(event) {
        event.preventDefault();

        var form = $(this);
        var data = new FormData(this);
        var url = form.attr("action");
        var type = form.attr("method");

        $.ajax({
            type: type,
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
            },
            success: function(data){
                $('.is-invalid').removeClass('is-invalid');
                if (data.fail) {
                    for (control in data.errors) {
                        $('#' + control).addClass('is-invalid');
                        $('#error-' + control).html(data.errors[control]);
                    }
                } else {
                    $('#addFile').modal('hide');
                    $("#addFileForm")[0].reset();
                    
                    //Modal Bug Fix
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    console.log(data.redirect_url);
                    ajaxLoad(data.redirect_url);
                } 
            }
        })
        return false;
    }); 

    $(document).on('submit', '#editFileForm', function(event) {
        event.preventDefault();

        var form = $(this);
        var data = new FormData(this);
        var url = form.attr("action");
        var type = form.attr("method");

        $.ajax({
            type: type,
            url: url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            error: function (xhr, textStatus, errorThrown) {
                alert("Error: " + errorThrown);
            },
            success: function(data){
                $('.is-invalid').removeClass('is-invalid');
                if (data.fail) {
                    for (control in data.errors) {
                        $('#' + control).addClass('is-invalid');
                        $('#error-' + control).html(data.errors[control]);
                    }
                } else {
                    $('#editFile').modal('hide');
                    $("#editFileForm")[0].reset();
                    
                    //Modal Bug Fix
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();

                    console.log(data);
                    ajaxLoad(data.redirect_url);
                } 
            }
        })
        return false;
    }); 

    //THIS GETS THE WEBPAGE AND SENDS IT TO 'ajax.blade.php' (dataType: html)
    function ajaxLoad(filename, content) {
        content = typeof content !== 'undefined' ? content : 'content';
        $('.loading').show();
        $.ajax({
            type: 'GET',
            url: filename,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#" + content).html(data);
                $('.loading').hide();
            }
        })
    }

    function ajaxDelete(filename, token, content) {
        content = typeof content !== 'undefined' ? content : 'content';
        $('.loading').show();
        $.ajax({
            type: 'POST',
            data: {_method: 'DELETE', _token: token},
            url: filename,
            success: function (data) {
                $("#" + content).html(data);
                $('.loading').hide();
                console.log(data.test);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

    function ajaxEdit(filename) {
        $('.loading').show();
        $.ajax({
            type: 'GET',
            url: filename,
            success: function (data) {
                console.log(data.data.date);
                $('#editDate').val(data.data.date);
                $('#editTo').val(data.data.to);
                $('#editFrom').val(data.data.from);
                $('#editName').val(data.data.name);
                $('#editSubject').val(data.data.subject);
                $('#editLetter').val(data.data.letter);
                $('#editFileForm').attr('action', '/update/'+data.data.id);
                console.log($('#editFileForm').attr('action'));
                $('.loading').hide()
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }
    
    function moveCursorToEnd(input) {
        var originalValue = input.val();
        input.val('');
        input.blur().focus().val(originalValue);
    }