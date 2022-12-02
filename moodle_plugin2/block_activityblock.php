<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing HTML block instances.
 *
 * @package   block_activityblock
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_activityblock extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_activityblock');
    }


    function get_content() {
        global $DB,$USER;

        if ($this->content !== NULL) {
            return $this->content;
        }
        $courselist = array();
        $fullcourslist=array();
        $content = '';
        // $courses = mysql_query('SELECT * FROM mdl_course');


        // $sql="SELECT userid,fullname
        //       FROM {user_enrolments}  ue
        //       JOIN {enrol}  e
        //       ON e.id=ue.enrolid
        //       JOIN {course}  c
        //       ON e.courseid=c.id
        //       WHERE userid=2";

        $sql="SELECT ue.id,fullname,userid from {course} c JOIN {enrol} e ON e.courseid=c.id JOIN {user_enrolments} ue on e.id=ue.enrolid";
        $sql2="SELECT fullname from {course}";
        $courses = $DB->get_records_sql($sql);
        $fullcours=$DB->get_records_sql($sql2);
        

        foreach ($courses as $course) {
            if($course->userid == $USER->id) {
            array_push($courselist, $course->fullname);
            }
            }


        foreach ($fullcours as $course) {
            array_push($fullcourslist, $course->fullname);
            }

            $courselist=array_diff($fullcourslist,$courselist);
        
        foreach ($courselist as $cid){
            $content .= $cid. '<br>';
        }

        $this->content = new stdClass;
        $this->content->text = $content;
        $this->content->footer = "";

        return $this->content;
    }
}
