<div class="padding-20">
    <b><?= $event->name ?></b>
    <br>

    <p><?= $event->start_date ?></p>

    <?php if($event->finished): ?>
        <h1>Finished.</h1>
    <?php else: ?>
        <h1 id="event-time" data-startdate="<?= $event->start_date ?>"></h1>
    <?php endif; ?>

    <table id="event-table" class="table-fill">
        <thead>
        <tr>
            <th>Participant's name</th>
            <th>Number</th>
            <th>Category</th>
            <?php foreach ($checkpoints as $checkpoint): ?>
                <th><?= $checkpoint->name ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($participants as $participant): ?>
            <tr>
                <td><?= $participant->participant_name ?></td>
                <td><?= $participant->starting_number ?></td>
                <td><?= $participant->category_name ?></td>
                <?php foreach ($checkpoints as $checkpoint): ?>
                    <td>
                        <?php if(isset($participant->checkpoints[$checkpoint->id])): ?>
                            <?= $participant->checkpoints[$checkpoint->id]; ?>
                        <?php else: ?>
                            <span
                                class="checkpoint_activate_btn"
                                data-event-id="<?= $event->id ?>"
                                data-checkpoint-id="<?= $checkpoint->id ?>"
                                data-participant-id="<?= $participant->id ?>"
                                >
                                activate
                            </span>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>