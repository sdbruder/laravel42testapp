/*!
 * Contact.js
 * Copyright 2015 Sergio Bruder <sergio@bruder.com.br>
 * Licensed under the MIT license
 */


function doAjax(url, method, context, data, successFn) {
    $.ajax({
        type: method,
        url: url,
        context: $(context),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: data,
        dataType: 'json',
        success: successFn,
        error: function(xhr,textStatus, e) {
            console.log([textStatus, e]);
        }
    });
}


/*
 * concatenate extra fields
 *
 * @return string
 */
function extraFields(row) {
    fields =
        (row.field1 ? row.field1 + ', ': '') +
        (row.field2 ? row.field2 + ', ': '') +
        (row.field3 ? row.field3 + ', ': '') +
        (row.field4 ? row.field4 + ', ': '') +
        (row.field5 ? row.field5       : '');
    fields = fields.trim();
    if (fields.slice(-1) == ',') {
        fields = fields.slice(0,-1);
    }
    return fields;
}

/*
 * create one table row for each line returned
 *
 * <WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!>
 * Enormous multi-line strings!
 * Ugh! HTML MIXED IN JAVASCRIPT CODE!
 * Really, really UGLY. There is a cleaner way to do it ?
 * TODO: investigate JSON2HTML.COM if it can help.
 * </WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!>
 */
function tableIt(response) {
    table_str = '';
    response.forEach(function(row,idx,list){
        list[idx].extra = extraFields(row);
        table_str = table_str +
            "<tr>\n" +
                "<th>\n"+
                    "<span class=\"table-btns\">\n"+
                    "<button data-id=\"" + row.id + "\" class=\"btn btn-primary btn-sm btnEdit\">\n"+
                        "<span class=\"glyphicon glyphicon-pencil\"></span>\n"+
                    "</button>\n"+
                    "<button data-id=\"" + row.id + "\" class=\"btn btn-danger btn-sm btnDelete\">\n"+
                        "<span class=\"glyphicon glyphicon-trash\"></span>\n"+
                    "</button>\n"+
                    "</span>\n"+
                "</th>\n"+
                "<th>" + row.name  + " " + row.surname + "</th>\n"+
                "<td>" + row.email + "</td>\n"+
                "<td>" + row.phone + "</td>\n"+
                "<td>" + row.extra + "</td>\n"+
            "</tr>\n";
    });
    $('#tableBody').html(table_str);
    table_setup(); // re-connect the table's per-row events
}


var searchTimeout = null;

function doSearch(time) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function(){
        doAjax('/contact/search', 'POST', $('#searchInput'), {search: $('#searchInput').val()},
        function(response) {
            tableIt(response);
        });
    }, time);
    return false;
}

function errMessages(msgs,div) {
    errors = '';
    for(k in msgs) {
        errors += "<li>"+msgs[k][0]+"</li>\n";
    }
    $(div).html("<ul>"+errors+"</ul>");
    $(div).removeClass('hidden');
}

function callModal(modal, ev) {
    id = $(ev.currentTarget).data('id');
    $('#modal'+modal).data('id', id );
    $('#modal'+modal).modal([]);
}

// Ugly, there is a cleaner way of doing it ?
function fixExtraFieldsVisibility(modal,ajaxData) {
    // discover which is the last fieldN not empty.
    lastField = 0;
    for(i=5; i>0; i--) {
        if (ajaxData['field'+i].length > 0) {
            lastField = i;
            break;
        }
    }
    // fix it
    for (var i = 1; i <= lastField; ++i) $('#field'+modal+i).removeClass('hidden');
    $('#extraBtns'+modal).data('show', lastField);
}


function prepModal(modal) {
    $('#message'+modal).addClass('hidden');
    $('#form'+modal+' :input.clear').each( function(){ $(this).val(''); } );
    for (var i = 1; i <= 5; ++i) $('#field'+modal+i).addClass('hidden');
    $('#extraBtns'+modal).data('show', 0);
    // its an Update Modal, so we need to fetch the contact
    if (modal == 'UM') {
        id = $('#modal'+modal).data('id');
        doAjax('/contact/'+id+'/edit', 'GET', $('#form'+modal), '',
            function(response) {
                if (response[0] == 'ok') {
                    // for each 'clearable' field in the form get the correct value from the AJAX response
                    $('#form'+modal+' :input.clear').each( function(){
                        $(this).val(response[1][$(this).attr('name')]);
                    });
                    fixExtraFieldsVisibility(modal,response[1]);
                } else {
                    errMessages(response[1],'#message'+modal);
                }
        });
    }

}

function submitForm(url,modal) {
    if (modal=='UM') {
        url += $('#modal'+modal).data('id');
    }
    doAjax(url, 'POST', $('#form'+modal), $('#form'+modal).serialize(),
        function(response) {
            if (response[0] == 'ok') {
                doSearch(0);
                $('#modal'+modal).modal('hide');
            } else {
                errMessages(response[1],'#message'+modal);
            }
        });
    return false;
}


function extraFieldsModal(change, modal) {
    show = $('#extraBtns'+modal).data('show');
    if (change == 1) {
        if (show<5) {
            show += 1;
            $('#field'+modal+show).removeClass('hidden');
            $('#extraBtns'+modal).data('show', show);
        }
    } else {
        if (show>0) {
            $('#field'+modal+show).val('');
            $('#field'+modal+show).addClass('hidden');
            show -= 1;
            $('#extraBtns'+modal).data('show', show);
        }
    }
}

function prepEditModal() {
}

function updateButtonEditModal() {
}

function closeButtonEditModal() {
}

function prepDeleteModal() {
    id = $('#modalDelete').data('id');
    // if the ajax request is not fast enough this will be what the end user
    // will see in the modal Delete Box.
    $("#bodyModalDelete").html('...');
    doAjax('/contact/'+id+'/edit', 'GET', $('#modalDelete'), '', function(response) {
        if (response[0] == 'ok') {
            ef = extraFields(response[1]);
            ef = ef.length ? ' '+ef : '';
            $("#bodyModalDelete").html(
                "<p>Do you really want to delete contact:<br/>"+
                "<b>"+response[1]['name']+" "+response[1]['surname']+" "+
                "&lt;"+response[1]['email']+"&gt;</b>, "+
                "phone <b>"+response[1]['phone']+ef+"</b>?</p>"
            );
        } else {
            errMessages(response[1],'#message'+modal);
        }
    });

}


function deleteButtonDeleteModal() {
    id = $('#modalDelete').data('id');
    doAjax('contact/'+id, 'POST', $('#modalDelete'), {_method: 'DELETE'},
        function(response) {
            if (response[0] == 'ok') {
                doSearch(0);
                $('#modalDelete').modal('hide');
            } else {
                errMessages(response[1],'#message'+modal);
            }
        });
    return false;
}


function page_setup() {
    // Page events
    $('#search-form').submit(function()  { return doSearch(0);      });
    $('#searchInput').keyup(function()   { doSearch(700);           });

    // Insert Modal Events
    $('#modalIM').on('show.bs.modal',  function (e) { prepModal('IM');          });
    $('#modalIM').on('shown.bs.modal', function (e) { $('#firstIM').focus();    });
    $('#formIM').submit(     function(ev) { return submitForm('/contact','IM'); });
    $('#plusBtnIM').click(   function(ev) { extraFieldsModal(+1,'IM');          });
    $('#minusBtnIM').click(  function(ev) { extraFieldsModal(-1,'IM');          });

    // Update Modal Events
    $('#modalUM').on('show.bs.modal',  function (e) { prepModal('UM');                });
    $('#modalUM').on('shown.bs.modal', function (e) { $('#firstUM').focus();          });
    $('#formUM').submit(     function(ev) { return submitForm('/contact/','UM'); });
    $('#plusBtnUM').click(   function(ev) { extraFieldsModal(+1,'UM');                });
    $('#minusBtnUM').click(  function(ev) { extraFieldsModal(-1,'UM');                });

    // Delete Modal Events
    $('#modalDelete').on('show.bs.modal', function (e) { prepDeleteModal();         });
    $('#deleteBtn').click(                function(ev) { deleteButtonDeleteModal(); });
}


function table_setup() {
    // table's per-row events
    $('.btnEdit').click(    function(ev) { callModal('UM',     ev); });
    $('.btnDelete').click(  function(ev) { callModal('Delete', ev); });
}


function contactIndex_setup() {
    // setup all events ----------
    page_setup();   // Page events
    table_setup(); // Table events
}


// The end, my only friend, the end.
