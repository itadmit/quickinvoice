<?php

// Include configuration
require_once 'config/config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to dashboard
    header('Location: pages/dashboard.php');
    exit;
}

// Process login form
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    // Validate input
    if (empty($email) || empty($password)) {
        $error = 'יש להזין את כל השדות';
    } else {
        try {
            // Get user from database
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            // Verify password
            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to dashboard
                header('Location: pages/dashboard.php');
                exit;
            } else {
                $error = 'שם משתמש או סיסמה שגויים';
            }
        } catch (PDOException $e) {
            $error = 'שגיאת מערכת, אנא נסה שוב מאוחר יותר';
            // Log error
            error_log($e->getMessage());
        }
    }
}

// Random images for the left side
$images = [
    [
        'url' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2850&amp;q=80',
        'title' => 'ניהול עסקי חכם',
        'description' => 'נהל את העסק שלך ביעילות עם מערכת החשבוניות המתקדמת שלנו'
    ],
    [
        'url' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2850&amp;q=80',
        'title' => 'הצעות מחיר מקצועיות',
        'description' => 'צור הצעות מחיר מרשימות בקלות ובמהירות'
    ],
    [
        'url' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=2850&amp;q=80',
        'title' => 'חשבוניות אוטומטיות',
        'description' => 'שלח חשבוניות אוטומטיות ללקוחות וקבל תשלומים מהר יותר'
    ]
];

// Select a random image
$randomImage = $images[array_rand($images)];
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>התחברות | <?= APP_NAME ?></title>
    
    <!-- Google Noto Sans Hebrew Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Hebrew:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#E94F8A',
                            hover: '#D43B76',
                            light: '#FDEBF2',
                        },
                    },
                    fontFamily: {
                        sans: ['Noto Sans Hebrew', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        * {
            font-family: 'Noto Sans Hebrew', sans-serif;
        }
        .login-bg-pattern {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23e94f8a' fill-opacity='0.05'%3E%3Cpath d='M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        input{
            padding-right:35px!important
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Left Banner - Image with overlay -->
        <div class="hidden lg:block lg:w-1/2 relative">
            <div class="absolute inset-0 bg-gradient-to-r from-primary/90 to-purple-700/90 z-10"></div>
            <img src="<?= $randomImage['url'] ?>" alt="<?= $randomImage['title'] ?>" class="absolute inset-0 h-full w-full object-cover" />
            <div class="relative z-20 flex flex-col justify-center items-center h-full text-white px-12">
                <div class="max-w-md text-center">
                    <h2 class="text-4xl font-bold mb-6"><?= $randomImage['title'] ?></h2>
                    <p class="text-xl mb-8"><?= $randomImage['description'] ?></p>
                    <div class="flex space-x-3 space-x-reverse justify-center">
                        <span class="h-2 w-2 rounded-full bg-white"></span>
                        <span class="h-2 w-2 rounded-full bg-white/50"></span>
                        <span class="h-2 w-2 rounded-full bg-white/50"></span>
                    </div>
                </div>
                <div class="absolute bottom-10 left-10 text-white/70 text-sm">
                    &copy; <?= date('Y') ?> <?= APP_NAME ?> | כל הזכויות שמורות
                </div>
            </div>
        </div>
        
        <!-- Right side - Login Form -->
        <div class="w-full lg:w-1/2 login-bg-pattern flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Logo and App Name -->
                <div class="text-center mb-10">
                    <img src="assets/img/logo.png" alt="<?= APP_NAME ?>" class="h-16 mx-auto mb-2">
                    <p class="mt-2 text-gray-600">מערכת ניהול חשבוניות והצעות מחיר</p>
                </div>
                
                <!-- Login Form Card -->
                <div class="bg-white rounded-2xl shadow-lg p-8 transition-all duration-200 hover:shadow-xl">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">התחברות למערכת</h2>
                    
                    <?php if (!empty($error)): ?>
                        <div class="bg-red-50 border-r-4 border-red-500 text-red-600 px-4 py-3 rounded mb-6" role="alert">
                            <div class="flex">
                                <div class="py-1">
                                    <svg class="h-6 w-6 text-red-500 ml-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="align-middle"><?= $error ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                כתובת אימייל
                            </label>
                            <div class="relative">
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    autocomplete="email" 
                                    required 
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition duration-200"
                                    placeholder="your@email.com"
                                >
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    סיסמה
                                </label>
                                <a href="#" class="text-sm text-primary hover:text-primary-hover transition duration-200">
                                    שכחת סיסמה?
                                </a>
                            </div>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    autocomplete="current-password" 
                                    required 
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition duration-200"
                                    placeholder="••••••••"
                                >
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <input 
                                id="remember_me" 
                                name="remember_me" 
                                type="checkbox" 
                                class="h-4 w-4 text-primary focus:ring-primary/25 border-gray-300 rounded transition duration-200"
                            >
                            <label for="remember_me" class="mr-2 block text-sm text-gray-700">
                                זכור אותי
                            </label>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-200">
                                <span>התחבר למערכת</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600">
                            אין לך חשבון עדיין?
                            <a href="register.php" class="text-primary hover:text-primary-hover font-medium transition duration-200">
                                הירשם עכשיו
                            </a>
                        </p>
                    </div>
                </div>
                
                <!-- Mobile only footer -->
                <div class="mt-8 text-center lg:hidden">
                    <p class="text-xs text-gray-500">
                        &copy; <?= date('Y') ?> <?= APP_NAME ?> | כל הזכויות שמורות
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>