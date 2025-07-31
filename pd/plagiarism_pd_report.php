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
 * @copyright 2025, PlagiarismDetector <support@plagiarismdetector.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require dirname(dirname(__FILE__)).'/../config.php';

require_once $CFG->dirroot.'/plagiarism/pd/constants.php';
require_once $CFG->dirroot.'/plagiarism/pd/lib.php';

// Get url params.
$externalid = required_param('externalid', PARAM_TEXT);
$cmid = required_param('cmid', PARAM_INT);
$userid = required_param('userid', PARAM_INT);
$modulename = required_param('modulename', PARAM_TEXT);
$viewmode = optional_param('view', 'course', PARAM_TEXT);
$errormessagestyle = 'color:red; display:flex; width:100%; justify-content:center;';

// Ensure the current user is either the same as the userid OR has capability to view reports for others.
if ($USER->id != $userid && !has_capability('plagiarism/pd:viewfullreport', $context)) {
    throw new required_capability_exception($context, 'plagiarism/pd:viewfullreport', 'nopermissions', '');
}

// Get instance modules.
$cm = get_coursemodule_from_id($modulename, $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);

// Request login.
require_login($course, true, $cm);

// Setup page meta data.
$context = context_course::instance($cm->course);
$PAGE->set_course($course);
$PAGE->set_cm($cm);
$PAGE->set_pagelayout('incourse');
$PAGE->add_body_class('pd-report-page');
$PAGE->set_url('/moodle/plagiarism/pd/plagiarism_pd_report.php', [
    'cmid' => $cmid,
    'userid' => $userid,
    'externalid' => $externalid,
    'modulename' => $modulename,
]);

// Setup page title and header.
$user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);
$fs = get_file_storage();
$pagetitle = get_string('reportpagetitle', 'plagiarism_pd').' - '.fullname($user);
$PAGE->set_title($pagetitle);
$PAGE->set_heading($pagetitle);

if ($viewmode == 'course') {
    echo $OUTPUT->header();
}

// pd course settings.
$modulesettings = $DB->get_records_menu('plagiarism_pd_config', ['cm' => $cmid], '', 'name,value');

$isinstructor = plagiarism_plugin_pd::is_instructor($context);

$moduleenabled = 1;

// Check if pd plugin is disabled.
if (empty($moduleenabled) || empty($modulesettings['plagiarism_pd_enable'])) {
    echo html_writer::div(get_string('disabledformodule', 'plagiarism_pd'), null, ['style' => $errormessagestyle]);
} else {
    // Incase students not allowed to see the plagiairsm score.
    if (!$isinstructor && empty($modulesettings['plagiarism_pd_allowstudentaccess'])) {
        echo html_writer::div(get_string('nopageaccess', 'plagiarism_pd'), null, ['style' => $errormessagestyle]);
    } else {
        echo html_writer::tag(
            'iframe',
            null,
            [
                'title' => get_string('report_title', 'plagiarism_pd'),
                'srcdoc' => "<form target='_self'".
                    "method='GET'".
                    "style='display: none;'".
                    'action='.plagiarism_pd_api_base_url.'/plag/scan/mdl/report/'.$externalid.'>'.
                    '</form>'.
                    "<script type='text/javascript'>".
                    'window.document.forms[0].submit();'.
                    '</script>',
                'style' => $viewmode == 'course' ?
                        'width: 100%; height: calc(100vh - 87px); margin: 0px; padding: 0px; border: none;' :
                        'width: 100%; height: 100%; margin: 0px; padding: 0px; border: none;',
            ]
        );

        if ($viewmode == 'course') {
            echo html_writer::link(
                "$CFG->wwwroot/plagiarism/pd/plagiarism_pd_report.php".
                    "?cmid=$cmid&userid=$userid&externalid=$externalid&modulename=$modulename&view=fullscreen",
                get_string('openfullscreen', 'plagiarism_pd'),
                ['title' => get_string('openfullscreen', 'plagiarism_pd')]
            );
        }
    }
}

// Output footer.
if ($viewmode == 'course') {
    echo $OUTPUT->footer();
}

if ($viewmode == 'fullscreen') {
    echo html_writer::script(
        'window.document.body.style.margin=0;'
    );
}
