<div class="main-area dashboard">
	
		<div class="container">
			<?php if($this->session->flashdata('message')){ ?>   
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert" href="#">x</a>
                    <h4 class="alert-heading">Success:</h4>
                    <?php echo $this->session->flashdata('message'); ?>                
                    
                </div>
			<?php }?>
			<div class="row">
			
				<div class="span12">
				
					<div class="slate">
						<div class="content">
						 <?php echo form_open('','class=form-inline') ?>
							<input type="text" class="input-large" placeholder="Keyword..." name="customer_name" value="<?php echo $customer_name?>">
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
			
			<div class="row">
				
				
				
				<div class="span12">
				
					<div class="slate">
					
						<div class="page-header">
							<div class="pull-right listing-buttons">
				
                                <a href="<?php echo base_url();?>index.php/customer/insert" class="btn btn-success">INSERT</a>
                            
                                <button class="btn btn-primary" onclick="deletemulti();">DELETE</button>
                            
                            </div>
							<h2>Customer </h2>
						</div>
					<div class="content">
						<table class="orders-table table">
						<thead>
							<tr style=" width:10px;">
                             <th><input type="checkbox" value="customer_all" id="all" onclick="checkall($(this),'supp_id[]');" ></th>
                           
								<th>Customer Name</th>
                                <th class="value">Status </th>
								<th class="actions">Actions</th>
                            
							</tr>
						</thead>
						<tbody>
                        	<?php  foreach ($customers as $customer): ?>
                           <tr>
                             <td style=" width:10px;"><input type="checkbox" value="<?php echo $customer['customer_id']?>" name="supp_id[]" onclick="checkitem($(this),'all')"></td>
							  <td><a href="form.html"><?php echo $customer['customer_name'] ?></a> <!--<span class="label label-info">Item Status</span>--><br /><span class="meta"><?php echo $customer['date_added']?></span></td>
                                <td class="value">
									<?php echo $customer['customer_status']?>
								</td>
								<td class="actions">
									<a class="btn btn-small btn-danger remove-item" data-toggle="modal"  href="<?php echo base_url();?>index.php/customer/deletecustomer/<?php echo $customer['customer_id']?>">Remove</a>
									<a class="btn btn-small btn-primary" href="<?php echo base_url();?>index.php/customer/updatecustomer/<?php echo $customer['customer_id']?>">Edit</a>
								</td>
							</tr>
							
							<?php endforeach ?><?php if(!$customers){ ?>
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

	var customer_id='';
	$i=0;
	$("input[name='supp_id[]'][checked='checked']").each(function(){
		if($i==0)
		customer_id+=$(this).val();
		else
		customer_id+='--'+$(this).val();
		$i++;
	});
	if(customer_id!='')
	{
		$('#removeItem .btn-danger').click(function () {
      		window.location.href ="<?php echo base_url();?>index.php/customer/delete/"+customer_id;
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
  
<?php 
if(isset($_GET['page']))
$page=$_GET['page'];
else
$page=1;
if(isset($customer_name) && $customer_name!='')
$customer_name='&customer_name='.$customer_name;
else
$customer_name='';
?>
	
		
 var options = {
            currentPage: <?php echo $page;?>,
            totalPages: <?php echo $page_total?>,
			pageUrl: function(type, page, current){

                return "<?php echo base_url();?>index.php/customer?page="+page+"<?php echo $customer_name?>";

            },
			itemTexts: function (type, page, current) {
                    switch (type) {
                    case "first":
                        return "First";
                    case "prev":
                        return "Previous";
                    case "next":
                        return "Next";
                    case "last":
                        return "Last";
                    case "page":
                        return page;
                    }
                },
			shouldShowPage:function(type, page, current){
                switch(type)
                {
                    case "first":
                    case "last":
                        return false;
                    default:
                        return true;
                }
            }
        }

        $('#pagination').bootstrapPaginator(options);
});
</script>