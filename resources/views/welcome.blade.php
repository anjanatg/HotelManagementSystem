<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/welcome.css')}}">
</head>
<body>

<div class="container-fluid d-flex justify-content-center align-items-center vh-100">

    <div class="welcome-box">
        <div class="row g-0">

            <!-- Left Side -->
            <div class="col-md-7">
                <div class="food-image">
                    <div class="overlay"></div>
                    <div class="content">
                        <h1>Restaurant Management System</h1>
                        <p class="fs-5">
                            Manage Food Items, Orders, Inventory and Suppliers
                        </p>
                    </div>
                </div>
            </div>
            

            <!-- Right Side -->
            <div class="col-md-5">
                <div class="right-panel">
            
                    <!-- Circles -->
                    <div class="top-circle"></div>
                    <div class="bottom-circle"></div>
            
                    <div class="login-content text-center">
                        <h3 class="mb-4">Welcome</h3>
            
                        <a href="{{ route('login') }}"
                           class="btn btn-primary btn-custom">
                            Login
                        </a>
            
                        <a href="{{ route('register') }}"
                           class="btn btn-outline-primary btn-custom">
                            Register
                        </a>
                    </div>
            
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>