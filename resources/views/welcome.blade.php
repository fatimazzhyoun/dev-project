<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Data Center Resource Management') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        /* Variables CSS - Palette claire et moderne */
         :root {
            --primary-color: #2ecc71; /* Vert moderne */
            --secondary-color: #27ae60; /* Vert foncé */
            --accent-color: #e74c3c; /* Rouge coral */
            --accent-light: #ff7f5c; /* Orange clair */
            --accent-dark: #c0392b; /* Rouge foncé */
            --light-color: #f9f7f7; /* Gris très clair */
            --dark-color: #34495e; /* Gris ardoise */
            --success-color: #2ecc71; /* Vert */
            --warning-color: #f39c12; /* Orange */
            --danger-color: #e74c3c; /* Rouge */
            --gray-color: #7f8c8d; /* Gris moyen */
            --light-gray: #ecf0f1; /* Gris très clair */
            --text-light: #ffffff; /* Blanc */
            --text-dark: #2c3e50; /* Gris foncé */
            --card-bg: #ffffff; /* Blanc pur pour les cartes */
            --section-bg: #f8f9fa; /* Gris très clair pour sections */
            --header-bg: #2c3e50; /* Gris foncé pour header */
            --footer-bg: #2c3e50; /* Gris foncé pour footer */
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #f5f7fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: background-color 0.3s ease;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header avec effet de survol */
        header {
            background-color: var(--header-bg);
            color: var(--text-light);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        header:hover {
            box-shadow: 0 6px 20px rgba(44, 62, 80, 0.15);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo i {
            font-size: 2rem;
            color: var(--primary-color);
            transition: transform 0.3s ease;
        }

        .logo:hover i {
            transform: rotate(15deg);
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-links a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(46, 204, 113, 0.2), transparent);
            transition: left 0.6s;
        }

        .nav-links a:hover::before {
            left: 100%;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .btn-login {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            border: none;
            padding: 10px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-login:hover::after {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        /* Section Hero avec effet de survol */
        .hero {
            background: linear-gradient(135deg, rgba(44, 62, 80, 0.9), rgba(52, 152, 219, 0.7)), url('https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');
            background-size: cover;
            background-position: center;
            color: var(--text-light);
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(46, 204, 113, 0.1) 50%, transparent 70%);
            animation: shimmer 8s infinite linear;
            pointer-events: none;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .hero h2 {
            font-size: 2.8rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .hero h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
            opacity: 0.95;
            line-height: 1.8;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .btn-primary, .btn-secondary {
            padding: 14px 32px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.4);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-light);
            border: 2px solid var(--text-light);
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        /* Section des ressources disponibles */
        .resources-section {
            padding: 5rem 0;
            background-color: var(--card-bg);
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--dark-color);
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .section-title p {
            color: var(--gray-color);
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.1rem;
        }

        .resources-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .resource-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid var(--light-gray);
            position: relative;
        }

        .resource-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .resource-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .resource-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.1));
            z-index: 1;
        }

        .resource-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .resource-card:hover .resource-image img {
            transform: scale(1.1);
        }

        .resource-content {
            padding: 1.8rem;
        }

        .resource-type {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(45deg, var(--light-gray), #e8f4f8);
            color: var(--primary-color);
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 12px;
            border: 1px solid rgba(46, 204, 113, 0.2);
        }

        .resource-title {
            font-size: 1.4rem;
            margin-bottom: 12px;
            color: var(--dark-color);
            font-weight: 600;
            line-height: 1.3;
        }

        .resource-desc {
            color: var(--gray-color);
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .resource-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--light-gray);
        }

        .resource-status {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--success-color);
            box-shadow: 0 0 10px var(--success-color);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .status-dot.unavailable {
            background-color: var(--danger-color);
            box-shadow: 0 0 10px var(--danger-color);
        }

        .status-dot.maintenance {
            background-color: var(--warning-color);
            box-shadow: 0 0 10px var(--warning-color);
        }

        .login-required {
            background: linear-gradient(45deg, rgba(46, 204, 113, 0.1), rgba(231, 76, 60, 0.1));
            border: 2px dashed var(--primary-color);
            padding: 1.2rem;
            margin-top: 1.5rem;
            border-radius: var(--border-radius);
            text-align: center;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .login-required:hover {
            background: linear-gradient(45deg, rgba(46, 204, 113, 0.15), rgba(231, 76, 60, 0.15));
            transform: translateY(-2px);
        }

        /* Section des règles d'utilisation */
        .rules-section {
            padding: 5rem 0;
            background-color: var(--section-bg);
        }

        .rules-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .rules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 3rem;
        }

        .rule-card {
            background-color: var(--card-bg);
            border-left: 5px solid var(--primary-color);
            padding: 2rem;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            border: 1px solid var(--light-gray);
            height: 100%;
        }

        .rule-card:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .rule-card h4 {
            color: var(--dark-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.2rem;
        }

        .rule-card i {
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        .rule-card p {
            color: var(--gray-color);
            line-height: 1.7;
        }

        /* Modal de connexion */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 500px;
            overflow: hidden;
            animation: modalFade 0.4s ease;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--light-gray);
        }

        @keyframes modalFade {
            from { opacity: 0; transform: translateY(-50px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .modal-header {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--text-light);
            padding: 1.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.6rem;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 1.8rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close-btn:hover {
            transform: rotate(90deg) scale(1.1);
            background-color: rgba(255, 255, 255, 0.1);
        }

        .modal-body {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            background-color: var(--light-gray);
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: var(--text-dark);
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
            background-color: white;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2.5rem;
        }

        .create-account-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            padding: 5px 0;
        }

        .create-account-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .create-account-link:hover::after {
            width: 100%;
        }

        .create-account-link:hover {
            color: var(--secondary-color);
        }

        /* Footer */
        footer {
            background-color: var(--footer-bg);
            color: var(--text-light);
            padding: 4rem 0 2rem;
            margin-top: auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-bottom: 3rem;
        }

        .footer-section h3 {
            font-size: 1.4rem;
            margin-bottom: 1.8rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .footer-section p {
            margin-bottom: 20px;
            opacity: 0.9;
            line-height: 1.7;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s ease;
        }

        .contact-item:hover {
            transform: translateX(5px);
        }

        .contact-item i {
            color: var(--primary-color);
            font-size: 1.3rem;
            width: 30px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }

        .social-links a:hover {
            background-color: var(--primary-color);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
        }

        .copyright {
            text-align: center;
            padding-top: 2.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.8;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero h2 {
                font-size: 2.3rem;
            }
            
            .resources-container,
            .rules-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }

            .nav-links {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .hero h2 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1.1rem;
                padding: 0 20px;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                max-width: 300px;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .modal-content {
                width: 95%;
                margin: 20px;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 3rem 0;
            }
            
            .hero h2 {
                font-size: 1.8rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .resource-card,
            .rule-card {
                padding: 1.5rem;
            }
            
            .resources-container,
            .rules-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Effets visuels supplémentaires */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .gradient-border {
            position: relative;
            border-radius: var(--border-radius);
            background: var(--card-bg);
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-light), var(--primary-color));
            border-radius: calc(var(--border-radius) + 2px);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gradient-border:hover::before {
            opacity: 1;
        }

        /* Effet de particules subtil */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 50%;
            opacity: 0.3;
            animation: particleFloat 10s infinite linear;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
 
    </style>
</head>
<body>
    <!-- Header -->
    <header class="hover-lift">
        <div class="container header-content">
            <div class="logo">
                <i class="fas fa-server floating"></i>
                <h1>Data Center Resource Management</h1>
            </div>
            <nav class="nav-links">
                <a href="#home" class="hover-lift">Accueil</a>
                <a href="#resources" class="hover-lift">Ressources</a>
                <a href="#rules" class="hover-lift">Règles</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-login hover-lift">Tableau de bord</a>
                    @else
                        <button class="btn-login hover-lift" id="login-btn">Connexion</button>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Section Hero -->
    <section class="hero" id="home">
        <div class="container">
            <h2>Gestion centralisée des ressources informatiques</h2>
            <p>Optimisez l'utilisation de vos serveurs, machines virtuelles, stockage et équipements réseau avec notre plateforme de réservation et de suivi en temps réel.</p>
            <div class="cta-buttons">
                <button class="btn-primary hover-lift" id="explore-resources">Explorer les ressources</button>
                <button class="btn-secondary hover-lift" id="learn-more">En savoir plus</button>
            </div>
        </div>
    </section>

    <!-- Section des ressources disponibles -->
    <section class="resources-section" id="resources">
        <div class="container">
            <div class="section-title">
                <h2>Ressources disponibles</h2>
                <p>Parcourez les ressources informatiques du data center. Connectez-vous pour voir les détails complets et faire des réservations.</p>
            </div>
            <div class="resources-container" id="resources-container">
                <!-- Les cartes de ressources seront générées par JavaScript -->
            </div>
        </div>
    </section>

    <!-- Section des règles d'utilisation -->
    <section class="rules-section" id="rules">
        <div class="container">
            <div class="section-title">
                <h2>Règles d'utilisation des ressources</h2>
                <p>Politiques et directives pour garantir une exploitation optimale et équitable</p>
            </div>
            <div class="rules-container">
                <div class="rules-grid">
                    <div class="rule-card gradient-border">
                        <h4><i class="fas fa-calendar-check"></i> Réservations</h4>
                        <p>Les réservations doivent être effectuées au minimum 24 heures à l'avance. Durée maximale : 30 jours consécutifs.</p>
                    </div>
                    <div class="rule-card gradient-border">
                        <h4><i class="fas fa-exclamation-triangle"></i> Utilisation responsable</h4>
                        <p>Les ressources doivent être utilisées exclusivement pour des projets académiques ou de recherche.</p>
                    </div>
                    <div class="rule-card gradient-border">
                        <h4><i class="fas fa-chart-bar"></i> Monitoring</h4>
                        <p>L'utilisation des ressources est monitorée. Un rapport d'utilisation doit être fourni à la fin de chaque projet.</p>
                    </div>
                    <div class="rule-card gradient-border">
                        <h4><i class="fas fa-tools"></i> Maintenance</h4>
                        <p>Maintenance planifiée le premier weekend de chaque mois. Notification 7 jours à l'avance.</p>
                    </div>
                    <div class="rule-card gradient-border">
                        <h4><i class="fas fa-shield-alt"></i> Sécurité</h4>
                        <p>Respect des politiques de sécurité obligatoire. Données sensibles chiffrées et accès protégés.</p>
                    </div>
                    <div class="rule-card gradient-border">
                        <h4><i class="fas fa-ban"></i> Restrictions</h4>
                        <p>Interdit : minage de cryptomonnaies, contenus illégaux, activités compromettant la sécurité.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de connexion -->
    <div class="modal" id="login-modal">
        <div class="modal-content gradient-border">
            <div class="modal-header">
                <h3 id="modal-title">Connexion</h3>
                <button class="close-btn" id="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Formulaire de connexion -->
                <form id="login-form" method="POST" action="{{ route('login') }}" style="display: block;">
                    @csrf
                    
                    @if ($errors->any())
                        <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <script>
                            // Show modal if there are errors (in case it was closed or page reloaded)
                            document.addEventListener('DOMContentLoaded', function() {
                                const modal = document.getElementById('login-modal');
                                if(modal) {
                                    modal.style.display = 'flex';
                                }
                            });
                        </script>
                    @endif
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" required placeholder="votre@email.com">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required placeholder="Votre mot de passe">
                    </div>
                    <div class="form-actions">
                        <a class="create-account-link" id="show-register">Créer un compte</a>
                        <button type="submit" class="btn-primary hover-lift">Se connecter</button>
                    </div>
                </form>

                <!-- Formulaire d'inscription -->
                <form id="register-form" method="POST" action="{{ route('register') }}" style="display: none;">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" required placeholder="Mohamed Ali">
                    </div>
                    <div class="form-group">
                        <label for="email-register">Adresse email</label>
                        <input type="email" id="email-register" name="email" required placeholder="votre@email.com">
                    </div>
                    <div class="form-group">
                        <label for="password-register">Mot de passe</label>
                        <input type="password" id="password-register" name="password" required placeholder="Votre mot de passe">
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirmer le mot de passe</label>
                        <input type="password" id="password-confirm" name="password_confirmation" required placeholder="Confirmer le mot de passe">
                    </div>
                    <div class="form-actions">
                        <a class="create-account-link" id="show-login">Déjà un compte ?</a>
                        <button type="submit" class="btn-primary hover-lift">Créer le compte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Data Center Resource Management</h3>
                    <p>Plateforme de gestion des ressources informatiques pour data centers. Réservation, allocation et suivi en temps réel.</p>
                    <div class="social-links">
                        <a href="#" class="hover-lift"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover-lift"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="hover-lift"><i class="fab fa-github"></i></a>
                        <a href="#" class="hover-lift"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <p><a href="#home" style="color: #ecf0f1; text-decoration: none;" class="hover-lift">Accueil</a></p>
                    <p><a href="#resources" style="color: #ecf0f1; text-decoration: none;" class="hover-lift">Ressources</a></p>
                    <p><a href="#rules" style="color: #ecf0f1; text-decoration: none;" class="hover-lift">Règles d'utilisation</a></p>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>support@datacenter.ma</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+212 5 24 XX XX XX</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Marrakech, Maroc</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Data Center Resource Management. Tous droits réservés.</p>
                <p>Cette page est destinée aux invités. Connectez-vous pour accéder aux fonctionnalités complètes.</p>
            </div>
        </div>
    </footer>

    <script>
        // Données des ressources (vue invité - informations limitées)
        const resources = [
            {
                id: 1,
                title: "Serveur HP ProLiant DL380",
                type: "Serveur physique",
                description: "Serveur haute performance pour applications critiques et virtualisation intensive.",
                image: "https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?w=400",
                status: "available"
            },
            {
                id: 2,
                title: "VM VMware vSphere",
                type: "Machine virtuelle",
                description: "Environnement virtualisé avec ressources dédiées pour développement et tests.",
                image: "https://images.unsplash.com/photo-1614064641938-3bbee52942c7?w=400",
                status: "available"
            },
            {
                id: 3,
                title: "Baie de stockage Dell EMC",
                type: "Stockage",
                description: "Solution de stockage SAN haute capacité avec réplication de données.",
                image: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=400",
                status: "maintenance"
            },
            {
                id: 4,
                title: "Commutateur Cisco Nexus",
                type: "Réseau",
                description: "Équipement réseau haute performance pour connectivité avancée.",
                image: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=400",
                status: "available"
            },
            {
                id: 5,
                title: "Serveur GPU NVIDIA DGX",
                type: "Serveur IA",
                description: "Infrastructure dédiée au calcul intensif et apprentissage automatique.",
                image: "https://images.unsplash.com/photo-1677442136019-21780ecad995?w=400",
                status: "unavailable"
            },
            {
                id: 6,
                title: "Cluster Kubernetes",
                type: "Conteneurs",
                description: "Environnement conteneurisé pour déploiement et orchestration modernes.",
                image: "https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=400",
                status: "available"
            }
        ];

        // Éléments DOM
        const loginBtn = document.getElementById('login-btn');
        const loginModal = document.getElementById('login-modal');
        const closeModal = document.getElementById('close-modal');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');
        const modalTitle = document.getElementById('modal-title');
        const exploreResourcesBtn = document.getElementById('explore-resources');
        const resourcesContainer = document.getElementById('resources-container');

        // Générer les cartes de ressources
        function generateResourceCards() {
            resourcesContainer.innerHTML = '';
            
            resources.forEach(resource => {
                const card = document.createElement('div');
                card.className = 'resource-card gradient-border';
                
                let statusClass = '';
                let statusText = '';
                if (resource.status === 'available') {
                    statusText = 'Disponible';
                } else if (resource.status === 'unavailable') {
                    statusClass = 'unavailable';
                    statusText = 'Indisponible';
                } else if (resource.status === 'maintenance') {
                    statusClass = 'maintenance';
                    statusText = 'Maintenance';
                }
                
                card.innerHTML = `
                    <div class="resource-image">
                        <img src="${resource.image}" alt="${resource.title}">
                    </div>
                    <div class="resource-content">
                        <span class="resource-type">${resource.type}</span>
                        <h3 class="resource-title">${resource.title}</h3>
                        <p class="resource-desc">${resource.description}</p>
                        <div class="resource-details">
                            <div class="resource-status">
                                <span class="status-dot ${statusClass}"></span>
                                <span>${statusText}</span>
                            </div>
                            <div class="resource-action">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <div class="login-required">
                            <i class="fas fa-lock"></i> Connectez-vous pour voir les détails complets
                        </div>
                    </div>
                `;
                
                card.addEventListener('click', () => {
                    loginModal.style.display = 'flex';
                    card.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 200);
                });
                
                resourcesContainer.appendChild(card);
            });
        }

        // Afficher/masquer modal de connexion
        if(loginBtn) {
            loginBtn.addEventListener('click', () => {
                loginModal.style.display = 'flex';
                loginBtn.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    loginBtn.style.transform = '';
                }, 200);
            });
        }

        closeModal.addEventListener('click', () => {
            loginModal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                loginModal.style.display = 'none';
            }
        });

        // Basculer entre login et register
        showRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            modalTitle.textContent = 'Créer un compte';
        });

        showLogin.addEventListener('click', (e) => {
            e.preventDefault();
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
            modalTitle.textContent = 'Connexion';
        });

        // Bouton explorer les ressources
        exploreResourcesBtn.addEventListener('click', () => {
            document.getElementById('resources').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
            exploreResourcesBtn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                exploreResourcesBtn.style.transform = '';
            }, 200);
        });

        // Bouton "En savoir plus"
        document.getElementById('learn-more').addEventListener('click', () => {
            alert("DATA CENTER RESOURCE MANAGEMENT\n\n✓ Gestion complète des ressources informatiques\n✓ Système de réservation avec validation\n✓ Notifications automatiques\n✓ Tableaux de bord statistiques\n✓ Interface sécurisée\n\nTechnologies: Laravel, MySQL, HTML/CSS/JavaScript\n\nThème: Palette claire et moderne\n\nNOTE: Les comptes technicien et administrateur existent déjà - création de compte uniquement pour utilisateurs internes");
        });

        // Effets de survol améliorés
        document.addEventListener('DOMContentLoaded', () => {
            generateResourceCards();
            
            // Ajout d'effets de survol aux cartes
            const cards = document.querySelectorAll('.resource-card, .rule-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 15px 35px rgba(46, 204, 113, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.boxShadow = '';
                });
            });

            // Effet de particules subtil
            createParticles();
        });

        // Création de particules subtiles
        function createParticles() {
            const particlesContainer = document.createElement('div');
            particlesContainer.className = 'particles';
            document.body.appendChild(particlesContainer);
            
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.animationDelay = `${Math.random() * 5}s`;
                particle.style.animationDuration = `${5 + Math.random() * 10}s`;
                particlesContainer.appendChild(particle);
            }
        }

        // Effet de souris qui suit (effet subtil)
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.hover-lift');
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                if (x > 0 && x < rect.width && y > 0 && y < rect.height) {
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateY = ((x - centerX) / centerX) * 2;
                    const rotateX = ((centerY - y) / centerY) * 2;
                    
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
                } else {
                    card.style.transform = '';
                }
            });
        });
    </script>
</body>
</html>

mes7ih o 7ati hada
