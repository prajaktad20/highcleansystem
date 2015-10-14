<style>
    body {
        font-size : 10px;
    }
</style>

<?php
/* @var $this UserController */
/* @var $model User */


$pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
?>


<div class="pageheader">
    <div class="media">
        <div class="media-body">
            <ul class="breadcrumb">
                <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
                <li><a href="<?php echo $this->user_role_base_url; ?>?r=User/default/admin">Users</a></li>
                <li>Manage Users</li>
            </ul>

            <h4>			
                <?php
                echo CHtml::link(
                        Yii::t("User.create", "Add New User"), array("create"), array("class" => "btn btn-primary pull-right")
                );
                ?>	</h4>

        </div>
    </div>
    <!-- media --> 
</div>
<div class="contentpanel">
    <div class="row">
        <div class="col-md-12 user_section">
            <div class="clearfix"></div>
            <div class="panel panel-default">
                <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>				  
                    <h2>Users Management</h2>

                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <div class="col-md-12 pull-right mb10 pr0" style="text-align:right">

                    </div>
<?php
                    
$this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'user-grid',
                        'dataProvider' => $model->search(),
                        'filter' => $model,
                        'itemsCssClass' => 'table table-bordered mb30 quote_table',
                        'pagerCssClass' => 'pagination',
                        'columns' => array(
                            array(
                                'name' => 'fullName',
                                'header' => 'Full Name',
                                'headerHtmlOptions' => array('class' => 'head'),
                                'value' => '$data->getFullName()',
                            ),
                            array(
                                'name' => 'role_id',
                                'header' => 'Group',
                                'headerHtmlOptions' => array('class' => 'head'),
                                'filter' => CHtml::listData(Group::model()->findAll(), 'id', 'role'), // fields from country table
                                'value' => 'Group::Model()->FindByPk($data->role_id)->role',
                            ),
                            array(
                                'name' => 'status',
                                'headerHtmlOptions' => array('class' => 'head'),
                                'filter' => array('1' => 'Active', '0' => 'InActive'),
                                'value' => '$data->status ? "Active" : "Inactive"'
                            ),
                            array(
                                'name' => 'view_jobs',
                                'headerHtmlOptions' => array('class' => 'head'),
                                'filter' => array('1' => 'Yes', '0' => 'No'),
                                'value' => '$data->view_jobs ? "Yes" : "No"'
                            ),
                            array(
                                'name' => 'email',
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                            array(
                                'name' => 'mobile_phone',
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                            array(
                                'name' => 'driving_licence',
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                            array(
                                'name' => 'driving_licence_state',
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                            array(
                                'name' => 'regular_hours',
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                            array(
                                'name' => 'overtime_hours',
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                            array(
                                'name' => 'double_time_hours',
                                'headerHtmlOptions' => array('class' => 'head'),
                            ),
                                array(
                                    'class' => 'CButtonColumn',
                                    'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 150 => 150, 200 => 200), array(
                                        'onchange' => "$.fn.yiiGridView.update('user-grid',{ data:{pageSize: $(this).val() }})",
                                    )),
                                    'headerHtmlOptions' => array('width' => '15%', 'class' => 'head'),
                                    'template' => '{update} | {change_password} | {view_licenses} {delete}',
                                            'buttons' => array
                                                (
                                                        'view_licenses' => array(
                                                            'label' => 'License/Induction',
                                                            'imageUrl' => null,
                                                            'url' => 'Yii::app()->createUrl("/User/default/ViewLicenseInduction",array("selected_user_id" => $data->primaryKey))',
                                                        ),
                                                        'update' => array
                                                            (
                                                            'label' => 'Edit',
                                                            'imageUrl' => null,
                                                        ),
                                                        'change_password' => array
                                                            (
                                                            'label' => 'Change Password',
                                                            'imageUrl' => null,
                                                            'url' => 'Yii::app()->createUrl("/User/default/changepassword",array("id" => $data->primaryKey))',
                                                        ),
                                                        'delete' => array
                                                            (
                                                            'label' => '| Delete',
                                                            'visible' => '(Yii::app()->user->profile=="admin") ? true : false',
                                                            'imageUrl' => null,
                                                        ),
                                            ),
                                ),
                        ),
                    ));
                    
?>



                </div>
                <!-- table-responsive --> 
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- contentpanel -->

