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
							<h2>Dispute List</h2>
						</div>
					<div class="content">
						<table class="orders-table table">
						<thead>
							<tr style=" width:10px;">
                             
                           		<th>Dispute Id</th>
                                <th>Order Product Id</th>
								<th class="actions">Payer amount</th>
                                <th class="actions">Payee amount</th>
                                <th class="value">Status </th>
								<th class="actions">Actions</th>
                            
							</tr>
						</thead>
						<tbody>
                        	<?php foreach ($desputes as $despute): ?>
                           <tr>
                             
							  	<td><?php echo $despute['despute_id']?></td>
                                <td><?php echo $despute['order_product_id']?></td>
                              	<td class="actions"><?php echo $despute['payer_amount']?></td>
                               <td class="actions"><?php echo $despute['payee_amount']?></td>
								<td class="actions">
									<?php if($despute['despute_status']==1){?>
                                    	on going
                                    <?php }else  if($despute['despute_status']==2){?>
                                    	closed
                                    <?php }else  if($despute['despute_status']==3){?>
                                    	resolved
                                    <?php }else  if($despute['despute_status']==4){?>
                                    	Approved
                                    <?php }?>
								</td>
                                <td class="actions">
                                <?php if($despute['despute_status']==2){?>
                                	<a href="<?php echo base_url();?>index.php/despute/update/<?php echo $despute['despute_id']?>" class="btn btn-small btn-primary ">Resolve</a>
                                <?php }else{?>
                                <span class="btn btn-small btn-primary disabled">Resolve</span>
                                <?php }?>
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