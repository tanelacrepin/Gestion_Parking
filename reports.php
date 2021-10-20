<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<div class="d-flex w-100 px-1 py-2 justify-content-center align-items-center">
			<?php 
			$status_arr = array("Item Accepted by Courier","Collected","Shipped","In-Transit","Arrived At Destination","Out for Delivery","Ready to Pickup","Delivered","Picked-up","Unsuccessfull Delivery Attempt"); ?>
				<label for="date_from" class="mx-1">From</label>
                <input type="date" id="date_from" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_from']) ? date("Y-m-d",strtotime($_GET['date_from'])) : '' ?>">
                <label for="date_to" class="mx-1">To</label>
                <input type="date" id="date_to" class="form-control form-control-sm col-sm-3" value="<?php echo isset($_GET['date_to']) ? date("Y-m-d",strtotime($_GET['date_to'])) : '' ?>">
                <button class="btn btn-sm btn-primary mx-1 bg-gradient-primary" type="button" id='view_report'>View Report</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
        					<button type="button" class="btn btn-success float-right" style="display: none" id="print"><i class="fa fa-print"></i> Print</button>
						</div>
					</div>	
					
					<table class="table table-bordered" id="report-list">
						<thead>
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Customer</th>
								<th>Ticket For</th>
								<th>Adult Ticket</th>
								<th>Adult Price</th>
								<th>Child Ticket</th>
								<th>Child Price</th>
								<th>Total Amount</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot>
							<th colspan="8">Total Sale</th>
							<th id="total" class="text-right"></th>
						</tfoot>
					</table>
				</div>
			</div>
			
		</div>
	</div>
</div>
<noscript>
	<style>
		table.table{
			width:100%;
			border-collapse: collapse;
		}
		table.table tr,table.table th, table.table td{
			border:1px solid;
		}
		.text-cnter{
			text-align: center;
		}
		.text-right{
			text-align: right;
		}
	</style>
</noscript>
<div class="details d-none">
	<h3 class="text-center"><b>Report as of <span id="drange"></span></b></h3>
	</div>
<script>
	function load_report(){
		start_load()
		var date_from = $('#date_from').val()
		var date_to = $('#date_to').val()
		var status = $('#status').val()
			var dates = moment(date_from).format("MMM-D-YYYY") + ' - ' + moment(date_to).format("MMM-D-YYYY")
			$('#drange').text(dates)
			$.ajax({
				url:'ajax.php?action=get_report',
				method:'POST',
				data:{status:status,date_from:date_from,date_to:date_to},
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error')
					end_load()
				},
				success:function(resp){
					if(typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) === 'object'){
						resp = JSON.parse(resp)
						if(Object.keys(resp).length > 0){
							$('#report-list tbody').html('')
							var i =1;
							var total = 0 ;
							Object.keys(resp).map(function(k){
								var tr = $('<tr></tr>')
								tr.append('<td>'+(i++)+'</td>')
								tr.append('<td>'+(resp[k].date_created)+'</td>')
								tr.append('<td>'+(resp[k].name)+'</td>')
								tr.append('<td>'+(resp[k].ticket_for)+'</td>')
								tr.append('<td>'+(resp[k].no_adult)+'</td>')
								tr.append('<td>'+(resp[k].adult_price)+'</td>')
								tr.append('<td>'+(resp[k].no_child)+'</td>')
								tr.append('<td>'+(resp[k].child_price)+'</td>')
								tr.append('<td class="text-right">'+(resp[k].amount)+'</td>')
								var amount = resp[k].amount.replace(/,/g,'')
								amount = amount > 0 ? amount : 0;
								total = parseFloat(total) + parseFloat(amount)
								$('#report-list tbody').append(tr)
							})
							$('#total').text(parseFloat(total).toLocaleString('en-US',{style:'decimal',minimumFractionDigits:2,maximumFractionDigits:2}))
							$('#print').show()
						}else{
							$('#report-list tbody').html('')
								var tr = $('<tr></tr>')
								tr.append('<th class="text-center" colspan="9">No result.</th>')
								$('#report-list tbody').append(tr)
							$('#total').text('0.00')
							$('#print').hide()
						}
					}
				}
				,complete:function(){
					end_load()
				}
			})
	}
$('#view_report').click(function(){
	if($('#date_from').val() == '' || $('#date_to').val() == ''){
		alert_toast("Please select dates first.","error")
		return false;
	}
	load_report()
	var date_from = $('#date_from').val()
	var date_to = $('#date_to').val()
	var target = './index.php?page=reports&filtered&date_from='+date_from+'&date_to='+date_to
	window.history.pushState({}, null, target);
})

$(document).ready(function(){
	if('<?php echo isset($_GET['filtered']) ?>' == 1)
	load_report()
})
$('#print').click(function(){
		start_load()
		var ns = $('noscript').clone()
		var details = $('.details').clone()
		var content = $('#report-list').clone()
		ns.append(details)
		ns.append(content)
		var nw = window.open('','','height=700,width=900')
		nw.document.write(ns.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			nw.close()
			end_load()
		},750)

	})
</script>