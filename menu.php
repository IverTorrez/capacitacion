<!-- CONDICION DE SESSION -->
<?php
session_start();
if ($_SESSION["usuarioC"]!=null) 
{
?>
<aside class="main-sidebar">

	 <section class="sidebar">

		<ul class="sidebar-menu">

			<li class="active">

				<a href="crear_capacitacion.php">

					<i class="fa fa-home"></i>
					<span>Admin. Capacitaciones</span>

				</a>

			</li>

			<li>

				<a href="procuradores.php">

					<i class="fa fa-user"></i>
					<span>Procuradores</span>

				</a>

						


			</li>

			<li>

				<a href="capacitacion_listado.php">

					<i class="fa fa-th"></i>
					<span>Detalles Capacitacion</span>

				</a>

			</li>

			<!-- <li>

				<a href="productos">

					<i class="fa fa-product-hunt"></i>
					<span>Productos</span>

				</a>

			</li>

			<li>

				<a href="clientes">

					<i class="fa fa-users"></i>
					<span>Clientes</span>

				</a>

			</li> -->

		<!-- 	<li class="treeview">

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