<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CleanTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #a7b8e1 0%, #c4c1e0 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; margin: 0; }
        .auth-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px rgba(0,0,0,0.15); max-width: 900px; width: 100%; }
        .auth-left { background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 60px 50px; position: relative; }
        .auth-left::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('https://images.unsplash.com/photo-1557682250-33bd709cbe85') center/cover; opacity: 0.2; mix-blend-mode: overlay; }
        .auth-left-content { position: relative; z-index: 1; }
        .auth-right { padding: 40px 50px; background: #ffffff; }
        .form-control { background: #f4f6fa; border: none; padding: 10px 20px; border-radius: 8px; margin-bottom: 15px; font-size: 0.9rem; }
        .btn-primary-custom { background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 100%); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; width: 100%; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="auth-card row g-0">
                <div class="col-md-6 auth-left d-flex flex-column justify-content-between">
                    <div class="auth-left-content">
                        <h1 class="fw-bold display-5 mb-4">Join our<br>community!</h1>
                        <p class="mb-5 text-white-50 small">Advanced environmental solutions starting with a single account.</p>
                        <a href="?url=home" class="btn btn-outline-light rounded-pill px-4 py-2" style="font-size: 0.85rem;">Back to home</a>
                    </div>
                </div>

                <div class="col-md-6 auth-right">
                    <h2 class="fw-bold mb-4">Register</h2>
                    <!-- Action phải trỏ về register[cite: 17] -->
                        <form action="?url=register" method="POST" id="authForm"> <!-- Điều hướng đúng nhánh[cite: 17] -->
    <!-- DÙNG CSRFHELPER Ở ĐÂY[cite: 12, 17] -->
                            <input type="hidden" name="csrf_token" value="<?= CsrfHelper::generateToken(); ?>">
                            
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                            
                            <div class="form-check mb-4">
                                <input type="checkbox" name="terms" id="terms" required>
                                <label for="terms">I agree to the Terms</label>
                            </div>
                            
                            <button type="submit" class="btn-primary-custom">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/auth.js"></script>
</body>
</html>