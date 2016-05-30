<?php
 $con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
							  $con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
								$s = "select * from dummy_1;";
								$x ="SELECT * FROM information_schema.columns WHERE table_name = 'dummy_1';";
								$col = pg_query($con,$x);
								echo ' <table data-reactid=".d.0.1.0.0.0:$3.0.0.1.0.0.0" class="l96_CLxo_PqCKgtKdL8oT oswsGtBEhm6HA5DPrrAWV fullscreen-normal-text fullscreen-night-text">';
								echo '<thead><tr>';
				
								while($row_1 = pg_fetch_array($col))
								{
									echo '<th class="MB-DataTable-header cellData text-brand-hover">'.$row_1[3].'</th>';
								}
								
								echo '</tr></thead><tbody><tr>';
								$r = pg_query($con1,$s);
								$count = "SELECT count(*) FROM information_schema.columns WHERE table_name = 'dummy_1';";
								$c = pg_query($con1,$count);
								
								while($row = pg_fetch_array($r))
								{
									$i=0;
									for($i=0;$i<$c;$i++)
									{
										echo '<td class="px1 border-bottom" style="white-space:nowrap;">'.$row[$i].'</td>';
									}
									echo '</tr>';
								}
								
								echo '</tbody></table>';
								
				//Table 2	
				
				 $con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
							  $con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
								$s = "select * from dummy_2;";
								$x ="SELECT * FROM information_schema.columns WHERE table_name = 'dummy_2';";
								$col = pg_query($con,$x);
								echo ' <table data-reactid=".d.0.1.0.0.0:$3.0.0.1.0.0.0" class="l96_CLxo_PqCKgtKdL8oT oswsGtBEhm6HA5DPrrAWV fullscreen-normal-text fullscreen-night-text">';
								echo '<thead><tr>';
				
								while($row_1 = pg_fetch_array($col))
								{
									echo '<th class="MB-DataTable-header cellData text-brand-hover">'.$row_1[3].'</th>';
								}
								
								echo '</tr></thead><tbody><tr>';
								$r = pg_query($con1,$s);
								$count = "SELECT count(*) FROM information_schema.columns WHERE table_name = 'dummy_2';";
								$c = pg_query($con1,$count);
								
								  $con3 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
								 $table3_count = "SELECT * FROM dummy_2;";
								 $r3 = pg_query($con3,$table3_count);
								 $c3 =pg_num_fields($r3);
								 echo 'c3='.$c3;
								
								while($row = pg_fetch_array($r))
								{
									$i=0;
									for($i=0;$i<$c3;$i++)
									{
										echo '<td class="px1 border-bottom" style="white-space:nowrap;">'.$row[$i].'</td>';
									}
									echo '</tr>';
								}
								
								echo '</tbody></table>';
								
								
								//Table 3
								
								 $con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
							  $con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
								$s = "select * from dummy_3;";
								$x ="SELECT * FROM information_schema.columns WHERE table_name = 'dummy_3';";
								$col = pg_query($con,$x);
								echo ' <table data-reactid=".d.0.1.0.0.0:$3.0.0.1.0.0.0" class="l96_CLxo_PqCKgtKdL8oT oswsGtBEhm6HA5DPrrAWV fullscreen-normal-text fullscreen-night-text">';
								echo '<thead><tr>';
				
								while($row_1 = pg_fetch_array($col))
								{
									echo '<th class="MB-DataTable-header cellData text-brand-hover">'.$row_1[3].'</th>';
								}
								
								echo '</tr></thead><tbody><tr>';
								$r = pg_query($con1,$s);
								$count = "SELECT count(*) FROM information_schema.columns WHERE table_name = 'dummy_2';";
								$c = pg_query($con1,$count);
								
								  $con3 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
								 $table3_count = "SELECT * FROM dummy_3;";
								 $r3 = pg_query($con3,$table3_count);
								 $c3 =pg_num_fields($r3);
								 echo 'c3='.$c3;
								
								while($row = pg_fetch_array($r))
								{
									$i=0;
									for($i=0;$i<$c3;$i++)
									{
										echo '<td class="px1 border-bottom" style="white-space:nowrap;">'.$row[$i].'</td>';
									}
									echo '</tr>';
								}
								
								echo '</tbody></table>';
								
								//Table 4
								
								 $con = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
							  $con1 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
								$s = "select * from dummy_4;";
								$x ="SELECT * FROM information_schema.columns WHERE table_name = 'dummy_4';";
								$col = pg_query($con,$x);
								echo ' <table data-reactid=".d.0.1.0.0.0:$3.0.0.1.0.0.0" class="l96_CLxo_PqCKgtKdL8oT oswsGtBEhm6HA5DPrrAWV fullscreen-normal-text fullscreen-night-text">';
								echo '<thead><tr>';
				
								while($row_1 = pg_fetch_array($col))
								{
									echo '<th class="MB-DataTable-header cellData text-brand-hover">'.$row_1[3].'</th>';
								}
								
								echo '</tr></thead><tbody><tr>';
								$r = pg_query($con1,$s);
								$count = "SELECT count(*) FROM information_schema.columns WHERE table_name = 'dummy_2';";
								$c = pg_query($con1,$count);
								
								  $con3 = pg_connect("host=localhost port=5421 dbname=postgres user=postgres password=plz");
								 $table3_count = "SELECT * FROM dummy_4;";
								 $r3 = pg_query($con3,$table3_count);
								 $c3 =pg_num_fields($r3);
								 echo 'c3='.$c3;
								
								while($row = pg_fetch_array($r))
								{
									$i=0;
									for($i=0;$i<$c3;$i++)
									{
										echo '<td class="px1 border-bottom" style="white-space:nowrap;">'.$row[$i].'</td>';
									}
									echo '</tr>';
								}
								
								echo '</tbody></table>';
								
								
								
								
								
								
						
								
?>