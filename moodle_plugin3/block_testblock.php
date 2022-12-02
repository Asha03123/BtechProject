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
 * @package   block_testblock
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


class block_testblock extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_testblock');
    }
    function has_config() {
        return true;
    }

    function get_content() {
        global $USER,$DB;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $content ='';
        function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);
        
            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        }
        debug_to_console($USER->id);
        $courselist=array();
        $sql="SELECT ue.id,fullname,userid,courseid from {course} c JOIN {enrol} e ON e.courseid=c.id JOIN {user_enrolments} ue on e.id=ue.enrolid";
        $courses = $DB->get_records_sql($sql);
        $sql2="SELECT la.id,userid,CONCAT(firstname, ' ', lastname) AS wholename,courseid FROM {user_lastaccess} as la JOIN {user} AS u ON la.userid=u.id WHERE timeaccess > UNIX_TIMESTAMP(CURRENT_TIME()) - 300";
        $uselist = $DB->get_records_sql($sql2);
        foreach ($courses as $course) {
            if($course->userid == $USER->id) {
            array_push($courselist, $course->courseid);
            debug_to_console($course->courseid);
            }
            }

        $userlis = array();
        foreach ($uselist as $lis) {
            debug_to_console("List");
            debug_to_console($lis->courseid);
            if(in_array($lis->courseid,$courselist)) {
                debug_to_console("List2");
            array_push($userlis, $lis->wholename);
            debug_to_console($lis->wholename);
            }
            }
        $userlis=array_unique($userlis);
        foreach ($userlis as $cid){
            $content .= $cid. '<br>';
        }
        // $showcourses = get_config('block_testblock', 'showcours       
        // if ($showcourses) {
        //     $courses = $DB->get_records('course');
        //     foreach ($courses as $course) {
        //         $content .= $course->fullname . '<br>';
        //     }
        // } else {
        //     $users = $DB->get_records('user');
        //     foreach ($users as $user) {
        //         $content .= $user->firstname . ' ' . $user->lastname . '<br>';
        //     }
        // }

        // $users = $DB->get_records('user');
        //     foreach ($users as $user) {
        //         $content .= $user->firstname . ' ' . $user->lastname . '<br>';
        //     }




        //     debug_to_console("HEllo");
            

        $this->content = new stdClass;
        $this->content->text = $content;
        $this->content->footer = '';
        return $this->content;
    }
}
