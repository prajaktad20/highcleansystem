<?php
/* @var $this IncidentController */
/* @var $model Incident */

?>



<div class="pageheader">
        <div class="media">
          <div class="media-body">
         <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Update Incident</li>
            </ul>

          </div>
        </div>
        <!-- media --> 
</div>


<div class="contentpanel">

        <div class="row">
          <div class="col-md-12 quote_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                <h2>Update Incident</h2>
              </div>
            </div>
            <div class="col-md-12">

			
<?php $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
</div>
</div>
