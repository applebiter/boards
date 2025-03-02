<?php
$valid_themes = [
    'cerulean',
    'cosmo',
    'cyborg',
    'darkly',
    'flatly',
    'journal',
    'litera',
    'lumen',
    'lux',
    'materia',
    'minty',
    'morph',
    'pulse',
    'quartz',
    'sandstone',
    'simplex',
    'sketchy',
    'slate',
    'solar',
    'spacelab',
    'superhero',
    'united',
    'vapor',
    'yeti',
    'zephyr',
];
$page_title = $page_title ?? 'applebiter.com';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="/js/color-modes.js"></script>
    <meta charset="utf-8">
    <title><?= h($page_title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (isset($theme) && in_array($theme, $valid_themes)): ?>
    <link rel="stylesheet" href="/css/<?= h($theme) ?>/bootstrap.min.css">
    <?php else: ?>
    <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.css">
    <?php endif ?>
    <link rel="stylesheet" href="/vendor/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/vendor/prismjs/themes/prism-okaidia.css">
    <link rel="stylesheet" href="/css/custom.min.css">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
      
      pre {
        background-color:#1e1e1e;
        color:#9cdcfe;
        padding: 1em;
        border-radius: 5px;
      }
    </style>
    <script src="/vendor/jquery/jquery-3.7.1.min.js"></script>
  </head>
  <body>

  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
      <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
      <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
    </symbol>
  </svg>

  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle" style="z-index:100;">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
            id="bd-theme"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
      <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
          Light
          <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
          <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
          Dark
          <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
        </button>
      </li>
      <li>
        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
          <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
          Auto
          <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
        </button>
      </li>
    </ul>
  </div>

    <div class="navbar navbar-expand-lg fixed-top bg-primary" data-bs-theme="dark">
      <div class="container">
        <a href="/" class="navbar-brand">
          <img src="/favicon.png" height="26px" alt="applebiter-icon" class="d-inline-block align-text-top"> 
          <?= h($page_title) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav">
            <li class="nav-item">
              &nbsp;
            </li>
          </ul>
          <ul class="navbar-nav ms-md-auto">
            <?php if ($this->Identity->isLoggedIn()) : ?>
            <?php 
              $username = $this->Identity->get('username');
            ?>
            <li class="nav-item me-3">
              <a target="_blank" rel="noopener" class="nav-link text-light" href="#" title="You are logged in as <?= h($username) ?>">
                <i class="bi bi-file-person-fill me-1"></i> <?= h($username) ?>
              </a>
            </li>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle me-3 text-light" data-bs-toggle="dropdown" href="#" id="themes" title="Choose a different color theme"><i class="bi bi-palette-fill"></i><span class="d-lg-none ms-2">Themes</span></a>
              <div class="dropdown-menu" aria-labelledby="themes">
                <a class="dropdown-item" href="/theme/change/default/">Default</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/theme/change/cerulean/">Cerulean</a>
                <a class="dropdown-item" href="/theme/change/cosmo/">Cosmo</a>
                <a class="dropdown-item" href="/theme/change/cyborg/">Cyborg</a>
                <a class="dropdown-item" href="/theme/change/darkly/">Darkly</a>
                <a class="dropdown-item" href="/theme/change/flatly/">Flatly</a>
                <a class="dropdown-item" href="/theme/change/journal/">Journal</a>
                <a class="dropdown-item" href="/theme/change/litera/">Litera</a>
                <a class="dropdown-item" href="/theme/change/lumen/">Lumen</a>
                <a class="dropdown-item" href="/theme/change/lux/">Lux</a>
                <a class="dropdown-item" href="/theme/change/materia/">Materia</a>
                <a class="dropdown-item" href="/theme/change/minty/">Minty</a>
                <a class="dropdown-item" href="/theme/change/morph/">Morph</a>
                <a class="dropdown-item" href="/theme/change/pulse/">Pulse</a>
                <a class="dropdown-item" href="/theme/change/quartz/">Quartz</a>
                <a class="dropdown-item" href="/theme/change/sandstone/">Sandstone</a>
                <a class="dropdown-item" href="/theme/change/simplex/">Simplex</a>
                <a class="dropdown-item" href="/theme/change/sketchy/">Sketchy</a>
                <a class="dropdown-item" href="/theme/change/slate/">Slate</a>
                <a class="dropdown-item" href="/theme/change/solar/">Solar</a>
                <a class="dropdown-item" href="/theme/change/spacelab/">Spacelab</a>
                <a class="dropdown-item" href="/theme/change/superhero/">Superhero</a>
                <a class="dropdown-item" href="/theme/change/united/">United</a>
                <a class="dropdown-item" href="/theme/change/vapor/">Vapor</a>
                <a class="dropdown-item" href="/theme/change/yeti/">Yeti</a>
                <a class="dropdown-item" href="/theme/change/zephyr/">Zephyr</a>
              </div>
            </li>
            <?php endif ?>
            <li class="nav-item">
              <a target="_blank" rel="noopener" class="nav-link text-light" href="https://github.com/applebiter/boards" title="Go to this application's repo on Github"><i class="bi bi-github"></i><span class="d-lg-none ms-2">GitHub</span></a>
            </li>
            <li class="nav-item">
              <?php if ($this->Identity->isLoggedIn()) : ?>
              <a class="nav-link text-light" href="/users/logout" title="Log out of the application"><i class="bi bi-door-open-fill"></i><span class="d-lg-none ms-2">Log Out</span></a>
              <?php else : ?>
              <a class="nav-link text-light" href="/users/login" title="Log into the application"><i class="bi bi-door-closed-fill"></i><span class="d-lg-none ms-2">Log In</span></a>
              <?php endif ?>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">

      <?= $this->fetch('content') ?>

      <footer id="footer">
        <div class="row">
          <div class="col-lg-12">
            <ul class="list-unstyled">
              <li class="float-end"><i class="bi bi-caret-up me-1"></i> <a href="#top">Back to top</a></li>
              <li><a href="/pages/about">About</a></li>
              <li><a href="/pages/privacy">Privacy</a></li>
              <li><a href="/pages/terms">Terms</a></li>
            </ul>
            <p>Made by <a href="https://github.com/applebiter/boards">applebiter</a>.</p>
            <p>Code released under the <a href="/LICENSE">MIT License</a>.</p>

          </div>
        </div>
      </footer>
    </div>
    <script src="/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/prismjs/prism.js" data-manual></script>
    <!-- <script src="/js/custom.js"></script> -->
  </body>
</html>
