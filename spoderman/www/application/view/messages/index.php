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

    <h1>Messages</h1>

    <br>

    <?php echo $this->table; ?>

    <style type="text/css">
    	td.details-control {
    	    background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAC8UlEQVQ4ja2V32tbZRjHvxU6NgsaGOjidqNYqostFRLamrRpuuhwuuFEBAURFjdyEWFYeqmIN+KFXul/MJh1QoPVZUt/2HiaH/Zqsk6cBCdjmWkineBCm57kfLzomyyuib/wgS/PeZ/zvF845/m+31dqH/dI6pZ0rySXpL0GLlPrNj1/G12m+T5J+yU9Lskr6SkDr6ntNz3dZk9Hst2SHpDkiUQiJyzLShQKheuO49Qdx6kXCoXrlmUlIpHICUke07u7HWmXpD2SHpI0FI/Hz9i2vUWHsG17Kx6Pn5E0ZPb8ibRL0i5J+9xu91g+n78MsFHfYK6cZPLKaZ7/9lmO5A5zevVNvlr7kkqtAkA+n7/sdrvHJD1oOLoaA3BJGsjlchcAbm3d4oMf3+dwJswzmfB2zt55fu+Hd/m1WgYgk8mclzQg6f7GoHZJOhCLxaKO49Rtx+ad79/mkDVBeHmCsGWw3FiHCC+HmFqdxHZsHMepR6PRk5IOGC71SPKk0+mLAIulBcZTQcaXgoRSY4yngs1/F0qNEUoFGTd5fm0OAMuyEpIOGknJJclXLpfXAKYuTRFYCDC66CewECCw4G8Sji74GW28W/QzeektAEql0i9GUi5pW7D+Wq1WAzj2zTFGkkMMJ4c7DZmR5DAjyWGOW8cB2Nzc3DA63buD8OjSUbznfXgTvo6EvoQXX8LHkcXnAKhWq9VWQpck3/r6ehngVPYUg7NPMjg72MyNuLv+Rvpk20/ukeTJZrNzAOeuneOJmf47iPc3CT0zA82aZ6afT3+aBiCdTl80Q+nZIZuKXeGVr1/lsc8P/iVemH+R2/ZtHMepx2KxaKtsmsJeWVlJAlz7/WdeW3qd3uk+ej/r287TfTxq1i/Nv8zV364CkMvlLhhhuxrCbnv0ShslPl79hEOzT/PI2V4ePttL8IsJPvzuI25Wbt599Pa1Hr3/wxz2dHKcHfZVLBZvNIiKxeKNf2pfraTtDNZv8K8MtjX+8xXwB/u7lxJnK6nrAAAAAElFTkSuQmCC") no-repeat center center;
    	    cursor: pointer;
    	}
    	tr.shown td.details-control {
    	    background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAACz0lEQVQ4ja1VTUtbURA9FhRboQ0Iran+gVabEEmIGAwIYoyKIIK4EcQgpCWrFj927cKVS1ft3p0gWfnRKi4e0ZBWbLVC0LT1KyY1UTdGE19yTxfvxqZNQm3pwGHmzZ174DFn5gKF7RaAUgB3AOgAVEroZK5U1vzRSmTxXQDVAB4BMANolDDLXLWsKZV3ipKVA7gPoNblcg0qijIXDof3hRAZIUQmHA7vK4oy53K5BgHUytryQqQlAG4DeAjA6vV6p1RVvWIRU1X1yuv1TgGwyju/kJYAKANQpdfr7aFQaJMkxeUlLxYXeTI8zEhXF6OdnTx5/oKJ2VmKRIIkGQqFNvV6vR3AA8lRkm2ADoDB7/fPk2Tm7IxnExMMO508cjp51O5kuL2dR07Nn4yPMx2PkyRXVlZmARgA3Ms2qgxAjcfjcQshMkJVGX/1kgcOBw8cDh46WrW41XGdO3C0MjY6SqGqFEJk3G73EIAayYUKALU+n2+BJBPLy9xracnDrkRu7nxpiSSpKMocgMdSUtABsMRise8kGR0b49fm5hshMjJCkjw+Po5ISekATbC2dDqdJslvPT3csdu509RUrMnaud3O3d5ekmQymbyUOq3MI/zS08OgrZFBW2NRwmCjdh7q7iZJplKpVC6hDoDl9PQ0RpK7Hg+3rFZuWRt+osGqwarhs/S7z54W/OUKALWrq6vvSPJkZoYbZnM+LGZuWCzyW/Px6WmSpM/nW5BNqciTTSaR4PbAANfr67leb9K8SYs/muq5bjJx3WRisK+PmcQ5hRAZj8fjzpXNtbADgcBbkkzu7XF7aIhrRgPXDEZ+MBi12GjgmtHIYH8/L7a3SZJ+v39eCluXFXbB0buKxXj0+g03Ojr4vu4JA3V1/NTWxsPJSaYikd9Hryp39P7HcrhdbOPkra9oNHqYJYpGo4c3XV+5pIUWrE3irxZsrv3zE/ADANCaHGhx3oMAAAAASUVORK5CYII=") no-repeat center center;
    	}
    </style>

    <script>
        $(document).ready(function() {
        	function format ( d ) {
        	    // `d` is the original data object for the row
        	    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        	        '<tr>'+
        	            '<td>Message: </td>'+
        	            '<td>'+d.message+'</td>'+
        	        '</tr>'
        	    '</table>';
        	}

            var tti = [];
            var cc = [];
            var rr = [];
            var ii = 0;
            var dat = { data: <?php echo json_encode($this->messaged, JSON_PRETTY_PRINT) ?>};
            console.log(dat);
        	var tablesID=["message"];
        	for (var id in tablesID){
        		var tableID=tablesID[id];
        		console.log($('#'+tableID).length);
        		if($('#'+tableID).length){
        			var table = $('#'+tableID).DataTable({
                        "deferRender": true,
                        "ajax": function(data, callback, settings) {
                        		callback(dat);
                        	},
                        "columns" : [
                        	{
                        		"className":      'details-control',
								"orderable":      false,
                        		"data":           null,
                        		"defaultContent": ''
                        	},
                        	{ "data": "to" },
                        	{ "data": "from"},
                        	{ "data": "date_created" }
                        ],
                        "order": [[1, 'asc']]
        			});

        			$('#'+tableID).on('click', 'td.details-control', function () {
        			        var tr = $(this).closest('tr');
        			        var row = table.row( tr );
        			 		//TODO: Set up to show message elsewhere to avoid messing up table view.
        			        if ( row.child.isShown() ) {
        			            // This row is already open - close it
        			            row.child.hide();
        			            tr.removeClass('shown');
        			        }
        			        else {
        			            // Open this row
        			            row.child( format(row.data()) ).show();
        			            tr.addClass('shown');
        			        }
        			    } );
        		}
        	}
        } );
    </script>
</div>