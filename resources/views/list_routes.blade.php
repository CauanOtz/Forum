<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Rotas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/routes.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Rotas de Listagem</h1>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Recurso</th>
                    <th>Rota</th>
                    <th>Método HTTP</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rotas de Usuários -->
                <tr>
                    <td>1</td>
                    <td>Usuários</td>
                    <td><a href="{{ route('listAllUsers') }}">/users</a></td>
                    <td>GET</td>
                </tr>
                <!-- Rotas de Tópicos -->
                <tr>
                    <td>2</td>
                    <td>Tópicos</td>
                    <td><a href="{{ route('listAllTopics') }}">/topics</a></td>
                    <td>GET</td>
                </tr>
                <!-- Rotas de Posts -->
                <tr>
                    <td>3</td>
                    <td>Posts</td>
                    <td><a href="{{ route('listAllPosts') }}">/posts</a></td>
                    <td>GET</td>
                </tr>
                <!-- Rotas de Tags -->
                <tr>
                    <td>4</td>
                    <td>Tags</td>
                    <td><a href="{{ route('listAllTags') }}">/tags</a></td>
                    <td>GET</td>
                </tr>
                <!-- Rotas de Comentários -->
                <tr>
                    <td>5</td>
                    <td>Comentários</td>
                    <td><a href="{{ route('listAllComments') }}">/comments</a></td>
                    <td>GET</td>
                </tr>
                <!-- Rotas de Categorias -->
                <tr>
                    <td>6</td>
                    <td>Categorias</td>
                    <td><a href="{{ route('listAllCategories') }}">/categories</a></td>
                    <td>GET</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
