<div class="padding-20">
    <b>Choose event:</b>
    <br><br>

    <select id="simulate-choose_event">
        <option selected disabled>Choose event</option>
        <?php foreach ($events as $event): ?>
            <option value="<?= $event->id ?>">
                <?= $event->name ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>