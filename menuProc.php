<!-- CONDICION DE SESSION -->
<?php
session_start();
if ($_SESSION["usuarioP"]!=null) 
{
?>
<aside class="main-sidebar">

	 <section class="sidebar">

		<ul class="sidebar-menu">

			<li class="active">

				<a href="mis_capacitaciones.php">

					<i class="fa fa-home"></i>
					<span>Mis Capacitaciones</span>

				</a>

			</li>

			<li>

				<a href="datos_procurador.php">

					<i class="fa fa-user"></i>
					<span>Mis datos</span>

				</a>

						<!-- <ul class="treeview-menu">	
							<li>
								<a href="crear_procurador.php">		
									<i class="fa fa-circle-o"></i>
									<span>Procuradores</span>
								</a>
							</li>
							<li>
								<a href="crear-venta">						
									<i class="fa fa-circle-o"></i>
									<span>Crear Capacitador</span>
								</a>
							</li>
							<li>
								<a href="crear_capacitacion.php">						
									<i class="fa fa-circle-o"></i>
									<span>Capacitacion</span>
								</a>
							</li>
						</ul> -->


			</li>

			<li>

				<a href="capacitaciones.php">
					<i class="fa fa-th"></i>
					<span>Todas las Capacitaciones</span>

				</a>

			</li>

			<!-- <li>

				<a href="productos">

					<i class="fa fa-product-hunt"></i>
					<span>Productos</span>

				</a>

			</li> -->

			<!-- <li>

				<a href="clientes">

					<i class="fa fa-users"></i>
					<span>Clientes</span>

				</a>

			</li> -->

	<!-- 		<li class="treeview">

				<a href="#">

					<i class="fa fa-list-ul"></i>
					
					<span>Ventas</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="ventas">
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar ventas</span>

						</a>

					</li>

					<li>

						<a href="crear-venta">
							
							<i class="fa fa-circle-o"></i>
							<span>Crear venta</span>

						</a>

					</li>

					<li>

						<a href="reportes">
							
							<i class="fa fa-circle-o"></i>
							<span>Reporte de ventas</span>

						</a>

					</li>

				</ul>

			</li> -->

		</ul>

	 </section>

</aside>
<?php 
}
?>