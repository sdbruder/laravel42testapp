/*!
 * Contact.js
 * Copyright 2015 Sergio Bruder <sergio@bruder.com.br>
 * Licensed under the MIT license
 */


function doAjax(url, context, data, successFn) {
    $.ajax({
        type: 'POST',
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
}


var searchTimeout = null;

function doSearch(time) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function(){
        doAjax('/contact/search', $('#searchInput'), {search: $('#searchInput').val()},
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

function callModal(modalId, ev) {
    $(modalId).data('id',  $(ev.currentTarget).data('id') );
    $(modalId).modal([]);
}

function prepModal(modal) {
    $('#message'+modal).addClass('hidden');
    $('#form'+modal+' :input.clear').each( function(){ $(this).val(''); } );
    for (var i = 1; i <= 5; ++i) $('#field'+modal+i).addClass('hidden');
    $('#extraBtns'+modal).data('show', 0);
}

function submitForm(url,modal) {
    doAjax(url, $('#form'+modal), $('#form'+modal).serialize(),
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
}

function deleteButtonDeleteModal() {
}

function cancelButtonDeleteModal() {
}

function contactIndex_setup() {
    // setup all events -------------------------------------------------------

    // Page events
    $('#search-form').submit(function()  { return doSearch(0);            });
    $('#searchInput').keyup(function()   { doSearch(700);                 });
    $('.btnEdit').click(    function(ev) { callModal('#editModal',   ev); });
    $('.btnDelete').click(  function(ev) { callModal('#deleteModal', ev); });

    // Insert Modal Events
    $('#modalIM').on('show.bs.modal',  function (e) { prepModal('IM');          });
    $('#modalIM').on('shown.bs.modal', function (e) { $('#firstIM').focus();    });
    $('#formIM').submit(     function(ev) { return submitForm('/contact','IM'); });
    $('#plusBtnIM').click(   function(ev) { extraFieldsModal(+1,'IM');          });
    $('#minusBtnIM').click(  function(ev) { extraFieldsModal(-1,'IM');          });

    // Update Modal Events
    $('#modalUM').on('show.bs.modal',  function (e) { prepModal('UM');                });
    $('#modalUM').on('shown.bs.modal', function (e) { $('#firstUM').focus();          });
    $('#formUM').submit(     function(ev) { return submitForm('/contact/{$id}','UM'); });
    $('#plusBtnUM').click(   function(ev) { extraFieldsModal(+1,'IM');                });
    $('#minusBtnUM').click(  function(ev) { extraFieldsModal(-1,'IM');                });

    // Delete Modal Events
    $('#deleteModal').on('show.bs.modal', function (e) { prepDeleteModal(); });
    $('#deleteBtnDM').click( function(ev) { deleteButtonDeleteModal(); });
    $('#cancelBtnDM').click( function(ev) { cancelButtonDeleteModal(); });

}


// The end, my only friend, the end.
