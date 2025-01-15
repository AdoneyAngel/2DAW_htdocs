@include('layouts.header')

<body>
    @include('layouts.menu')

    <div class="container mt-4">
        <h1 class="mb-4">Crear Usuario</h1>

        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="row">

                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group col-md-6">
                    <label for="usuario">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="{{ old('usuario') }}" required>
                    @error('usuario')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group col-md-6">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                      <div class="form-group col-md-6">
                        <label for="foto">Ruta Foto:</label>
                        <input type="foto" class="form-control" id="foto" name="foto" required>
                        @error('foto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                <div class="form-group col-md-6">
                    <label for="fecha">Fecha registro:</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                    @error('fecha')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <!-- Botones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Crear</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    @include('layouts.footer')
</body>
