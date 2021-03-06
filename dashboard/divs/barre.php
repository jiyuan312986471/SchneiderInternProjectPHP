<!-- Show Clock -->
<script src="js/MyDigitClock.js"></script>

<script language="javascript">
	$(function(){
		$("#clock").MyDigitClock();
	});
</script>

<ul class="nav navbar-top-links navbar-right">
	<!-- ALERT -->
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<?php
				if(isset($listeAlerte)) {
					echo '<i class="fa fa-bell fa-fw fa-lg" style="background-color:red;"></i>';
				}
				else {
					echo '<i class="fa fa-bell fa-fw fa-lg"></i>';
				}
			?>
			<i class="fa fa-caret-down fa-lg"></i>
		</a>
		<ul class="dropdown-menu dropdown-alerts">
			<?php
				if(isset($listeAlerte)) {
					for($i = 0; $i < count($listeAlerte); $i++) {
			?>
						<li>
							<a href="#">
								<div>
									<i class="glyphicon glyphicon-warning-sign"><?php $listeAlerte[$i] ?></i>
								</div>
							</a>
						</li>
			<?php
					}
				}
				else {
					echo "<center>Aucune notification pour l'instant !</center>";
				}
			?>
			<li role="presentation" class="divider"></li>
			<li>
				<!-- Modal Configer Trigger -->
				<a href="#" id="config" data-toggle="modal" data-target="#modalConfig">
					<i class="fa fa-cog fa-fw"></i>
					Configuration
				</a>
			</li>
		</ul>
	</li>
	
	<!-- USER -->
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fa fa-user fa-fw fa-lg"></i>
			<i class="fa fa-caret-down fa-lg"></i>
		</a>
		<ul class="dropdown-menu dropdown-user">
			<li>
				<a href="../dec.php">
					<i class="fa fa-sign-out fa-fw"></i>
					Deconnexion
				</a>
			</li>
		</ul>
	</li>
	
	<!-- EMAIL -->
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fa fa-envelope fa-lg"></i>
			<i class="fa fa-caret-down fa-lg"></i>
		</a>
		<ul class="dropdown-menu dropdown-user">
			<li>
				<a href="mail/sendMail.php">
					<i class="fa fa-send fa-fw"></i>
					Envoyer
				</a>
			</li>
		</ul>
	</li>
	
	<!-- TIME -->
	<li class="dropdown" id="clock"></li>
</ul>