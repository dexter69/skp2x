<!--
    *** HAT layout - HTMX + Alpine.js + TailwindCSS
-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_for_layout; ?></title>
    <!-- Podłączenie Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Alpine.js -->
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    <!-- HTMX -->
    <!-- <script src="https://unpkg.com/htmx.org@1.9.10"></script> -->
    <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar - ukryty na małych ekranach, widoczny od md wzwyż -->
        <?php /* echo $this->element('ui/test/side'); */ ?>
        
        <!-- Główna zawartość -->
        <div class="flex-1">
            <!-- Nagłówek z przyciskiem do pokazywania/ukrywania sidebar na małych ekranach -->
            <?php echo $this->element('ui/test/a-header'); ?>            

            <!-- Kontener treści z marginesami na większych ekranach -->
            <main class="p-4 md:p-6 max-w-7xl mx-auto">
                
                <?php echo $this->fetch('content'); ?>
            </main>
        </div>
    </div>
</body>
</html>