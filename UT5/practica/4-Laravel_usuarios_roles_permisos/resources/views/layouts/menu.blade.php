<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Título del Menú -->
        <a class="navbar-brand fw-bold" href="#">Menú</a>

        <!-- Botón de Desplegable para Móviles -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Opciones del Menú -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Opción Usuarios -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('usuarios.index') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                        <i class="bi bi-people-fill"></i> Usuarios
                    </a>
                </li>

                <!-- Opción Roles -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('roles.index') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-lock-fill"></i> Roles
                    </a>
                </li>

                <!-- Opción Permisos -->
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('permisos.index') ? 'active' : '' }}" href="{{ route('permisos.index') }}">
                        <i class="bi bi-key-fill"></i> Permisos
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
