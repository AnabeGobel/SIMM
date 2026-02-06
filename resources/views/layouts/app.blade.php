<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','SIMMOT')</title>
  @vite(['resources/css/app.css','resources/saas/app.scss', 'resources/js/app.js'])


    
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




    
  
</head>
<style> 


 </style>

<body>
    <body class="d-flex flex-column min-vh-100">
    @yield('content')
    
</body>
</html>
