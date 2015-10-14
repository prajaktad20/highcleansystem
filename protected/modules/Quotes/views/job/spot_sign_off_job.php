<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <ul class="breadcrumb">
                <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
                <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/default/admin">Quotes</a></li>
                <li><a href="<?php echo $this->user_role_base_url; ?>?r=Quotes/Job/view&id=<?php echo $model->id; ?>">This Job</a></li>
            </ul>

        </div>
    </div>
    <!-- media --> 
</div>	  				
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'buildings-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>



<div class="container job_detalis" style="width:100%">

    <div class="mb20"></div>
    <div class="panel panel-default">
        <div class="panel-body titlebar">
            <span class="glyphicon  glyphicon-th"></span>
            <h2>Sign Off Job : 2) Take signature on the spot through hand held devices.</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="clint_div table-responsive">
                <table width="100%">
                    <thead>
                    <tbody>
                        <tr class="heading" >
                            <td width="50%">Client Name</td>
                            <td><?php echo $company_model->name; ?></td>
                        </tr>
                        <tr class="td1">
                            <td>Site Name</td>
                            <td><?php echo $site_model->site_name; ?></td>
                        </tr>
                        <tr class="td2">
                            <td>Site Address</td>
                            <td><?php echo $site_model->address . ', ' . $site_model->suburb . ', ' . $site_model->state . ' ' . $site_model->postcode; ?></td>
                        </tr>
                        <tr class="td3">
                            <td>Site Contact Name/Number</td>
                            <td class="padding_left">
                                <table class="table-responsive Jose" width="100%">
                                    <tr class="td3">
                                        <td width="50%"><?php echo $site_model->site_contact; ?></td>
                                        <td><?php echo $site_model->phone; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="td2">
                            <td>Client Contact Name/Number</td>
                            <td class="padding_left">
                                <table class="table-responsive Jose" width="100%">
                                    <tr class="td2 Jose">
                                        <td width="50%"><?php echo $contact_model->first_name . ' ' . $contact_model->surname; ?></td>
                                        <td><?php echo $contact_model->phone; ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="td3">
                            <td>Purchase Order Number</td>
                            <td><?php echo $job_model->purchase_order; ?></td>
                        </tr>
                    </tbody>
                    </thead>
                </table>
            </div>
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="heading">
                        <td>Scope of Work</td>
                    </tr>
                </table>
            </div>
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tr class="td2" height="70px" style="vertical-align:top;">
                        <td><?php foreach ($job_services_model as $service) {
    echo '- ' . $service->service_description . '<br/>';
} ?>	</td>
                    </tr>
                </table>
            </div>  

            <div class="Scope_of_Work sign_off_work table-responsive">
                <table width="100%">
                    <tr class="sign_sheet">
                        <td class="blue">Client Name<span class="required" style="color:red;">*</span></td>
                        <td width="50%" class="td1"><?php echo $form->textField($model, 'client_name', array('class' => 'form-control')); ?><?php echo $form->error($model, 'client_name'); ?></td>
                    </tr>
                </table>
            </div>




            <div class="Scope_of_Work sign_off_work table-responsive">
                <table width="100%">
                    <tr class="sign_sheet">
                        <td class="blue">Sign off date<span class="required" style="color:red;">*</span></td>
                        <td width="50%" class="td1"><?php
                            $this->widget(
                                    'ext.jui.EJuiDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'client_date',
                                //'language'=> 'ru',//default Yii::app()->language
                                //'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
                                'mode' => 'date',
                                'htmlOptions' => array(
                                    'class' => 'form-control',
                                ),
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'showAnim' => 'slideDown', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1930:' . date("Y"),
                                    //'minDate' => '2000-01-01',      // minimum date
                                    'maxDate' => date("Y-m-d"), // maximum date
                                //'timeFormat' => '',//'hh:mm tt' default
                                ),
                                    )
                            );
                            ?><?php echo $form->error($model, 'client_date'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="Scope_of_Work sign_off_work table-responsive">
                <table width="100%">
                    <tr class="sign_sheet">
                        <td class="blue">Feedback</td>
                        <td width="50%" class="td1"><?php echo $form->textArea($model, 'client_feedback', array('rows' => 6, 'cols' => 50, 'class' => 'form-control')); ?></td>
                    </tr>
                </table>
            </div>
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tbody><tr height="70px" style="vertical-align:top;" class="td1">
                            <td></td>
                        </tr>
                    </tbody></table>
            </div>
            <div class="Scope_of_Work table-responsive">
                <table width="100%">
                    <tbody><tr height="120px" style="vertical-align:top;" class="td2">
                            <td>Signature<span class="required" style="color:red;">*</span>

                                <div class="sigPad">	 
                                    <ul class="sigNav">     
                                        <li class="clearButton"><a href="#clear">Clear</a></li>
                                    </ul>
                                    <div class="sig sigWrapper">
                                        <div class="typed"></div>
                                        <canvas class="pad" width="290" height="98"></canvas>
                                        <input type="hidden" name="output" class="output">
                                    </div>
                                </div>




                            </td>
                        </tr>
                    </tbody></table>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <div class="address">
                        High Clean Pty Ltd<br>
                        ABN: 45631025732<br>
                        E: infohighclean.com.au<br>
                        W: www.highclean.com.au<br>
                        A: 1/92 Railway st sotuh, Alton VIC 3018<br>
                        T: 03 8398 0804 F: 03 8398 9899 
                    </div>
                </div>
            </div>       
        </div>

        <div class="clear"></div>
        <div style="text-align:center;">		 
<?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary')); ?> &nbsp; 
            <a href="<?php echo Yii::app()->getBaseUrl(true) . '/?r=Quotes/Job/SignOffView&id=' . $model->id; ?>" class="btn btn-primary">Cancel</a> 
        </div>

<?php $this->endWidget(); ?>


        <!-- contentpanel --> 

        <?php
        Yii::app()->clientScript->registerCssFile($this->base_url_assets . '/js/assets/jquery.signaturepad.css');
        Yii::app()->clientScript->registerScriptFile($this->base_url_assets . '/js/jquery.signaturepad.js');
        ?>


        <script>
            $(document).ready(function () {
                $('.sigPad').signaturePad({drawOnly: true});
            });
        </script>

        <script>
            $(document).ready(function () {
                $('.sigPad').signaturePad({displayOnly: true}).regenerate(<?php echo $model->client_signature; ?>);
            });
        </script>
