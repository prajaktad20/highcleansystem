<?php
/* @var $this InductionController */
/* @var $model Induction */


?>

 <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">            	
              <li>Update Induction</li>
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
                <h2>Update Induction</h2>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
              <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>