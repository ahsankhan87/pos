var TableAdvanced = function () {

    var initTable1 = function () {
        var table = $('#sample_1');

        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */

        /* Set tabletools buttons and button container */
        var oTable = table.dataTable({
            "order": [
                [0, 'desc']
            ],
            
            "language": {
                "url": path+"/assets/plugins/datatables/extensions/lang/"+lang+".json"
            },

            "lengthMenu": [
                [20, 50, 100, -1],
                [20, 50, 100, "All"] // change per page values here
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
                    messageBottom: 'Powered by: <i>khybersoft.com </i>'
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>khybersoft.com </i></span>',
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
                    targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    var initTable2 = function () {
        var table = $('#sample_2');

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
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                //pageTotal.toFixed(2) +' ('+ total.toFixed(2) +' total)'
                pageTotal.toFixed(2)
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
            //buttons: ['copy', 'excel', 'pdf'],
            // set the initial value
            "pageLength": 20,
            //dom: "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
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
                    messageBottom: 'Powered by: <i>khybersoft.com </i>'
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>khybersoft.com </i></span>',
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 0,
                    visible: false
                } ],
            
        });

        var tableWrapper = $('#sample_2_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //////////
 
  //FOR SALES REPORTS USAGES
 var initTable_journal_entry = function () {
        var table = $('#journal_entry');

        var oTable = table.dataTable({
            
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
            
           pageTotal_4 = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            // Total over this page
            pageTotal_5 = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(parseFloat(a)) + intVal(parseFloat(b));
                }, 0 );
            
            // Update footer
            $( api.column( 4 ).footer() ).html(
                pageTotal_4.toFixed(2)
            );
            
            $( api.column( 5 ).footer() ).html(
                pageTotal_5.toFixed(2)
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
                    messageBottom: 'Powered by: <i>khybersoft.com </i>'
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
                    messageBottom: '<span style="text-align:center;">Powered by: <i>khybersoft.com </i></span>',
                },
                'colvis'
            ],
            columnDefs: [ {
                    targets: 0,
                    // visible: false
                } ],
            
        });

        var tableWrapper = $('#sample_customer_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
 
 //////////

    //////////
    var initTable3 = function () {
        var table = $('#sample_3');

        /* Formatting function for row details */
        function fnFormatDetails(oTable, nTr) {
            var aData = oTable.fnGetData(nTr);
            var sOut = '<table>';
            sOut += '<tr><td>Platform(s):</td><td>' + aData[2] + '</td></tr>';
            sOut += '<tr><td>Engine version:</td><td>' + aData[3] + '</td></tr>';
            sOut += '<tr><td>CSS grade:</td><td>' + aData[4] + '</td></tr>';
            sOut += '<tr><td>Others:</td><td>Could provide a link here</td></tr>';
            sOut += '</table>';

            return sOut;
        }

        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement('th');
        nCloneTh.className = "table-checkbox";

        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<span class="row-details row-details-close"></span>';

        table.find('thead tr').each(function () {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        table.find('tbody tr').each(function () {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });

        /*
         * Initialize DataTables, with no sorting on the 'details' column
         */
        var oTable = table.dataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [0]
            }],
            "order": [
                [1, 'asc']
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
        });
        var tableWrapper = $('#sample_3_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        table.on('click', ' tbody td .row-details', function () {
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                $(this).addClass("row-details-close").removeClass("row-details-open");
                oTable.fnClose(nTr);
            } else {
                /* Open this row */
                $(this).addClass("row-details-open").removeClass("row-details-close");
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });
    }

    var initTable4 = function () {
        var table = $('#sample_4');

        /* Formatting function for row expanded details */
        function fnFormatDetails(oTable, nTr) {
            var aData = oTable.fnGetData(nTr);
            var sOut = '<table>';
            sOut += '<tr><td>Platform(s):</td><td>' + aData[2] + '</td></tr>';
            sOut += '<tr><td>Engine version:</td><td>' + aData[3] + '</td></tr>';
            sOut += '<tr><td>CSS grade:</td><td>' + aData[4] + '</td></tr>';
            sOut += '<tr><td>Others:</td><td>Could provide a link here</td></tr>';
            sOut += '</table>';

            return sOut;
        }

        /*
         * Insert a 'details' column to the table
         */
        var nCloneTh = document.createElement('th');
        nCloneTh.className = "table-checkbox";
        
        var nCloneTd = document.createElement('td');
        nCloneTd.innerHTML = '<span class="row-details row-details-close"></span>';

        table.find('thead tr').each(function () {
            this.insertBefore(nCloneTh, this.childNodes[0]);
        });

        table.find('tbody tr').each(function () {
            this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
        });

        var oTable = table.dataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [0]
            }],
            "order": [
                [1, 'asc']
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,
        });

        var tableWrapper = $('#sample_4_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        var tableColumnToggler = $('#sample_4_column_toggler');

        /* modify datatable control inputs */
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown

        /* Add event listener for opening and closing details
         * Note that the indicator for showing which row is open is not controlled by DataTables,
         * rather it is done here
         */
        table.on('click', ' tbody td .row-details', function () {
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                $(this).addClass("row-details-close").removeClass("row-details-open");
                oTable.fnClose(nTr);
            } else {
                /* Open this row */
                $(this).addClass("row-details-open").removeClass("row-details-close");
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });

        /* handle show/hide columns*/
        $('input[type="checkbox"]', tableColumnToggler).change(function () {
            /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var iCol = parseInt($(this).attr("data-column"));
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis(iCol, (bVis ? false : true));
        });
    }

    var initTable5 = function () {

        var table = $('#sample_5');

        /* Fixed header extension: http://datatables.net/extensions/lang/scroller/ */

        var oTable = table.dataTable({
            "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // datatable layout without  horizobtal scroll
            "scrollY": "300",
            "deferRender": true,
            "order": [
                [0, 'asc']
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "pageLength": 10 // set the initial value            
        });


        var tableWrapper = $('#sample_5_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    var initTable6 = function () {

        var table = $('#sample_6');

        /* Fixed header extension: http://datatables.net/extensions/lang/keytable/ */

        var oTable = table.dataTable({
            "order": [
                [0, 'asc']
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "pageLength": 10, // set the initial value,
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ]           
        });

        //var oTableColReorder = new $.fn.dataTable.ColReorder( oTable );

        var tableWrapper = $('#sample_6_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            initTable1();
            initTable2();
            initTable_journal_entry();//self defined function by ahsan
            initTable3();
            initTable4();
            initTable5();
            initTable6();
        }

    };

}();