<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin edit Clubcontact
## *****************************************************************
?>

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create(null ,array('controller'=>'clubs', 'action'=>'editcontact', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('ClubContact.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit contact</h5><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'contact')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
			<div class="rowElem noborder"><label>Club:</label>
			<div class="formRight">
                   
				<?php  echo $this->Form->select('ClubContact.club_id',$clubs,array('empty'=>'-- Select Club --','class'=>'topAction','id'=>'BranchClubId','style'=>'width:50%','onchange'=>'getBranchList()')); ?>

			</div><div class="fix"></div>
			</div>	
			
			<div class="rowElem noborder"><label>Branch:</label>
			<div id="branchesID" class="formRight">
                   
				<?php  echo $this->Form->select('ClubContact.branch_id',$branches,array('empty'=>'-- Select Club --','class'=>'topAction','id'=>'branchesID','style'=>'width:50%')); ?>

			</div><div class="fix"></div>
			</div>	
		
		
			<div class="rowElem noborder"><label>Title<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('ClubContact.title', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('ClubContact.title', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
		
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('ClubContact.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('ClubContact.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			
			
			
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('ClubContact.phone', array('maxlength'=>255)); ?>

				<?php echo $this->Form->error('ClubContact.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('ClubContact.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('ClubContact.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
			<div class="rowElem noborder"><label>Mobile:</label><div class="formRight">

				<?php echo $this->Form->text('ClubContact.mobile', array('maxlength'=>255)); ?>

				<?php echo $this->Form->error('ClubContact.mobile', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
					
						
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'contact')); ?>">CANCEL</a>
			<div class="fix"></div>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
<div class="fix"></div>
</div>
</div>
<style>
.divFormCon .divRow .divColm2 {
    float: left;
    width: 490px;
}
.checkBoxList {
    width: 330px;
}
.whiteBoxWrap {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DBDBDB;
    padding: 22px 30px;
}
.checkBoxList .checkListCon {
    float: left;
    width: 350px;
}

.checkBoxList .checkListCon li {
    float: left;
    width: 30%;
}
.checkListCon ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
.checkListCon li {
    color: #818181;
    display: block;
    font-size: 12px;
    list-style-type: none;
    margin: 0 0 5px;
    padding: 0;
	float:left;
	width:40%;
}
.checkListCon li input {
    margin-right: 5px;
    vertical-align: middle;
}
</style>

<script>
	$(document).ready(function(){			
		$('#datepicker').datepicker({
			inline: true,
			changeMonth: true,
            changeYear: true,
            maxDate: '-1',
            dateFormat: 'mm-dd-yy',
            yearRange:'-100:+0'
		});	
		
		
	});
	
</script>
