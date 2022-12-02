<?php

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/message/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Edit');

$mform = new edit();

if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot . '/local/message/manage.php', "message cancelled");
} 
else if ($fromform = $mform->get_data()) {

    $recordtoinsert = new stdClass();
    $recordtoinsert->messagetext = $fromform->messagetext;

    $DB->insert_record('local_message', $recordtoinsert);
    redirect($CFG->wwwroot . '/local/message/manage.php', "you created a message");
}

echo $OUTPUT->header();

$mform->display();

echo " <a href= 'http://localhost/moodle/local/message/manage.php'> View messages</a>";

echo $OUTPUT->footer();