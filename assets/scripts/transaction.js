var Transaction = function () {

 var sample_sales = function () {
    
        var table = $('#sample_sales');

        var oTable = table.dataTable({
            
            "ajax":{
                    "url": site_url+"/trans/C_sales/get_sales_JSON",
                    "dataSrc": ""
                },

            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

            "columns": [
                        { "data": "invoice_no" },
                        { "data": "sale_date" },
                        { "data": "customer" },
                        { "data": "account" },
                        { "data": "net_amount" },
                        { "data": "customer_id" }
                        
                    ],
            "createdRow": function( nRow, aData, iDisplayIndex ) {
                            
                $('td:eq(4)', nRow).html(parseFloat(aData['net_amount']).toFixed(2));
                $('td:eq(4)', nRow).addClass('text-right');

                $('td:eq(5)', nRow).html('<a href="'+site_url+'/trans/C_sales/editSales/' + aData['invoice_no'] + 
                                '" title="Edit Sales" ><i class=\'fa fa-pencil-square-o fa-fw\'></i></a>'+
                                ' | <a href="'+site_url+'/trans/C_sales/receipt/' + aData['invoice_no'] + 
                                '" title="Print Invoice" target="_blank" ><i class=\'fa fa-print fa-fw\'></i></a>'+
                                ' | <a href="'+site_url+'/trans/C_sales/ubl_xml_receipt/' + aData['invoice_no'] + 
                                '" title="XML Invoice" target="_blank" >xml</a>'+
                                ' | <a href="'+site_url+'/trans/C_sales/send_email_inv/'+ aData['customer_id'] + '/' + aData['invoice_no'] + 
                                '" title="Email Invoice">Email</a>'
                                // DELETE SALES BUTTON
                                // +' | <a href="'+
                                // site_url+'/trans/C_sales/delete/' + aData['invoice_no'] +  
                                // '" onclick="return confirm(\'Are you sure you want to permanent delete? All entries will be deleted permanently\')"; title="Permanent Delete"><i class=\'fa fa-trash-o fa-fw\'></i></a>'
                                );
                            
                            return nRow;
                        },
            
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Dr,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                    
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                //pageTotal.toFixed(2)
            );
        },
        
            "order": [
                [1, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            buttons: [
                    'copy', 'excel', 'pdf'
                ],
            // set the initial value
            "pageLength": 20,
            dom: 'Bflrtip',
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    //messageTop: 'The information in this table is copyright to khybersoft Inc.'
                },
                {
                    extend: 'pdf',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    messageBottom: 'Powered by: khybersoft.com'
                },
                {
                    extend: 'print',
                    key: 'p',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: '',
                    autoPrint:false,
                    messageTop:function(){
                             var header = '<p style="text-align:center; font-size:18px;color:#999;">';
                                 //header += '<img src="'+path+'images/company/thumb/company_logo.jpg" style="height:100px; left:100px;" />';
                                 header += $('.company_name').text()+'</p>';
                                 header += '<p style="font-size:14px">'+  $('#print_title').text() +"</p>";
                                
                             return  header;
                          },
                    messageBottom: '<span style="text-align:center;">Powered by: khybersoft.com</span>',
                    //customize: function (win) {
//                            $(win.document.body)
//                                .css( 'font-size', '10pt' )
//                                .prepend(
//                                    '<img src="'+path+'images/company/thumb/company_logo.jpg" style="position:absolute; top:0; left:0;" />'
//                                );
//         
//                            $(win.document.body).find( 'table' )
//                                .addClass( 'compact' )
//                                .css( 'font-size', 'inherit' );
//                                    
//                                }
                },
                'colvis'
            ],
            columnDefs: [ {
                    "type": "html",
                    targets: 1,
                    // visible: false
                } ],
                
        });

        var tableWrapper = $('#sample_sales_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
////////////

var sample_estimate = function () {
    
        var table = $('#sample_estimate');

        var oTable = table.dataTable({
            
            "ajax":{
                    "url": site_url+"/trans/C_estimate/get_estimate_JSON",
                    "dataSrc": ""
                },
            
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

            "columns": [
                        { "data": "invoice_no" },
                        { "data": "sale_date" },
                        { "data": "customer" },
                        { "data": "net_amount" },
                        { "data": "sale_id" },
                        //{ "data": "amount" },
                       // { "data": "sale_id" }
                        
                    ],
            "createdRow": function( nRow, aData, iDisplayIndex ) {
                            //<a href="'+site_url+'/trans/C_estimate/editestimate/' + aData['invoice_no'] + 
                            //'" title="Edit estimate" ><i class=\'fa fa-pencil-square-o fa-fw\'></i></a> | 
                            $('td:eq(3)', nRow).html(parseFloat(aData['net_amount']).toFixed(2));
                            $('td:eq(3)', nRow).addClass('text-right');
            
                                $('td:eq(4)', nRow).html('<a href="'+
                                site_url+'/trans/C_sales/index/cash/'
                                + aData['customer_id'] +'/' + aData['invoice_no'] + '" title="Transfer to sales" >Transfer</a> | <a href="'+
                                site_url+'/trans/C_estimate/receipt/' + aData['invoice_no'] + 
                                '" title="Print Invoice" ><i class=\'fa fa-print fa-fw\'></i></a> | <a href="'+
                                site_url+'/trans/C_estimate/delete/' + aData['invoice_no'] +  
                                '" onclick="return confirm(\'Are you sure you want to permanent delete? All entries will be deleted permanently\')"; title="Permanent Delete"><i class=\'fa fa-trash-o fa-fw\'></i></a>');
                            
                            return nRow;
                        },
            
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Dr,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                    
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                //pageTotal.toFixed(2)
            );
        },
        
            "order": [
                [1, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            buttons: [
                    'copy', 'excel', 'pdf'
                ],
            // set the initial value
            "pageLength": 20,
            dom: 'Bflrtip',
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    //messageTop: 'The information in this table is copyright to khybersoft Inc.'
                },
                {
                    extend: 'pdf',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    messageBottom: 'Powered by: khybersoft.com'
                },
                {
                    extend: 'print',
                    key: 'p',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: '',
                    autoPrint:false,
                    messageTop:function(){
                             var header = '<p style="text-align:center; font-size:18px;color:#999;">';
                                 //header += '<img src="'+path+'images/company/thumb/company_logo.jpg" style="height:100px; left:100px;" />';
                                 header += $('.company_name').text()+'</p>';
                                 header += '<p style="font-size:14px">'+  $('#print_title').text() +"</p>";
                                
                             return  header;
                          },
                    messageBottom: '<span style="text-align:center;">Powered by: khybersoft.com</span>',
                    //customize: function (win) {
//                            $(win.document.body)
//                                .css( 'font-size', '10pt' )
//                                .prepend(
//                                    '<img src="'+path+'images/company/thumb/company_logo.jpg" style="position:absolute; top:0; left:0;" />'
//                                );
//         
//                            $(win.document.body).find( 'table' )
//                                .addClass( 'compact' )
//                                .css( 'font-size', 'inherit' );
//                                    
//                                }
                },
                'colvis'
            ],
            columnDefs: [ {
                    "type": "html",
                    targets: 1,
                    // visible: false
                } ],
                
        });

        var tableWrapper = $('#sample_estimate_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
////////////

var sample_purchaseorders = function () {
    
    var table = $('#sample_purchaseorders');

    var oTable = table.dataTable({
        
        "ajax":{
                "url": site_url+"/trans/C_purchaseOrders/get_purchases_JSON",
                "dataSrc": ""
            },
        
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

        "columns": [
            { "data": "invoice_no" },
            { "data": "receiving_date" },
            { "data": "supplier" },
            //{ "data": "emp" },
            { "data": "net_amount" },
            { "data": "receiving_id" }  //{ "data": "amount" },
                   // { "data": "sale_id" }
                    
                ],
        "createdRow": function( nRow, aData, iDisplayIndex ) {
                        //<a href="'+site_url+'/trans/C_purchaseOrders/editpurchaseorders/' + aData['invoice_no'] + 
                        //'" title="Edit purchaseorders" ><i class=\'fa fa-pencil-square-o fa-fw\'></i></a> | 
                $('td:eq(3)', nRow).html(parseFloat(aData['net_amount']).toFixed(2));
                $('td:eq(3)', nRow).addClass('text-right');
                $('td:eq(4)', nRow).html('<a href="'+
                            site_url+'/trans/C_purchaseOrders/receipt/' + aData['invoice_no'] + 
                            '" title="Print Invoice" ><i class=\'fa fa-print fa-fw\'></i></a> | <a href="'+
                            site_url+'/trans/C_purchaseOrders/delete/' + aData['invoice_no'] +  
                            '" onclick="return confirm(\'Are you sure you want to permanent delete? All entries will be deleted permanently\')"; title="Permanent Delete"><i class=\'fa fa-trash-o fa-fw\'></i></a>');
                        
                        return nRow;
                    },
        
        "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\Dr,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
                
        };

        // Total over all pages
        total = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );

        // Update footer
        $( api.column( 4 ).footer() ).html(
            //pageTotal.toFixed(2)
        );
    },
    
        "order": [
            [1, 'desc']
        ],
        "lengthMenu": [
            [20, 50, 100, -1],
            [20, 50, 100, "All"] // change per page values here
        ],
        buttons: [
                'copy', 'excel', 'pdf'
            ],
        // set the initial value
        "pageLength": 20,
        dom: 'Bflrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: function(){
                         return $('#print_title').text(); 
                      },
                //messageTop: 'The information in this table is copyright to khybersoft Inc.'
            },
            {
                extend: 'pdf',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: function(){
                         return $('#print_title').text(); 
                      },
                messageBottom: 'Powered by: khybersoft.com'
            },
            {
                extend: 'print',
                key: 'p',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: '',
                autoPrint:false,
                messageTop:function(){
                         var header = '<p style="text-align:center; font-size:18px;color:#999;">';
                             //header += '<img src="'+path+'images/company/thumb/company_logo.jpg" style="height:100px; left:100px;" />';
                             header += $('.company_name').text()+'</p>';
                             header += '<p style="font-size:14px">'+  $('#print_title').text() +"</p>";
                            
                         return  header;
                      },
                messageBottom: '<span style="text-align:center;">Powered by: khybersoft.com</span>',
                //customize: function (win) {
//                            $(win.document.body)
//                                .css( 'font-size', '10pt' )
//                                .prepend(
//                                    '<img src="'+path+'images/company/thumb/company_logo.jpg" style="position:absolute; top:0; left:0;" />'
//                                );
//         
//                            $(win.document.body).find( 'table' )
//                                .addClass( 'compact' )
//                                .css( 'font-size', 'inherit' );
//                                    
//                                }
            },
            'colvis'
        ],
        columnDefs: [ {
                "type": "html",
                targets: 1,
                // visible: false
            } ],
            
    });

    var tableWrapper = $('#sample_purchaseorders_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
    tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
}
////////////

 var sample_receivings = function () {
    
        var table = $('#sample_receivings');

        var oTable = table.dataTable({
            
            "ajax":{
                    "url": site_url+"/trans/C_receivings/get_purchases_JSON",
                    "dataSrc": ""
                },
            
                "language": {
                    "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
                },
    
            "columns": [
                        //{ "data": "receiving_id" },
                        { "data": "invoice_no" },
                        { "data": "receiving_date" },
                        { "data": "supplier_invoice_no" },
                        { "data": "supplier" },
                        { "data": "account" },
                        { "data": "total_amount" },
                        { "data": "total_tax" },
                        { "data": "net_amount" },
                        { "data": "file" }
                    ],
            "createdRow": function( nRow, aData, iDisplayIndex ) {
                            
                $('td:eq(5)', nRow).html(parseFloat(aData['total_amount']).toFixed(2));
                $('td:eq(5)', nRow).addClass('text-right');
                
                $('td:eq(6)', nRow).html(parseFloat(aData['total_tax']).toFixed(2));
                $('td:eq(6)', nRow).addClass('text-right');
                
                $('td:eq(7)', nRow).html((parseFloat(aData['net_amount'])).toFixed(2));
                $('td:eq(7)', nRow).addClass('text-right');
                if(!aData['file'])
                {
                    var file = '<a href="'+site_url+'/trans/C_receivings/upload_purchase_file/' + aData['invoice_no'] + 
                    '" data-invoice_no="' + aData['invoice_no'] +'" id="purchaseFile" title="Upload file" ><i class=\'fa fa-file fa-fw\'></i></a>';
                }else{
                    var file = '<a href="'+path+'images/purchases/'+aData['file']+'" target="_blank" data-file="' + aData['file'] +'" data-invoice_no="' + aData['invoice_no'] +'" id="show_purchase_file" title="Show File" ><i class=\'fa fa-image\'></i></a>'
                }
                $('td:eq(8)', nRow).html('<a href="'+
                                site_url+'/trans/C_receivings/receipt/' + aData['invoice_no'] + 
                                '" title="Print Invoice" ><i class=\'fa fa-print fa-fw\'></i></a> | '+
                                '<a href="'+
                                site_url+'/trans/C_receivings/delete/' + aData['invoice_no'] +  
                                '" onclick="return confirm(\'Are you sure you want to permanent delete? All entries will be deleted permanently\')"; title="Permanent Delete"><i class=\'fa fa-trash-o fa-fw\'></i></a> | '+
                                file);
                            
                            return nRow;
                        },
            
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Dr,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
                    
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                //pageTotal.toFixed(2)
            );
        },
        
            "order": [
                [1, 'desc']
            ],
            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
            ],
            buttons: [
                    'copy', 'excel', 'pdf'
                ],
            // set the initial value
            "pageLength": 20,
            dom: 'Bflrtip',
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    //messageTop: 'The information in this table is copyright to khybersoft Inc.'
                },
                {
                    extend: 'pdf',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: function(){
                             return $('#print_title').text(); 
                          },
                    messageBottom: 'Powered by: khybersoft.com'
                },
                {
                    extend: 'print',
                    key: 'p',
                    footer:true,
                    exportOptions: {
                            columns: ':visible'
                            },
                    title: '',
                    autoPrint:false,
                    messageTop:function(){
                             var header = '<p style="text-align:center; font-size:18px;color:#999;">';
                                 //header += '<img src="'+path+'images/company/thumb/company_logo.jpg" style="height:100px; left:100px;" />';
                                 header += $('.company_name').text()+'</p>';
                                 header += '<p style="font-size:14px">'+  $('#print_title').text() +"</p>";
                                
                             return  header;
                          },
                    messageBottom: '<span style="text-align:center;">Powered by: khybersoft.com</span>',
                    //customize: function (win) {
//                            $(win.document.body)
//                                .css( 'font-size', '10pt' )
//                                .prepend(
//                                    '<img src="'+path+'images/company/thumb/company_logo.jpg" style="position:absolute; top:0; left:0;" />'
//                                );
//         
//                            $(win.document.body).find( 'table' )
//                                .addClass( 'compact' )
//                                .css( 'font-size', 'inherit' );
//                                    
//                                }
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 1,
                    // visible: false
                } ],
                
        });

        var tableWrapper = $('#sample_receivings_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
////////////
 //FOR SALES REPORTS USAGES
 var account_detail = function () {
    var table = $('#account_detail');

    var oTable = table.dataTable({
        
        "language": {
            "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
        },

        //GET TOTAL AT FOOTER OF GRID
        "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\Cr,\Dr,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
                
        };

        // Total over all pages
        total = api
        .column( 6 )
        .data()
        .reduce( function (a, b) {
            var x = parseFloat(a) || 0;
            var y = parseFloat(b) || 0;
            
            return intVal(parseFloat(a)) + intVal(parseFloat(b));
        }, 0 );
    
            // Total over this page
            pageTotal_3 = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
                
            // Total over this page
            pageTotal_4 = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            pageTotal_5 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            
            // Update footer
            $( api.column( 3 ).footer() ).html(
                pageTotal_3.toFixed(2)
            );
            
            $( api.column( 4 ).footer() ).html(
                pageTotal_4.toFixed(2)
            );
            
            
            $( api.column( 5 ).footer() ).html(
                (pageTotal_3-pageTotal_4).toFixed(2)
            );
    
    
    },
    ///////////////////////////
    
        "order": [
            [0, 'desc']
        ],
        "lengthMenu": [
            [20, 50, 100, -1],
            [20, 50, 100, "All"] // change per page values here
        ],
        "pageLength": 20,
        dom: 'Bflrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: function(){
                         return $('#print_title').text(); 
                      },
                //messageTop: 'The information in this table is copyright to khybersoft Inc.'
            },
            {
                extend: 'pdf',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: function(){
                         return $('#print_title').text(); 
                      },
                messageBottom: 'Powered by: khybersoft.com'
            },
            {
                extend: 'print',
                key: 'p',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: '',
                autoPrint:false,
                messageTop:function(){
                         var header = '<p style="text-align:center; font-size:18px;color:#999;">';
                             //header += '<img src="'+path+'images/company/thumb/company_logo.jpg" style="height:100px; left:100px;" />';
                             header += $('.company_name').text()+'</p>';
                             header += '<p style="font-size:14px">'+  $('#print_title').text() +"</p>";
                            
                         return  header;
                      },
                messageBottom: '<span style="text-align:center;">Powered by: khybersoft.com</span>',
            },
            'colvis'
        ],
        columnDefs: [ {
                targets: 0,
                // visible: false
            } ],
        
    });

    var tableWrapper = $('#account_detail_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
    tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
}

//////////


var expenses = function () {
    
    var table = $('#expenses');

    var oTable = table.dataTable({
        
        "ajax":{
                "url": site_url+"/trans/C_expenses/get_expenses_JSON",
                "dataSrc": ""
            },
        
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

        "columns": [
                    //{ "data": "receiving_id" },
                    { "data": "invoice_no" },
                    { "data": "payment_date" },
                    { "data": "supplier_invoice_no" },
                    { "data": "title" },
                    { "data": "amount" },
                    { "data": "tax_amount" },
                    { "data": "net_amount" },
                    { "data": "invoice_no" }
                    
                ],
        "createdRow": function( nRow, aData, iDisplayIndex ) {
            $('td:eq(4)', nRow).html(parseFloat(aData['amount']).toFixed(2));
            $('td:eq(4)', nRow).addClass('text-right');
            $('td:eq(6)', nRow).addClass('text-right');
            
                $('td:eq(5)', nRow).html(parseFloat(aData['tax_amount']).toFixed(2));
                $('td:eq(5)', nRow).addClass('text-right');
                
                $('td:eq(6)', nRow).html((parseFloat(aData['net_amount'])).toFixed(2));
                $('td:eq(6)', nRow).addClass('text-right');
                

                        $('td:eq(7)', nRow).html('<a href="'+
                            site_url+'/trans/C_expenses/receipt/' + aData['invoice_no'] + 
                            '" title="Print Invoice" ><i class=\'fa fa-print fa-fw\'></i></a> | <a href="'+
                            site_url+'/trans/C_expenses/delete/' + aData['invoice_no'] +  
                            '" onclick="return confirm(\'Are you sure you want to permanent delete?\')"; title="Permanent Delete"><i class=\'fa fa-trash-o fa-fw\'></i></a>');
                        
                        return nRow;
                    },
        
        "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\Dr,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
                
        };

        // Total over all pages
        total = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(parseFloat(a)) + intVal(parseFloat(b));
            }, 0 );

        // Update footer
        $( api.column( 5 ).footer() ).html(
            //pageTotal.toFixed(2)
        );
    },
    
        "order": [
            [1, 'desc']
        ],
        "lengthMenu": [
            [20, 50, 100, -1],
            [20, 50, 100, "All"] // change per page values here
        ],
        buttons: [
                'copy', 'excel', 'pdf'
            ],
        // set the initial value
        "pageLength": 20,
        dom: 'Bflrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: function(){
                         return $('#print_title').text(); 
                      },
                //messageTop: 'The information in this table is copyright to khybersoft Inc.'
            },
            {
                extend: 'pdf',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: function(){
                         return $('#print_title').text(); 
                      },
                messageBottom: 'Powered by: khybersoft.com'
            },
            {
                extend: 'print',
                key: 'p',
                footer:true,
                exportOptions: {
                        columns: ':visible'
                        },
                title: '',
                autoPrint:false,
                messageTop:function(){
                         var header = '<p style="text-align:center; font-size:18px;color:#999;">';
                             //header += '<img src="'+path+'images/company/thumb/company_logo.jpg" style="height:100px; left:100px;" />';
                             header += $('.company_name').text()+'</p>';
                             header += '<p style="font-size:14px">'+  $('#print_title').text() +"</p>";
                            
                         return  header;
                      },
                messageBottom: '<span style="text-align:center;">Powered by: khybersoft.com</span>',
                //customize: function (win) {
//                            $(win.document.body)
//                                .css( 'font-size', '10pt' )
//                                .prepend(
//                                    '<img src="'+path+'images/company/thumb/company_logo.jpg" style="position:absolute; top:0; left:0;" />'
//                                );
//         
//                            $(win.document.body).find( 'table' )
//                                .addClass( 'compact' )
//                                .css( 'font-size', 'inherit' );
//                                    
//                                }
            },
            'colvis'
        ],
        columnDefs: [ {
                targets: 1,
                // visible: false
            } ],
            
    });

    var tableWrapper = $('#expenses_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
    tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
}
////////////

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }
            expenses();
            sample_sales();
            sample_purchaseorders();
            sample_estimate();
            sample_receivings();
            account_detail();
        }

    };

}();