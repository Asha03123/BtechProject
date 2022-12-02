<?php

require_once(__DIR__ . '/../../config.php');

$PAGE->set_url(new moodle_url('/local/message/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('manage messages');

$messages = $DB->get_records('local_message');

$test = array_values($messages);

echo $OUTPUT->header();

echo "<br> List of messages:<br>";

foreach ($test as $value) {
    echo "$value->messagetext <br>";
}

echo " <a href= 'http://localhost/moodle/local/message/edit.php'> Create messages</a> <br>";
echo "<a href = 'http://localhost/moodle'> Back to dashboard</a>";

echo $OUTPUT->footer();
