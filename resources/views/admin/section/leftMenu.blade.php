@if(auth()->user()->hasRole('Admin'))
            <div class="navbar-default sidebar" role="navigation" >
                <div class="sidebar-nav navbar-collapse" >
                    <ul class="nav" id="side-menu" style="margin-top: 10px">
                        <li>
                            <a href="/admin/"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Inventario<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/entradas">Entradas</a>
                                </li>
                                <li>
                                    <a href="/admin/pedidos">Pedido</a>
                                </li>
                                <li>
                                    <a href="/admin/salidas">Salidas</a>
                                </li>
                                <li>
                                    <a href="/admin/ventas">Ventas</a>
                                </li>
                                <li>
                                    <a href="/admin/proveedores">Proveedores</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tree fa-fw"></i> Plantas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/plantas">Plantas</a>
                                </li>
                                <li>
                                    <a href="/admin/tipoPlanta">Tipo De Plantas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="/admin/secciones"><i class="fa fa-table fa-fw"></i>Secciones</a>
                        </li>
                        <li>
                            <a href="/admin/reportes"><i class="fa fa-file"></i></i> Reportes</a>
                        </li>
                        <li>
                            <a href="/admin/usuarios"><i class="fa fa-user fa-fw"></i> Usuario</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
@endif
@if(auth()->user()->hasRole('User'))
    <div class="navbar-default sidebar" role="navigation" >
                <div class="sidebar-nav navbar-collapse" >
                    <ul class="nav" id="side-menu" style="margin-top: 10px">
                        <li>
                            <a href="/user/"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Inventario<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/user/entradas">Entradas</a>
                                </li>
                                <li>
                                    <a href="/user/pedidos">Pedido</a>
                                </li>
                                <li>
                                    <a href="/user/salidas">Salidas</a>
                                </li>
                                <li>
                                    <a href="/user/ventas">Ventas</a>
                                </li>
                                <li>
                                    <a href="/user/proveedores">Proveedores</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tree fa-fw"></i> Plantas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/user/plantas">Plantas</a>
                                </li>
                                <li>
                                    <a href="/user/tipoPlanta">Tipo De Plantas</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="/user/secciones"><i class="fa fa-table fa-fw"></i>Secciones</a>
                        </li>
                        <li>
                            <a href="/user/reportes"><i class="fa fa-file"></i></i> Reportes</a>
                        </li>
                        <li>
                            <a href="/user/usuarios"><i class="fa fa-user fa-fw"></i> Usuario</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
@endif