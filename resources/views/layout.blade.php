<!doctype html>
<html lang="lv">
<head>
<meta charset="utf-8">
<title>2. Projekts - {{ $title }}</title>
<meta name="description" content="Tīmekļa Tehnoloģiju 2. praktiskais darbs">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link
 href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
 rel="stylesheet"
 integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
 crossorigin="anonymous"
 >
</head>
<body>
<nav class="navbar bg-primary mb-3" data-bs-theme="dark">
<header class="container">
<a class="navbar-brand" href="#">2. Projekts - {{ $title }}</a>
</header>
</nav>

<main class="container">
<div class="row">
<div class="col">
@yield('content')
</div>
</div>
</main>
<footer class="text-bg-dark mt-3">
<div class="container">
<div class="row py-5">
<div class="col">
Dāvids Egle, 2026
</div>
</div>
</div>
</footer>
</body>
</html>