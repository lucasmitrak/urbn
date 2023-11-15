<div class="container">
<link rel="stylesheet" type="text/css" href="<?php echo Config::get('URL'); ?>css/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Config::get('URL'); ?>css/responsive.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo Config::get('URL'); ?>css/buttons.dataTables.min.css"/>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('URL'); ?>scripts/dataTables.select.min.js"></script>
<div id="excellinker" datalink="<?php echo Config::get('URL'); ?>table/index"></div>



    <h1>Tables</h1>

<?php
$search = REQUEST::post('btnFTM');
if(!empty($search)):
?>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Timeline Message Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/getTimelineCsv" method="post">
        	<input type="submit" class="login-submit-button" value="Download Timeline"/>
		<input type="text" name="txtFTM" value="<?php echo REQUEST::post('txtFTM'); ?>" readonly />
        </form>

    </div>
<?php endif; ?>

<?php
$search = REQUEST::post('btnFTC');
if(!empty($search)):
?>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Timeline Comments Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/getTimelineCommentsCsv" method="post">
            <input type="submit" class="login-submit-button" value="Download Timeline Comments"/>
	    <input type="text" name="txtFTC" value="<?php echo REQUEST::post('txtFTC'); ?>" readonly />
        </form>
    </div>
<?php endif; ?>

<?php
$search = REQUEST::post('btnMIDC');
if(!empty($search)):
?>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>MIDC Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/getMIDCCsv" method="post">
            <input type="submit" class="login-submit-button" value="Download MIDC"/>
	    <input type="text" name="txtMFN" value="<?php echo REQUEST::post('txtMFN'); ?>" readonly />
	    <input type="text" name="txtMLN" value="<?php echo REQUEST::post('txtMLN'); ?>" readonly />
        </form>
    </div>

<?php endif; ?>

<?php
$search = REQUEST::post('btnMC');
if(!empty($search)):
?>
    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Macomb County Jail Search</h3>
        <form action="<?php echo Config::get('URL'); ?>table/getMCCsv" method="post">
            <input type="submit" class="login-submit-button" value="Download MC"/>
	    <input type="text" name="txtMCFN" value="<?php echo REQUEST::post('txtMCFN'); ?>" readonly />
	    <input type="text" name="txtMCLN" value="<?php echo REQUEST::post('txtMCLN'); ?>" readonly />
        </form>
    </div>

<?php endif; ?>

<br>
<?php echo $this->table; ?>
<br>

<script>
$(document).ready(function() {

    var tti = [];
    var cc = [];
    var rr = [];
    var ii = 0;
    var etti = [];
    var ecc = [];
    var err = [];
    var eii = 0;
	var tablesID=["message", "comment", "midc", "midcmarks", "midcsentences", "midcaliases", "mc", "mcsentences", "mcaliases", "oc", "ocreleased", "cr", "crnotes", "twitter", "name"];
	for (var id in tablesID){
		var tableID=tablesID[id];
		if($('#'+tableID).length){
            var minCol = {};
            var colDef = [];
            var tabledataId = "";
            if(tableID == 'message') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [2, 4, 5, 6, 8, 9, 10, 12, 16],
                    hide: [0, 1, 3, 7, 11, 13, 14, 15]
                };
                colDef = [
                        {
                            "targets": [0, 1, 3, 7, 11, 13, 14, 15],
                            "visible": false
                        }
                    ];
                tabledataId = 'message';
            } else if (tableID == 'comment') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [3, 5, 6],
                    hide: [0, 1, 2, 4, 7, 8, 9, 10]
                };
                colDef = [
                        {
                            "targets": [0, 1, 2, 4, 7, 8, 9, 10],
                            "visible": false
                        }
                    ];
                tabledataId = 'comment';
            } else if (tableID == 'midc') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19, 20, 21, 23, 24],
                    hide: [0, 1, 16, 22]
                };
                colDef = [
                        {
                            "targets": [0, 1, 16, 22],
                            "visible": false
                        }
                    ];
                tabledataId = 'midc';
            } else if (tableID == 'midcmarks') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [0, 1],
                    hide: []
                };
                tabledataId = 'midcmarks';
            } else if (tableID == 'midcsentences') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    hide: [0]
                };
                colDef = [
                        {
                            "targets": [0],
                            "visible": false
                        }
                    ];
                tabledataId = 'midcsentences';
            } else if (tableID == 'name') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                    hide: [0]
                };
                colDef = [
                        {
                            "targets": [0],
                            "visible": false
                        }
                    ];
                tabledataId = 'name';
            } else if (tableID == 'midcaliases') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [0, 1],
                    hide: []
                };
                tabledataId = 'midcaliases';
            } else if (tableID == 'mc') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [2, 3, 4, 5, 6, 7, 8, 9, 13, 14],
                    hide: [0, 1, 10, 11, 12]
                };
                colDef = [
                        {
                            "targets": [0, 1, 10, 11, 12],
                            "visible": false
                        }
                    ];
                tabledataId = 'mc';
            } else if (tableID == 'mcsentences') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [3, 4, 5, 6, 7, 8, 9, 10, 11],
                    hide: [0, 1, 2]
                };
                colDef = [
                        {
                            "targets": [0, 1, 2],
                            "visible": false
                        }
                    ];
                tabledataId = 'mcsentences';    
            } else if (tableID == 'mcaliases') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [3, 4, 5, 6, 7],
                    hide: [0, 1, 2]
                };
                colDef = [
                        {
                            "targets": [0, 1, 2],
                            "visible": false
                        }
                    ];
                tabledataId = 'mcaliases';
            } else if (tableID == 'oc') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13],
                    hide: [0, 1, 12]
                };
                colDef = [
                        {
                            "targets": [0, 1, 12],
                            "visible": false
                        }
                    ];
                tabledataId = 'oc';
            } else if (tableID == 'ocreleased') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [2, 3, 4, 5, 6, 7, 8, 9, 10,],
                    hide: [0, 1, 11]
                };
                colDef = [
                        {
                            "targets": [0, 1, 11],
                            "visible": false
                        }
                    ];
                tabledataId = 'ocreleased';
            } else if (tableID == 'cr') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [2, 3, 4, 5, 6, 7, 8, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 35, 36, 37, 38, 40, 41],
                    hide: [0, 1, 9, 10, 11, 12, 34, 39, 42]
                };
                colDef = [
                        {
                            "targets": [0, 1, 9, 10, 11, 12, 34, 39, 42],
                            "visible": false
                        }
                    ];
                tabledataId = 'cr';
            } else if (tableID == 'twitter') {
                minCol = {
                    extend: 'colvisGroup',
                    text: 'Default View',
                    show: [0],
                    hide: []
                };
                tabledataId = 'twitter';
            }
			$('#'+tableID).DataTable({
                "lengthMenu": [[10,25,50,100], [10,25,50,100]],
                "columnDefs": colDef,
                "deferRender": true,
                dom: 'Bfrtip',
                buttons: [
                    'colvis',
                    minCol,
                    {
                        extend: 'colvisGroup',
                        text: 'Show All',
                        show: ':hidden'
                    },
                    {
                        text: 'Export Selected Excel',
                        action: function(e, dt, node, config) {
                            var elinker = document.getElementById("excellinker").getAttribute("datalink");
                            var drows = dt.rows({selected: true}).data();
                            var dcolumns = dt.columns().header();
                            var nrows = [];
                            var ncolumns = [];
                            for (var i = dt.rows({selected: true}).data().length - 1; i >= 0; i--) {
                                //console.log(drows[i]);
                                nrows[i] = drows[i];
                            };
                            for (var i = dcolumns.length - 1; i >= 0; i--) {
                                ncolumns[i] = dcolumns[i].innerHTML;
                            };
                            tableNameLink = "download_" + dt.table().node().id;
                            document.getElementById(tableNameLink).hidden = true;
                            if(nrows.length < 58) {
                                $.ajax({
                                    url: elinker,
                                    type: "POST",
                                    data: {
                                        data: {table: tableNameLink,rows: nrows, columns: ncolumns}
                                    },
                                    timeout: 0,
                                    success: function(data) {
                                        console.log(data);
                                        document.getElementById((data.BtnName+"_fName")).value = data.FileName;
                                        document.getElementById(data.BtnName).href = elinker;
                                        document.getElementById(data.BtnName).hidden = false;
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log("ERROR\n");
                                        console.log(jqXHR);
                                        console.log(textStatus);
                                        console.log(errorThrown);
                                    }
                                });
                            } else {
                                alert("Too many rows selected, can't be more than 57 rows selected\nWe're working on a solution");
                            }
                            /*
                            $.post(elinker, { data: {table: tableNameLink,rows: nrows, columns: ncolumns}}, function (data, status, xhr) {
                                console.log(data);
                                console.log(status);
                                console.log(xhr);
                                document.getElementById((data.BtnName+"_fName")).value = data.FileName;
                                document.getElementById(data.BtnName).href = elinker;
                                document.getElementById(data.BtnName).hidden = false;
                            });*/
                        }
                    },
                    {
                        text: 'Select Current Page',
                        action: function(e, dt, node, config) {
                            dt.rows({page: 'current'}).select();
                        }
                    },
                    'selectAll',
                    'selectNone'
                ],
                select: {
                    style: 'multi'
                }
			});
		}
	}
} );
</script>
