<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Mobile Optimization -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Keuangan Umroh">
    <meta name="theme-color" content="#0d9488">
    
    <title>@yield('title', 'Pencatatan Keuangan Umroh')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Mobile touch optimization */
        * {
            -webkit-tap-highlight-color: rgba(13, 148, 136, 0.1);
        }
        
        /* Prevent text size adjustment on mobile */
        html {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        /* Better mobile button touches */
        button, a, input, textarea, select {
            touch-action: manipulation;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Mobile table scroll indicator */
        @media (max-width: 768px) {
            .overflow-x-auto::after {
                content: '← Geser →';
                position: absolute;
                bottom: 10px;
                right: 10px;
                background: rgba(13, 148, 136, 0.9);
                color: white;
                padding: 4px 12px;
                border-radius: 4px;
                font-size: 12px;
                pointer-events: none;
                animation: fadeInOut 3s ease-in-out infinite;
            }
            
            @keyframes fadeInOut {
                0%, 100% { opacity: 0; }
                50% { opacity: 1; }
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-screen">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
