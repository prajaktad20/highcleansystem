  
      <div class="pageheader">
        <div class="media">
          <div class="media-body">
            <ul class="breadcrumb">
              <li><a href="<?php echo $this->user_dashboard_url; ?>"><i class="glyphicon glyphicon-home"></i></a></li>
              <li>Dashboard</li>
            </ul>
            <h4>Dashboard</h4>
          </div>
        </div>
        <!-- media --> 
      </div>
      <!-- pageheader -->
      
      <div class="contentpanel">
        <div class="row">
          <div class="col-md-12">
            <ul class="widgetlist">
              
            </ul>
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2>Overview</h2>
                  </div>
                </div>
                <div class="cart"> 
				 <div id="graph_1_container" style="min-width: 310px; height: 300px; margin: 0 auto">
				<table class="table table-bordered">
					<tr>
						<td><strong>System Owner</strong></td>
						<td><?php echo $result['system_owner']; ?></td>
					</tr>
					<tr>
						<td><strong>Operation Manager</strong></td>
						<td><?php echo $result['operation_manager']; ?></td>
					</tr>
					<tr>
						<td><strong>State Manager</strong></td>
						<td><?php echo $result['state_manager']; ?></td>
					</tr>
					<tr>
						<td><strong>Agents</strong></td>
						<td><?php echo $result['agents']; ?></td>
					</tr>
					<tr>
						<td><strong>Email Format</strong></td>
						<td><?php echo $result['email_format']; ?></td>
					</tr>
					<tr>
						<td><strong>Sms Format</strong></td>
						<td><?php echo $result['sms_format']; ?></td>
					</tr>
					<tr>
						<td><strong>Services</strong></td>
						<td><?php echo $result['services']; ?></td>
					</tr>
				</table>
                </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-body titlebar"> <span class="glyphicon  glyphicon-th"></span>
                    <h2>Latest Five Agents</h2>
                  </div>
                </div>
               <div class="cart"> 
			  <div id="graph_2_container" style="min-width: 310px; height: 300px; margin: 0 auto">
			  <table class="table table-bordered">
			  <tr>
				<td><strong>Name</strong></td>
				<td><strong>Company</strong></td>
				<td><strong>Created Date</strong></td>
			  </tr>
			  
			  <?php
			  foreach($latest_agents as $agent_count)
			  {
				echo '<tr>';
				echo '<td>'.$agent_count['agent_first_name'].' '.$agent_count['agent_last_name'].'</td>';
				echo '<td>'.$agent_count['business_name'].'</td>';
				echo '<td>'.$agent_count['added_date'].'</td>';
				echo '</tr>';
			  }
			  ?>
			  
			  </table>
			  </div>
			   </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>

