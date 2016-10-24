<style>
.blog-wrap{width:100%; float:left; margin-top:30px;}
.blog-left{width:50%; float:left; text-align:left;}

.blog-first-client{width:100%; float:left; margin-top:20px;}
.blog-imge{width:12%; float:left;}
.blog-chat{width:70%;float:left;border:1px solid #e2e2e2; border-radius:4px 4px 0px 0px; margin-left:12px; background:#f3f3f3;}
.client-details{width:97%; float:left; border-bottom:1px solid #e2e2e2; padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000;}
.client-name{width:30%; float:left;}
.client-date{width:36%; float:right;}
.client-desptn{background: none repeat scroll 0 0 #FFFFFF;float: left;height:100%;width: 97%;padding:10px;}
.client-desptn label{border:none; width:100%; padding:10px; }
.blog-imge img{width:100%; height:100%;}
.blog-chat-onwer{width:70%;float:left;border:1px solid #e2e2e2; border-radius:4px 4px 0px 0px; margin-left:12px; background:#ECECC6;}
.blog-first-onwer{width:100%; float:left; margin-top:20px;}

.blog-right{ width:30%; float:right; text-align:left; border:1px solid #e2e2e2; background:#f0f0f0; border-radius:5px; margin-top:20px;}

</style>
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
							<h2>Resolve Dispute</h2>
						</div>
					<div class="content">
						<table  class="orders-table table">
						
						<tbody>
                        	<?php foreach ($desputes as $despute): ?>
                            <tr>
                             <td>Dispute id</td>
                             <td colspan="2" ></td>
                              <td class="actions" width="150px"><?php echo $despute['despute_id']?></td>
                             </tr>
                           <tr>
                           	 <td>Order Product Id</td>
                             <td colspan="2" ></td>
                             <td class="actions"><?php echo $despute['order_product_id']?></td>
                           </tr>
                           <tr>
                           	 <td>Payer Amount</td>
                             <td colspan="2" ></td>
                             <td class="actions"><?php echo $despute['payer_amount']?></td>
                           </tr>
                            <tr>
                           	 <td>Payee Amount</td>
                             <td colspan="2" ></td>
                             <td class="actions"><?php echo $despute['payee_amount']?></td>
                           </tr>
                           
                          <tr>
                          <td colspan="4">
                          	<b>Negotitions :</b>
                          	<?php foreach($messages as $message):?>
	
							<?php if($message['payer_id']==$message['sender_id']){?>
                          
                                <div class="blog-first-client">
                                    <div class="blog-imge"><img src="<?php echo base_url().'../'.$message['photo']?>" /></div>
                                    <div class="blog-chat">
                                    <div class="client-details">
                                    <div class="client-name"><?php echo $message['sender_name']?></div>
                                    <div class="client-date"><?php echo $message['added_on']?></div>
                                    </div>
                                    <div class="client-desptn"><label><?php echo $message['message_body']?> </label></div>
                                    
                                    </div>
                                </div>
                            <?php }else{?>
                            <div class="blog-first-onwer">
                            <div class="blog-imge"><img src="<?php echo base_url().'../'.$message['photo']?>" /></div>
                            <div class="blog-chat-onwer">
                            <div class="client-details">
                            <div class="client-name"><?php echo $message['sender_name']?></div>
                            <div class="client-date"><?php echo $message['added_on']?></div>
                            </div>
                            <div class="client-desptn"><?php echo $message['message_body']?></div>
                            
                            </div>
                            </div>
                            <?php }?>
                        <?php endforeach;?>
                          </td>
                         </tr>
                           <tr>
                              <td>Resolve Dispute in favour of:<br /><textarea id="message" name="message"></textarea></td>
                              <td> <?php echo form_open() ?><input type="submit" name="in_favour" value="payer" ><input type="hidden" name="message" id="payer_message" /></form></td>
                              <td> <?php echo form_open() ?><input type="submit" name="in_favour" value="payee" ><input type="hidden" name="message" id="payee_message" /></form></td>
                             <td class="actions">
                              <?php echo form_open() ?>
                             Transfer to payee<input type="text" value="" name="in_favour" placeholder="$ amount" > <input type="hidden" name="message" id="custom_message" /> <input type="submit" value="ok" />
                             </form>
                             </td>
						  </tr>
							
							<?php endforeach ?><?php if(!$despute){ ?>
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
	$(document).ready(function(){
	$("#message").blur(function(){
		$("input[name='message']").val($("#message").val());
	});
	});
	</script>