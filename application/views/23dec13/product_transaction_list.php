<div class="main-area dashboard">
	
		<div class="container">
			<?php if($this->session->flashdata('message')){ ?>   
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert" href="#">x</a>
                    <h4 class="alert-heading">Success:</h4>
                    <?php echo $this->session->flashdata('message'); ?>                
                    
                </div>
			<?php }?>
		<!--	<div class="row">
			
				<div class="span12">
				
					<div class="slate">
						<div class="content">
						 <?php echo form_open('','class=form-inline') ?>
							<input type="text" class="input-large" placeholder="Keyword..." name="product_name" value="<?php echo $srchProduct_name?>">
							<select>
								<option value=""> - From Date - </option>
							</select>
							<select>
								<option value=""> - To Date - </option>
							</select>
							<select>
								<option value=""> - Filter - </option>
							</select>
							<button type="submit" class="btn btn-primary">Filter Listings</button>
						</form>
						</div>
					</div>
				
				</div>
			
			</div>
		-->					

			<div class="row">
				
				
				
				<div class="span12">
				
					<div class="slate">
					
						<div class="page-header">
							<div class="pull-right listing-buttons">
				
                              <!--  <a href="<?php echo base_url();?>index.php/information/posting" class="btn btn-success">INSERT</a>
                            
                                <button class="btn btn-primary" onclick="deletemulti();">DELETE</button>-->
                            
                            </div>
							<h2>Product Transaction </h2>
						</div>
					<div class="content">
						<table class="orders-table table">
						<thead>
							<tr style=" width:10px;">
                             
                           		<th>Transaction Id</th>
                                <th>Order Id</th>
								<th>Product</th>
                                <th class="value">Status </th>
								<th class="actions">Actions</th>
                            
							</tr>
						</thead>
						<tbody>
                        	<?php foreach ($transactions as $transaction): ?>
                           <tr>
                             
							  	<td><?php echo $transaction['transaction_id']?></td>
                                <td><?php echo $transaction['order_id']?></td>
                              	<td><a href="form.html"><?php echo $transaction['product_name']?></a> <!--<span class="label label-info">Item Status</span>--><br /></td>
                               
								<td class="actions">
									<?php if($transaction['order_product_status_id']==6){?>
                                    	Complete
                                    <?php }else  if($transaction['order_product_status_id']==1){?>
                                    	Pending
                                    <?php }else  if($transaction['order_product_status_id']==5){?>
                                    	Processing
                                    <?php }else  if($transaction['order_product_status_id']==2){?>
                                    	Approved
                                    <?php }?>
								</td>
                                <td class="actions">
                                <?php if($transaction['order_product_status_id']==6){?>
                                	<a href="<?php echo base_url();?>index.php/transaction/releaseProductPayment/<?php echo $transaction['transaction_id']?>" class="btn btn-small btn-primary ">Release Payment</a>
                                <?php }else{?>
                                <span class="btn btn-small btn-primary disabled">Release Payment</span>
                                <?php }?>
                                </td>
							</tr>
							
							<?php endforeach ?><?php if(!$transactions){ ?>
                            <tr>
                            	<td colspan="4" style="text-align:center">Sorry No Record Found</td>
                            </tr>
                            <?php }?>
						</tbody>
						</table>
                        </div>
						<div id="pagination" class="pagination pull-left">
						</div>
					</div>
				
				</div>
				
				<div class="modal hide fade" id="removeItem">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Remove Item</h3>
					</div>
					<div class="modal-body">
						<p>Are you sure you would like to remove this item?</p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Close</a>
						<a href="#" class="btn btn-danger">Remove</a>
					</div>
				</div>
                
                <div class="modal hide fade" id="selectItem">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">×</button>
						<h3>Information</h3>
					</div>
					<div class="modal-body">
						<p>Select atleast one Item</p>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Ok</a>
					</div>
				</div>
			
			</div>
			
		</div>
	
	</div>
<script>
function checkall($this,$name){
	
		if($this.attr('checked'))
		$("input[name='"+$name+"']").attr('checked','checked');
		else
		$("input[name='"+$name+"']").removeAttr('checked');

}
function checkitem($this,$id){

		if($this.attr('checked'))
			$this.attr('checked','checked');
		else
			$this.removeAttr('checked');
			
		if($("input[name='"+$this.attr('name')+"'][checked='checked']").length == $("input[name='"+$this.attr('name')+"']").length)
			$("#"+$id).attr('checked','checked');
		else
			$("#"+$id).removeAttr('checked');

}
function deletemulti(){

	var information_id='';
	$i=0;
	$("input[name='info_id[]'][checked='checked']").each(function(){
		if($i==0)
		information_id+=$(this).val();
		else
		information_id+='--'+$(this).val();
		$i++;
	});
	if(information_id!='')
	{
		$('#removeItem .btn-danger').click(function () {
      		window.location.href ="<?php echo base_url();?>index.php/information/delete/"+information_id;
		 });
		 $('#removeItem').modal('toggle');
	}
	else
	 $('#selectItem').modal('toggle');
	
	
}

$(document).ready(function(){
	
	
$('a.remove-item').click(function () {
    var url = this.href;
    $('#removeItem .btn-danger').click(function () {
      window.location.href = url;
    });
	$('#removeItem').modal('toggle');
 });
  

});
</script>