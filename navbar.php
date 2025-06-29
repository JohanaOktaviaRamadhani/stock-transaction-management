<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top neon-navbar shadow">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2 text-white fw-semibold" href="index.php">
      <img src="img/logo2.png" class="img-fluid" width="50" alt="Lilac Store Logo">
      <span class="fs-5">Lilac Store</span>
    </a>
    <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENU -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center gap-4">
        <li class="nav-item">
          <a class="nav-link neon-link text-white" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link neon-link text-white" href="index.php#article">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link neon-link text-white" href="login.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- STYLE -->
<style>
  :root {
    --neon-lilac: #c69ff5;
    --lilac-dark: #5a3e91;
    --navbar-bg: #7e57c2;
    --nav-text: #fff8ff;
  }

  .neon-navbar {
    background-color: var(--navbar-bg);
    box-shadow: 0 0 12px #c69ff5aa, 0 4px 20px rgba(122, 66, 199, 0.3);
    animation: dropFade 0.4s ease-in-out;
    z-index: 1030;
  }

  @keyframes dropFade {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .neon-link {
    position: relative;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
  }

  .neon-link::after {
    content: "";
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background-color: var(--neon-lilac);
    box-shadow: 0 0 8px var(--neon-lilac);
    transition: width 0.3s ease;
    border-radius: 2px;
  }

  .neon-link:hover,
  .neon-link:focus {
    color: var(--nav-text);
    text-shadow: 0 0 6px var(--neon-lilac), 0 0 12px var(--neon-lilac);
    transform: scale(1.06);
  }

  .neon-link:hover::after {
    width: 100%;
  }

  .navbar-toggler {
    box-shadow: none;
  }

  .navbar-toggler-icon {
    filter: brightness(10);
  }
</style>
