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

/*
 * @package   plagiarism_pd
 * @copyright 2025, PlagiarismDetector <support@plagiarismdetector.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => '\assignsubmission_file\event\assessable_uploaded',
        'callback' => 'plagiarism_pd_observer::assignsubmission_file_uploaded',
    ],
    [
        'eventname' => '\assignsubmission_onlinetext\event\assessable_uploaded',
        'callback' => 'plagiarism_pd_observer::assignsubmission_onlinetext_uploaded',
    ],
    [
        'eventname' => '\mod_workshop\event\assessable_uploaded',
        'callback' => 'plagiarism_pd_observer::workshop_file_uploaded',
    ],
    [
        'eventname' => '\mod_forum\event\assessable_uploaded',
        'callback' => 'plagiarism_pd_observer::forum_file_uploaded',
    ],
    [
        'eventname' => '\mod_assign\event\assessable_submitted',
        'callback' => 'plagiarism_pd_observer::assignsubmission_submitted',
    ],
    [
        'eventname' => '\mod_coursework\event\assessable_uploaded',
        'callback' => 'plagiarism_pd_observer::coursework_submitted',
    ],
    [
        'eventname' => '\mod_quiz\event\attempt_submitted',
        'callback' => 'plagiarism_pd_observer::quiz_submitted',
    ],
    [
        'eventname' => '\core\event\course_module_deleted',
        'callback' => 'plagiarism_pd_observer::course_module_deleted',
    ],
];
