<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-ticket">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-sm-6 ">
                <div id="msg" class=""></div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Customer</label>
                <input name="name" id="" class="form-control form-control-sm" value="<?php echo isset($name) ? $name : '' ?>" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Ticket For</label>
                <select name="pricing_id" id="pricing_id" class="form-control form-control-sm select2" required >
                  <option value=""></option>
                  <?php 
                    $ride['all'] = "All";
                    $ride[0] = "None";
                    $rides = $conn->query("SELECT * FROM rides order by ride asc");
                    while($row=$rides->fetch_assoc()){
                      $ride[$row['id']] = ucwords($row['ride']);
                    }
                    $pricing = $conn->query("SELECT * FROM pricing order by name asc");
                    while($row=$pricing->fetch_assoc()): 
                  ?>
                  <option value="<?php echo $row['id'] ?>" data-json='<?php echo json_encode($row) ?>' <?php echo isset($pricing_id) && $pricing_id == $row['id'] ?"selected": ""  ?>><?php echo ucwords($row['name'].'('.$ride[$row['ride_id']].')') ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>
            <input type="hidden" name="adult_price" value="<?php echo isset($adult_price) ? $adult_price : '' ?>">
            <input type="hidden" name="child_price" value="<?php echo isset($child_price) ? $child_price : '' ?>">
            <input type="hidden" name="ride_id" value="<?php echo isset($ride_id) ? $ride_id : '' ?>">
            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">No. Adult</label>
                <input name="no_adult" id="" class="form-control form-control-sm number text-right" value="<?php echo isset($no_adult) ? $no_adult : 0 ?>" onfocus="$(this).select()" onkeyup="update_tbl()" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">No. Child</label>
                <input name="no_child" id="" class="form-control form-control-sm number text-right" value="<?php echo isset($no_child) ? $no_child : 0 ?>" onfocus="$(this).select()" onkeyup="update_tbl()" required>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-condensed">
                  <thead>
                    <th>Type</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Pax</th>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Adult</th>
                      <td class="text-right" id="aprice">0.00</td>
                      <td class="text-right" id="apax">0</td>
                    </tr>
                    <tr>
                      <th>Child</th>
                      <td class="text-right" id="cprice">0.00</td>
                      <td class="text-right" id="cpax">0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Amount to Pay</label>
                  <input type="text" class="form-control form-control-sm text-right number" id="amount" name="amount" readonly="" required>
                </div>
                <div class="form-group">
                  <label for="">Amount Tendered</label>
                  <input type="text" class="form-control form-control-sm text-right number" id="tendered" name="tendered" onkeyup="calc_change()" value="<?php echo isset($tendered) ? number_format($tendered) : '' ?>" required>
                </div>
                <div class="form-group">
                  <label for="">Change</label>
                  <input type="text" class="form-control form-control-sm text-right number" id="change" value="0" readonly="" required>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-ticket">Save</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=ticket_list">Cancel</a>
  		</div>
  	</div>
	</div>
</div>
<script>
  $('#pricing_id').change(function(){
    var id = $(this).val()
    var data = $(this).find('option[value="'+id+'"]').attr('data-json')
        data = JSON.parse(data)
        $('[name="adult_price"]').val(data.adult_price)
        $('[name="child_price"]').val(data.child_price)
        $('#aprice').text(parseFloat(data.adult_price).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))
        $('#cprice').text(parseFloat(data.child_price).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))
        $('[name="ride_id"]').val(data.ride_id)
        calc()
  })
  function update_tbl(){
    var na = $('[name="no_adult"]').val()
    var nc = $('[name="no_child"]').val()
    $('#apax').text(na)
    $('#cpax').text(nc)
    calc()
  }
  function calc(){
      var aprice = $('#aprice').text() > 0 ? $('#aprice').text() : 0;
      var cprice = $('#cprice').text() > 0 ? $('#cprice').text() : 0;
      var apax = $('#apax').text() > 0 ? $('#apax').text() : 0;
      var cpax = $('#cpax').text() > 0 ? $('#cpax').text() : 0;

      var amount = (parseFloat(aprice)*parseFloat(apax)) + (parseFloat(cprice)*parseFloat(cpax))
        $('#amount').val(parseFloat(amount).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))
        calc_change()
  }

  function calc_change(){
      var amount = $('#amount').val();
      var tendered = $('#tendered').val();
          amount = amount.replace(/,/g,'')
          tendered = tendered.replace(/,/g,'')
          amount = amount > 0 ? amount : 0;
          tendered = tendered > 0 ? tendered : 0;
      var change = parseFloat(tendered) - parseFloat(amount) 
        $('#change').val(parseFloat(change).toLocaleString("en-US",{style:"decimal",minimumFractionDigits:2,maximumFractionDigits:2}))

  }
  $(document).ready(function(){
  if('<?php echo isset($id) ?>' == 1)
    $('#pricing_id').trigger('change')
    $('[name="no_child"],[name="no_adult"]').trigger('keyup')
  })
	$('#manage-ticket').submit(function(e){
		e.preventDefault()
		start_load()
    $('#msg').html('')
    var amount = $('#amount').val();
    var tendered = $('#tendered').val();
        amount = amount.replace(/,/g,'')
        tendered = tendered.replace(/,/g,'')
        amount = amount > 0 ? amount : 0;
        tendered = tendered > 0 ? tendered : 0;
      if(parseFloat(amount) > parseFloat(tendered)){
        alert_toast("Tendered Amount must be greater than or equal to amount to pay.",'error')
        end_load()
        return false;
      }
		$.ajax({
			url:'ajax.php?action=save_ticket',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
        if(resp){
          resp = JSON.parse(resp)
  				if(resp.status == 1){
  					alert_toast('Data successfully saved',"success");
  					var nw = window.open("print_ticket.php?id="+resp.id,"","height=700,width=900")
            nw.print()
            setTimeout(function(){
              nw.close()
              location.reload()
            },750)
  				}else if(resp.status ==2){
            $('#msg').html('<div class="alert alert-danger">ticket for selected ride and given ticket for already exist.</div>')
            end_load()
          }
        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>