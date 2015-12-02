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
 * </WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!WARNING!>
 */
function tableIt(response) {
    table_str = '';
    response.forEach(function(row,idx,list){
        extra = extraFields(row);
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
                "<td>" + extra     + "</td>\n"+
            "</tr>\n";
    });
    $('#tableBody').html(table_str);
}


var searchTimeout = null;

function doSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function(){
        doAjax('/contact/search', $('#searchInput'), {search: $('#searchInput').val()},
        function(response) {
            tableIt(response);
        });
    }, 700);
}


function contactIndex_setup() {
    // setup all events
    $('#searchInput').keyup(function() { doSearch(); });
    $('.btnEdit').click(    function(ev) { alert(ev); });
    $('.btnDelete').click(  function(ev) { alert(ev); });
}


// The end, my only friend, the end.
