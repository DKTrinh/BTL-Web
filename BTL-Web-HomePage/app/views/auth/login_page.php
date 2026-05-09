<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - CleanTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #a7b8e1 0%, #c4c1e0 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; margin: 0; }
        .auth-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.15); max-width: 900px; width: 100%; }
        .auth-left { background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 60px 50px; position: relative; }
        .auth-left::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('https://images.unsplash.com/photo-1557682250-33bd709cbe85') center/cover; opacity: 0.2; mix-blend-mode: overlay; }
        .auth-left-content { position: relative; z-index: 1; }
        .auth-right { padding: 60px 50px; background: #ffffff; }
        .form-control { background: #f4f6fa; border: none; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 0.95rem; }
        .btn-primary-custom { background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 100%); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; width: 100%; transition: 0.3s; }
        .btn-outline-custom { background: #ffffff; color: #3b82f6; border: 1px solid #e2e8f0; padding: 14px; border-radius: 8px; font-weight: bold; width: 100%; text-decoration: none; display: block; text-align: center; }
    </style>
</head>
<body>
<div class="container py-4" id="login-section">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="auth-card row g-0">
                <div class="col-md-6 auth-left d-flex flex-column justify-content-between">
                    <div class="auth-left-content">
                        <div class="mb-5 d-flex align-items-center fw-bold">
                            <a href="?url=home" class="text-white text-decoration-none fs-5">
                                <span style="background: white; width: 12px; height: 12px; border-radius: 50%; display: inline-block; margin-right: 8px;"></span> 
                                CLEAN TECH
                            </a>
                        </div>
                        <h1 class="fw-bold display-5 mb-4" id="welcome-title">Hello,<br>welcome!</h1>
                        <p class="mb-5 text-white-50 small" id="welcome-text">Advanced emission control systems for industrial operations worldwide.</p>
                        <a href="?url=home" class="btn btn-outline-light rounded-pill px-4 py-2" style="font-size: 0.85rem;">Back to home</a>
                    </div>
                </div>

                <div class="col-md-6 auth-right">
                    <h2 class="fw-bold mb-4">Login</h2>
                    <form action="public_entry.php?url=login" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= CsrfHelper::generateToken(); ?>">
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-semibold">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@mail.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••••••" required>
                        </div>
                        
                        <button type="submit" class="btn-primary-custom">Login</button>
                        <a href="?url=register" class="btn-outline-custom mt-3" id="to-register">Sign up</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>