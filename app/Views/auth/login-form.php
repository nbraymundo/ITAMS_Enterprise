<div class="col-lg-4 col-12 login-panel">

    <div class="login-wrapper">

        <h2 class="login-title">
            Welcome Back
        </h2>

        <p class="login-subtitle">
            Sign in to continue to ITAMS Enterprise
        </p>

        <form method="POST" action="/login">

            <!-- Username -->
            <div class="mb-4">

                <label class="form-label">
                    Username
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>

                    <input
                        type="text"
                        class="form-control"
                        name="username"
                        placeholder="Enter your username"
                        required>

                </div>

            </div>

            <!-- Password -->
            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>

                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required>

                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="togglePassword">

                        <i class="bi bi-eye"></i>

                    </button>

                </div>

            </div>

            <!-- Remember -->
            <div class="form-check mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    id="remember">

                <label
                    class="form-check-label"
                    for="remember">

                    Remember Me

                </label>

            </div>

            <!-- Login Button -->
            <div class="d-grid mb-3">

                <button
                    class="btn btn-primary btn-lg"
                    type="submit"
                    id="loginButton">

                    <i class="bi bi-box-arrow-in-right"></i>

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