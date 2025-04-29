<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Biblioteca')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos customizados -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }

        .sidebar {
            background-color: var(--primary-color);
            color: white;
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.25rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        .main-content {
            background-color: var(--light-color);
            min-height: 100vh;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .btn-danger {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }

        /* Stats Cards na Dashboard */
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .stat-card .icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .stat-card .stat-count {
            font-size: 2rem;
            font-weight: bold;
        }

        .stat-card .stat-name {
            font-size: 1rem;
            opacity: 0.8;
        }

        /* Badges personalizados */
        .badge-disponivel {
            background-color: #2ecc71;
            color: white;
        }

        .badge-indisponivel {
            background-color: #e74c3c;
            color: white;
        }

        .badge-atrasado {
            background-color: #e74c3c;
            color: white;
        }

        .badge-em-dia {
            background-color: #3498db;
            color: white;
        }

        .badge-devolvido {
            background-color: #2ecc71;
            color: white;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Sistema de Biblioteca</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('livros.index') }}" class="nav-link {{ request()->routeIs('livros.*') ? 'active' : '' }}">
                                <i class="fas fa-book"></i> Livros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('usuarios.index') }}" class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i> Usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('emprestimos.index') }}" class="nav-link {{ request()->routeIs('emprestimos.*') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt"></i> Empréstimos
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <div class="px-3">
                                <h6 class="text-white-50">RELATÓRIOS</h6>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('relatorios.livros-disponiveis') }}" class="nav-link {{ request()->routeIs('relatorios.livros-disponiveis') ? 'active' : '' }}">
                                <i class="fas fa-check-circle"></i> Livros Disponíveis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('relatorios.emprestimos-atrasados') }}" class="nav-link {{ request()->routeIs('relatorios.emprestimos-atrasados') ? 'active' : '' }}">
                                <i class="fas fa-exclamation-triangle"></i> Empréstimos Atrasados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('relatorios.usuarios-com-emprestimos') }}" class="nav-link {{ request()->routeIs('relatorios.usuarios-com-emprestimos') ? 'active' : '' }}">
                                <i class="fas fa-user-check"></i> Usuários com Empréstimos
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="d-flex flex-grow-1 justify-content-end">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-plus"></i> Novo
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('livros.create') }}">Livro</a></li>
                                    <li><a class="dropdown-item" href="{{ route('usuarios.create') }}">Usuário</a></li>
                                    <li><a class="dropdown-item" href="{{ route('emprestimos.create') }}">Empréstimo</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Alertas -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                <!-- Conteúdo da Página -->
                <div class="container-fluid pb-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts customizados -->
    @yield('scripts')
</body>
</html>
