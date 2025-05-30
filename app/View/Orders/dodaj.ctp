<!-- Tutaj będzie formularz zamówienia -->
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nowe zamówienie</h1>
    
    <!-- Przykładowy formularz -->
    <form>
        <div class="space-y-4">
            <?php
                echo $this->element('ui/test/client-picker');
                echo $this->element('ui/test/date-picker');
                echo $this->element('ui/test/uwagi');
                echo $this->element('ui/test/save-button');
            ?>
        </div>
    </form>
</div>