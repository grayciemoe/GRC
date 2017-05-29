<?php
$message = $data['notification'];
?>
<div class="card">
    <div class="card-block">
        <small class="pull-right text-right"><?= strftime("%A, %B, %d-%Y<br> %H:%M%p", strtotime($message['timestamp'])) ?></small>
        <h4>SUBJECT : <span class="text-muted"><?= $message['subject'] ?></span></h4>
    </div>
    <div class="card-block" style="background:#FCFCFC">
        <?= $message['description'] ?>
    </div>

    <div class="card-block">

    </div>

    <table class="table table-small table-sm table-condensed">
        <tbody>
            <tr>
                <td>Email Sent</td>
                <td><?= $message['message_sent'] ? "Message Sent" : "Not Sent" ?></td>
            </tr>
            <tr>
                <td>Auth Key</td>
                <td class="text-white"><?= $message['authKey'] ?></td>
            </tr>
            <tr>
                <td>Email To:</td>
                <td><?= $message['username'] ?></td>
            </tr>
            <tr>
                <td>Call Back Url</td>
                <td><a href="<?= $message['url'] ?>" target="_blank">Call Back Url</a></td>
            </tr>

        </tbody>
    </table>

</div>
</div>