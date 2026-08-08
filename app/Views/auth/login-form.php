<?php

declare(strict_types=1);
?>

<div class="col-lg-4 col-12 login-panel">

    <div class="login-wrapper">

        <h2 class="login-title">
            Welcome Back
        </h2>

        <p class="login-subtitle">
            Sign in to continue to ITAMS Enterprise
        </p>

        <?php if (!empty($error)): ?>

            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                <?= htmlspecialchars($error) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>

            </div>

        <?php endif; ?>

        <form method="POST" action="/login" autocomplete="off">

            <!-- Username -->
            <div class="mb-4">

                <label for="username" class="form-label">
                    Username
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        value="<?= htmlspecialchars($username ?? '') ?>"
                        placeholder="Enter your username"
                        autocomplete="username"
                        required>

                </div>

            </div>

            <!-- Password -->
            <div class="mb-4">

                <label for="password" class="form-label">
                    Password
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required>

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        id="togglePassword"
                        aria-label="Show Password">

                        <i class="bi bi-eye"></i>

                    </button>

                </div>

            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    id="remember"
                    name="remember"
                    value="1">

                <label
                    class="form-check-label"
                    for="remember">

                    Remember Me

                </label>

            </div>

            <!-- Login Button -->
            <div class="d-grid mb-3">

                <button
                    type="submit"
                    class="btn btn-primary btn-lg"
                    id="loginButton">

                    <i class="bi bi-box-arrow-in-right me-2"></i>

                    Sign In

                </button>

            </div>

            <!-- Forgot Password -->
            <div class="text-center">

                <a
                    href="#"
                    class="forgot-link">

                    Forgot Password?

                </a>

            </div>

        </form>

        <div class="login-footer">

            Version 1.0

            <br>

            © 2026 Danah Real Estate

        </div>

    </div>

</div>