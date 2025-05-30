<?php
/**
 * HAT layout - HTMX + Alpine.js + TailwindCSS */
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_for_layout; ?></title>
    <!-- Tailwind CSS przez CDN (tylko do prototypowania) -->    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <!-- Opcjonalna konfiguracja Tailwind 
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '#0066cc', // Przykładowy kolor firmowy
            }
          }
        }
      }
    </script>
    -->
    
    <?php
        echo $this->Html->meta('icon');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>
<body>
    <!-- Zawartość strony -->
    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
    <?php echo $this->fetch('content'); ?>
</body>
</html>