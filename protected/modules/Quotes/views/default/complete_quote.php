<!------------------------------------------- POP UP forms end -------------------------------------->

<div class="pageheader">
  <div class="media">
    <div class="media-body">
      <ul class="breadcrumb">
        <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Quotes</li>
      </ul>
      <h4><?php echo CHtml::link(
                Yii::t("Buildings.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-primary pull-right")
 ); ?></h4>
    </div>
  </div>
  <!-- media --> 
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>
<div class="contentpanel">
  <div class="row">
    <?php foreach($post_values_model as $buiding_single_row) { ?>
    <div class="col-md-12 quote_section">
      <div class="panel panel-default">
        <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
          <h2>Building : <?php echo $buiding_single_row['building_name']; ?></h2>
        </div>
      </div>
      <div class="col-md-12"> <strong>Special Instruction for STAFF / CONTRACTOR</strong> :
        <?php if(isset($buiding_single_row['si_staff_contractor'])) echo $buiding_single_row['si_staff_contractor']; ?>
        <br/>
        <strong>Special Instruction for CLIENT</strong> :
        <?php if(isset($buiding_single_row['si_client'])) echo $buiding_single_row['si_client']; ?>
        <br/>
        <br/>
        <div class="table-responsive">
          <table width="100%" border="0" align="center" class="table table-bordered mb30 quote_table">
            <tr>
              <th   width="50%" class="head">Description</th>
              <th   width="10%" class="head">Quantity</th>
              <th   width="10%" class="head">Rate</th>            
              <th   width="10%" class="head">Total</th>
              <th  width="19%" class="head">Photo</th>
            </tr>

<?php $quote_building_service_total = 0;
foreach($buiding_single_row['BuildingServices'] as $ServiceRow) { 
$quote_building_service_total += $ServiceRow->total; ?>
            <tr>
              <td><?php echo $ServiceRow->service_description; ?></td>
              <td><?php echo $ServiceRow->quantity; ?></td>
              <td><?php echo $ServiceRow->unit_price_rate; ?></td>            
              <td><?php echo $ServiceRow->total; ?></td>
              <td><?php $path = Yii::app()->basePath.'/../uploads/quote-building-service/';			
	if(isset($ServiceRow->image) && $ServiceRow->image !=NULL && file_exists($path.$ServiceRow->image))	 { ?>
                <img height="120" src="<?php echo Yii::app()->getBaseUrl(true)."/uploads/quote-building-service/".$ServiceRow->image; ?>" />
                <?php } echo '&nbsp;'; ?>
	      </td>
            </tr>
            <?php } ?>
            <tr>
              <th>Weekday Amount</th>
              <td>&nbsp;</td>            
              <td>&nbsp;</td>
             <!-- <td>&nbsp;</td>-->
              <td><?php echo $quote_building_service_total; ?></td>
              <td><input type="hidden" value="<?php echo $quote_building_service_total; ?>" id="week_day_amount_<?php echo $buiding_single_row['id']; ?>"  name="week_day_amount[<?php echo $buiding_single_row['id']; ?>]" ></td>
              
            </tr>
            <tr>
              <th>Mixed days Amount</th>
              <td>&nbsp;</td>            
               <td>&nbsp;</td>
              <!--<td>&nbsp;</td>-->
              <td><?php echo $quote_building_service_total * 1.2; ?></td>
              <td><input type="hidden" value="<?php echo $quote_building_service_total * 1.2; ?>" id="mixed_days_amount_<?php echo $buiding_single_row['id']; ?>" ></td>
             
            </tr>
            <tr>
              <th>Discount</th>
              <td>&nbsp;</td>             
              <td>&nbsp;</td>
              <!--<td>&nbsp;</td>-->
              <td><input type="text" autocomplete="off" value="<?php echo $buiding_single_row['discount'];?>" onkeyup="findqbtotal('<?php echo $buiding_single_row['id'];?>');" maxlength="5" class="price form-control padding5" name="discount[<?php echo $buiding_single_row['id'];?>]" id="discount_<?php echo $buiding_single_row['id'];?>" >
                %</td>
                    <td>&nbsp;</td>
              
              
            </tr>
            <tr>
              <th>Total</th>
              <td>&nbsp;</td>            
               <td>&nbsp;</td>
             <!-- <td>&nbsp;</td>-->
              <td>
			  <span id="qb_final_total_<?php echo $buiding_single_row['id'];?>">
			  <?php echo $quote_building_service_total - (($buiding_single_row['discount']/100) * $quote_building_service_total); ?>
			  </span>
			  </td>
              <td>&nbsp;</td>
             
            </tr>
          </table>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="row buttons aligncenter"> 
	<a href="<?php echo Yii::app()->getBaseUrl(true).'/?r=Quotes/default/DeleteQuote&id='.$_REQUEST['qid']; ?>" class="btn ptpb btn-primary mr5">Delete Quote</a>
	<a href="<?php echo Yii::app()->getBaseUrl(true).'/?r=Quotes/default/BuildingService&qid='.$_REQUEST['qid']; ?>" class="btn ptpb btn-primary mr5">Back</a> 
	<?php echo CHtml::submitButton('Save Quote', array('class' => 'btn btn-primary')); ?> 
	<?php echo CHtml::submitButton('Generate Quote', array('class' => 'btn btn-primary')); ?> 
	</div>
  </div>
</div>
<?php $this->endWidget(); ?>
<br/>
<br/>
<br/>

<!-- contentpanel --> 

<script type="text/javascript" charset="utf-8">

	function findqbtotal(id) {

		var discount = $("#discount_"+id).val();
		
		if(discount == '' || discount == null) {
		discount = 0;
		}
		
		if(discount > 100) {
		discount = $("#discount_"+id).val(100);
		discount = 100;
		}
		
		var week_day_amount = $("#week_day_amount_"+id).val();
		var discounted_amount_temp;
		discounted_amount_temp = (discount/100) * week_day_amount;
		discounted_amount = week_day_amount - discounted_amount_temp;
		$("#qb_final_total_"+id).text(discounted_amount);

	}

$('.price').keypress(function(event) {
            if(event.which == 8 || event.which == 0){
                return true;
            }
            if(event.which < 46 || event.which > 59) {
                return false;
                //event.preventDefault();
            } // prevent if not number/dot

            if(event.which == 46 && $(this).val().indexOf('.') != -1) {
                return false;
                //event.preventDefault();
            } // prevent if already dot
        });
		
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}		



</script> 
