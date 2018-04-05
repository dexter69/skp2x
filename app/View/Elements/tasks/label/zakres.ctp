<!-- Element z kontrolkami do drukowania zakresu --> 

<form class="form-inline zakres">
    <div class="form-group">
        <label class="sr-only" for="prefix<?= $id ?>">Prefix</label>
        <input type="text" class="form-control prefix" id="prefix<?= $id ?>" placeholder="prefix">
    </div>
    <div class="form-group">
        <label class="sr-only" for="start<?= $id ?>">Start</label>
        <input type="text" class="form-control start" id="start<?= $id ?>" placeholder="start">
    </div>
    <div class="form-group">
        <label class="sr-only" for="suffix<?= $id ?>">Prefix</label>
        <input type="text" class="form-control suffix" id="suffix<?= $id ?>" placeholder="suffix">
    </div>
</form>